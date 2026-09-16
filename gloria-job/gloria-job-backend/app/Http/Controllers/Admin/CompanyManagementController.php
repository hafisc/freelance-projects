<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class CompanyManagementController extends Controller
{
    // Menampilkan daftar perusahaan beserta statistik singkat
    public function index()
    {
        $companies = Company::withCount(['jobs', 'applications'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.companies.index', compact('companies'));
    }

    // Menampilkan form tambah perusahaan baru
    public function create()
    {
        return view('admin.companies.create');
    }

    // Menyimpan data perusahaan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'industry' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:20',
        ]);

        $data = $request->except('logo');

        // Upload logo perusahaan jika ada
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $data['logo'] = $file->storeAs('company-logos', $fileName, 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil ditambahkan!');
    }

    // Menampilkan detail perusahaan beserta lowongan dan pelamar terkait
    public function show($id)
    {
        $company = Company::with(['jobs.applications.user'])->findOrFail($id);

        $totalJobs = $company->jobs->count();
        $totalApplications = $company->jobs->sum(function ($job) {
            return $job->applications->count();
        });
        $pendingApplications = $company->jobs->sum(function ($job) {
            return $job->applications->where('status', 'Menunggu')->count();
        });
        $acceptedApplications = $company->jobs->sum(function ($job) {
            return $job->applications->where('status', 'Diterima')->count();
        });
        $rejectedApplications = $company->jobs->sum(function ($job) {
            return $job->applications->where('status', 'Ditolak')->count();
        });

        return view('admin.companies.show', compact(
            'company', 'totalJobs', 'totalApplications',
            'pendingApplications', 'acceptedApplications', 'rejectedApplications'
        ));
    }

    // Menampilkan form edit data perusahaan
    public function edit($id)
    {
        $company = Company::findOrFail($id);

        return view('admin.companies.edit', compact('company'));
    }

    // Memperbarui data perusahaan di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'industry' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:20',
        ]);

        $company = Company::findOrFail($id);
        $data = $request->except('logo');

        // Upload logo baru jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $file = $request->file('logo');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $data['logo'] = $file->storeAs('company-logos', $fileName, 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    // Menghapus data perusahaan dari database
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Hapus logo dari storage
        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil dihapus!');
    }

    // Mengekspor data pelamar untuk perusahaan tertentu ke Excel lalu menandai sebagai shared
    public function shareApplications($id)
    {
        $company = Company::findOrFail($id);
        $applications = JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($q) use ($id) {
                $q->where('company_id', $id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($applications->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data pelamar untuk diekspor.');
        }

        // Tandai semua lamaran sebagai sudah di-share
        foreach ($applications as $app) {
            if (!$app->cv_shared_at) {
                $app->update(['cv_shared_at' => now()]);
            }
        }

        // Generate Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pelamar');

        // Judul
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'DATA PELAMAR — ' . strtoupper($company->name));
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE8F0FE']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Sub-judul
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->format('d/m/Y H:i') . ' WIB  |  Total Pelamar: ' . $applications->count());
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFC']],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(6);

        // Header
        $headers = ['No', 'Nama Lengkap', 'Email', 'No. HP', 'Alamat Domisili',
                    'Posisi Dilamar', 'Kategori', 'Gaji', 'Tanggal Melamar',
                    'Status Lamaran', 'CV Tersedia', 'Catatan Pelamar'];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }

        $sheet->getStyle('A4:L4')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF2D4E7C']]],
        ]);

        // Data
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
            $sheet->setCellValue("G{$row}", $app->job->category ?? '-');
            $sheet->setCellValue("H{$row}", $app->job->salary_display ?? '-');
            $sheet->setCellValue("I{$row}", $app->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue("J{$row}", $status);
            $sheet->setCellValue("K{$row}", $app->cv_path ? 'Ya' : 'Tidak');
            $sheet->setCellValue("L{$row}", $app->note ?? '-');

            $sheet->getStyle("A{$row}:L{$row}")->applyFromArray([
                'font'      => ['size' => 9],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]],
            ]);

            if (isset($statusColors[$status])) {
                $sheet->getStyle("J{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9, 'color' => ['argb' => $statusColors[$status]['font']]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $statusColors[$status]['bg']]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        // Lebar kolom
        $colWidths = ['A'=>5, 'B'=>22, 'C'=>28, 'D'=>16, 'E'=>35, 'F'=>28, 'G'=>16, 'H'=>20, 'I'=>18, 'J'=>14, 'K'=>12, 'L'=>30];
        foreach ($colWidths as $c => $width) {
            $sheet->getColumnDimension($c)->setWidth($width);
        }
        $sheet->freezePane('A5');

        $filename = 'pelamar-' . str_replace(' ', '-', strtolower($company->name)) . '-' . now()->format('Ymd-His') . '.xlsx';
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
