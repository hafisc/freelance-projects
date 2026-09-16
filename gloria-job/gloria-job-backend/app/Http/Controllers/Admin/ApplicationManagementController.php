<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Notification;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\Storage;

class ApplicationManagementController extends Controller
{
    // Menampilkan daftar lamaran masuk dari pelamar dengan filter opsional
    public function index(Request $request)
    {
        $query = JobApplication::with(['job.company', 'user']);

        // Filter per perusahaan
        if ($request->filled('company_id')) {
            $query->whereHas('job', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        // Filter per kategori
        if ($request->filled('category')) {
            $query->whereHas('job', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Filter per status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Data untuk dropdown filter
        $companies = Company::orderBy('name')->get();
        $categories = Job::whereNotNull('category')->distinct()->pluck('category');

        return view('admin.applications.index', compact('applications', 'companies', 'categories'));
    }

    // Menampilkan detail lamaran tertentu
    public function show($id)
    {
        $application = JobApplication::with(['job.company', 'user'])->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    // Mengekspor seluruh data pelamar ke dalam file Excel (.xlsx) yang terformat rapi
    public function exportCsv(Request $request)
    {
        $query = JobApplication::with(['job.company', 'user']);

        // Terapkan filter yang sama seperti halaman index
        if ($request->filled('company_id')) {
            $query->whereHas('job', fn($q) => $q->where('company_id', $request->company_id));
        }
        if ($request->filled('category')) {
            $query->whereHas('job', fn($q) => $q->where('category', $request->category));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pelamar');

        // ── Baris 1: Judul Laporan ──────────────────────────────────────────
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'DATA PELAMAR KERJA — PT. Gloria Jasa Mandiri');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE8F0FE']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // ── Baris 2: Tanggal Export ─────────────────────────────────────────
        $sheet->mergeCells('A2:M2');
        $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->format('d/m/Y H:i') . ' WIB  |  Total Pelamar: ' . $applications->count());
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFC']],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ── Baris 3: Kosong (spacer) ────────────────────────────────────────
        $sheet->getRowDimension(3)->setRowHeight(6);

        // ── Baris 4: Header Kolom ───────────────────────────────────────────
        $headers = ['No', 'Nama Lengkap', 'Email', 'No. HP', 'Alamat Domisili',
                    'Posisi Dilamar', 'Perusahaan', 'Kategori', 'Gaji',
                    'Tanggal Melamar', 'Status Lamaran', 'Catatan Pelamar', 'Catatan Admin'];

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
        $sheet->getRowDimension(4)->setRowHeight(22);

        // ── Status warna cell ───────────────────────────────────────────────
        $statusColors = [
            'Menunggu' => ['bg' => 'FFFFF8E1', 'font' => 'FF92400E'],
            'Diproses' => ['bg' => 'FFE0F2FE', 'font' => 'FF075985'],
            'Diterima' => ['bg' => 'FFD1FAE5', 'font' => 'FF065F46'],
            'Ditolak'  => ['bg' => 'FFFEE2E2', 'font' => 'FF991B1B'],
        ];

        // ── Isi Data (mulai baris 5) ────────────────────────────────────────
        foreach ($applications as $index => $app) {
            $row = $index + 5;
            $status = $app->status;

            // Zebra stripe baris genap/ganjil
            $rowBg = ($index % 2 === 0) ? 'FFFFFFFF' : 'FFF8FAFC';

            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $app->full_name);
            $sheet->setCellValue("C{$row}", $app->email);

            // No. HP — paksa sebagai string agar tidak jadi scientific notation
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

            // Style baris data (background zebra + border)
            $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                'font'      => ['size' => 9],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE2E8F0']]],
            ]);

            // Kolom No rata tengah
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Warna khusus kolom Status
            if (isset($statusColors[$status])) {
                $sheet->getStyle("K{$row}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9, 'color' => ['argb' => $statusColors[$status]['font']]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $statusColors[$status]['bg']]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        }

        // ── Lebar Kolom ─────────────────────────────────────────────────────
        $colWidths = [
            'A' => 5, 'B' => 22, 'C' => 28, 'D' => 16, 'E' => 35,
            'F' => 28, 'G' => 22, 'H' => 16, 'I' => 20,
            'J' => 18, 'K' => 14, 'L' => 30, 'M' => 35,
        ];
        foreach ($colWidths as $c => $width) {
            $sheet->getColumnDimension($c)->setWidth($width);
        }

        // ── Freeze header (baris 1–4 tetap saat scroll) ─────────────────────
        $sheet->freezePane('A5');

        // ── Output sebagai file .xlsx ────────────────────────────────────────
        $filename = 'data-pelamar-' . now()->format('Ymd-His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    // Memperbarui status lamaran pelamar dan memberikan catatan admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Diterima,Ditolak',
            'admin_note' => 'nullable|string',
        ]);

        $application = JobApplication::with('job')->findOrFail($id);
        $application->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        // Buat notifikasi otomatis untuk pencari kerja (user)
        Notification::create([
            'user_id' => $application->user_id,
            'title' => 'Status Lamaran Diperbarui',
            'message' => 'Lamaran Anda untuk posisi ' . ($application->job ? $application->job->title : 'Pekerjaan') . ' saat ini berstatus: ' . $request->status . '.' . ($request->admin_note ? ' Catatan admin: ' . $request->admin_note : ''),
            'is_read' => false,
        ]);

        return redirect()->route('admin.applications.show', $id)
            ->with('success', 'Status lamaran pelamar berhasil diperbarui!');
    }

    // Menandai lamaran sebagai sudah di-share ke perusahaan
    public function shareToCompany($id)
    {
        $application = JobApplication::with('job.company')->findOrFail($id);

        if (!$application->job || !$application->job->company) {
            return redirect()->back()->with('error', 'Lamaran ini tidak terhubung ke perusahaan manapun.');
        }

        $application->update(['cv_shared_at' => now()]);

        return redirect()->back()->with('success', 'Data pelamar berhasil ditandai sebagai shared ke ' . $application->job->company->name . '!');
    }

    // Mengunduh atau melihat CV secara aman
    public function downloadCv($id)
    {
        $application = JobApplication::with('user')->findOrFail($id);

        $path = $application->cv_path ?: ($application->user ? $application->user->cv : null);

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->response($path);
        }

        return redirect()->back()->with('error', 'File CV tidak ditemukan di server.');
    }
}

