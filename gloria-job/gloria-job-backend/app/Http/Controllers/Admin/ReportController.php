<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ReportController extends Controller
{
    // Menampilkan halaman utama laporan dengan filter dan statistik
    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $categories = Job::whereNotNull('category')->distinct()->pluck('category');

        // Filter parameters
        $companyId = $request->get('company_id');
        $category = $request->get('category');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Query dasar
        $query = JobApplication::with(['job.company', 'user']);

        if ($companyId) {
            $query->whereHas('job', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        if ($category) {
            $query->whereHas('job', function ($q) use ($category) {
                $q->where('category', $category);
            });
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistik ringkasan per perusahaan
        $companyStats = Company::withCount(['jobs', 'applications'])
            ->with(['applications' => function ($q) {
                $q->select('job_applications.*');
            }])
            ->get()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'total_jobs' => $company->jobs_count,
                    'total_applications' => $company->applications_count,
                    'pending' => $company->applications->where('status', 'Menunggu')->count(),
                    'processing' => $company->applications->where('status', 'Diproses')->count(),
                    'accepted' => $company->applications->where('status', 'Diterima')->count(),
                    'rejected' => $company->applications->where('status', 'Ditolak')->count(),
                ];
            });

        // Statistik ringkasan per kategori
        $categoryStats = Job::whereNotNull('category')
            ->withCount('applications')
            ->get()
            ->groupBy('category')
            ->map(function ($jobs, $category) {
                $allApplications = $jobs->flatMap->applications;
                return [
                    'category' => $category,
                    'total_jobs' => $jobs->count(),
                    'total_applications' => $jobs->sum('applications_count'),
                    'pending' => $allApplications->where('status', 'Menunggu')->count(),
                    'processing' => $allApplications->where('status', 'Diproses')->count(),
                    'accepted' => $allApplications->where('status', 'Diterima')->count(),
                    'rejected' => $allApplications->where('status', 'Ditolak')->count(),
                ];
            })->values();

        return view('admin.reports.index', compact(
            'companies', 'categories', 'applications',
            'companyStats', 'categoryStats',
            'companyId', 'category', 'dateFrom', 'dateTo'
        ));
    }

    // Mengembalikan data statistik dalam format JSON untuk grafik Chart.js
    public function statistics()
    {
        // Lamaran per bulan (6 bulan terakhir)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = JobApplication::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }

        // Lamaran per status
        $statusData = [
            'Menunggu' => JobApplication::where('status', 'Menunggu')->count(),
            'Diproses' => JobApplication::where('status', 'Diproses')->count(),
            'Diterima' => JobApplication::where('status', 'Diterima')->count(),
            'Ditolak'  => JobApplication::where('status', 'Ditolak')->count(),
        ];

        // Lamaran per perusahaan (top 10)
        $companyData = Company::withCount('applications')
            ->orderByDesc('applications_count')
            ->take(10)
            ->get()
            ->map(function ($c) {
                return ['name' => $c->name, 'count' => $c->applications_count];
            });

        // Lamaran per kategori
        $categoryData = Job::with('applications')
            ->whereNotNull('category')
            ->get()
            ->groupBy('category')
            ->map(function ($jobs, $cat) {
                return ['category' => $cat, 'count' => $jobs->sum(fn($j) => $j->applications->count())];
            })->values();

        return response()->json([
            'monthly' => $monthlyData,
            'status' => $statusData,
            'company' => $companyData,
            'category' => $categoryData,
        ]);
    }

    // Mengekspor laporan terfilter ke file Excel (.xlsx)
    public function exportExcel(Request $request)
    {
        $query = JobApplication::with(['job.company', 'user']);

        $companyId = $request->get('company_id');
        $category = $request->get('category');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $filterLabel = 'Semua Data';

        if ($companyId) {
            $query->whereHas('job', fn($q) => $q->where('company_id', $companyId));
            $company = Company::find($companyId);
            $filterLabel = 'Perusahaan: ' . ($company->name ?? 'Unknown');
        }
        if ($category) {
            $query->whereHas('job', fn($q) => $q->where('category', $category));
            $filterLabel .= ($filterLabel !== 'Semua Data' ? ' | ' : '') . 'Kategori: ' . $category;
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
            $filterLabel .= ' | Dari: ' . $dateFrom;
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
            $filterLabel .= ' | Sampai: ' . $dateTo;
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pelamar');

        // Judul
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PELAMAR KERJA — PT. Gloria Jasa Mandiri');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE8F0FE']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Filter info
        $sheet->mergeCells('A2:M2');
        $sheet->setCellValue('A2', 'Filter: ' . $filterLabel . '  |  Diekspor: ' . now()->format('d/m/Y H:i') . ' WIB  |  Total: ' . $applications->count());
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFC']],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(6);

        // Header
        $headers = ['No', 'Nama Lengkap', 'Email', 'No. HP', 'Alamat',
                    'Posisi Dilamar', 'Perusahaan', 'Kategori', 'Gaji',
                    'Tanggal Melamar', 'Status', 'Catatan Pelamar', 'Catatan Admin'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }
        $sheet->getStyle('A4:M4')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF2D4E7C']]],
        ]);

        $statusColors = [
            'Menunggu' => ['bg' => 'FFFFF8E1', 'font' => 'FF92400E'],
            'Diproses' => ['bg' => 'FFE0F2FE', 'font' => 'FF075985'],
            'Diterima' => ['bg' => 'FFD1FAE5', 'font' => 'FF065F46'],
            'Ditolak'  => ['bg' => 'FFFEE2E2', 'font' => 'FF991B1B'],
        ];

        foreach ($applications as $index => $app) {
            $row = $index + 5;
            $status = $app->status;
            $rowBg = ($index % 2 === 0) ? 'FFFFFFFF' : 'FFF8FAFC';

            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $app->full_name);
            $sheet->setCellValue("C{$row}", $app->email);
            $sheet->setCellValueExplicit("D{$row}", $app->phone, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$row}", $app->address);
            $sheet->setCellValue("F{$row}", $app->job->title ?? 'Posisi Terhapus');
            $sheet->setCellValue("G{$row}", $app->job->company_display_name ?? '-');
            $sheet->setCellValue("H{$row}", $app->job->category ?? '-');
            $sheet->setCellValue("I{$row}", $app->job->salary_display ?? '-');
            $sheet->setCellValue("J{$row}", $app->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue("K{$row}", $status);
            $sheet->setCellValue("L{$row}", $app->note ?? '-');
            $sheet->setCellValue("M{$row}", $app->admin_note ?? '-');

            $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                'font'      => ['size' => 9],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]],
            ]);

            if (isset($statusColors[$status])) {
                $sheet->getStyle("K{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9, 'color' => ['argb' => $statusColors[$status]['font']]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $statusColors[$status]['bg']]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        $colWidths = ['A'=>5, 'B'=>22, 'C'=>28, 'D'=>16, 'E'=>30, 'F'=>25, 'G'=>22, 'H'=>16, 'I'=>20, 'J'=>18, 'K'=>14, 'L'=>30, 'M'=>30];
        foreach ($colWidths as $c => $width) {
            $sheet->getColumnDimension($c)->setWidth($width);
        }
        $sheet->freezePane('A5');

        $filename = 'laporan-pelamar-' . now()->format('Ymd-His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
