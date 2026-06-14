<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KegiatanBelajar;
use App\Models\JadwalPembelajaran;
use App\Models\Kelas;

class KegiatanBelajarController extends Controller
{
    /**
     * Menampilkan daftar semua kegiatan belajar (Admin).
     */
    public function index()
    {
        $kegiatan = KegiatanBelajar::with('jadwalPembelajaran.kelas', 'jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')
            ->latest()
            ->paginate(10);
            
        return view('admin.kegiatan-belajar.index', compact('kegiatan'));
    }

    /**
     * Menampilkan form tambah kegiatan baru (Admin).
     */
    public function create()
    {
        $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah', 'dosen')->get();
        return view('admin.kegiatan-belajar.create', compact('jadwals'));
    }

    /**
     * Menyimpan data kegiatan baru ke database (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pembelajaran_id' => 'required|exists:jadwal_pembelajaran,id',
            'pertemuan_ke' => 'required|numeric|min:1|max:16',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'metode_pembelajaran' => 'required|string|max:100',
            'tugas' => 'nullable|string',
            'status' => 'required|in:terjadwal,berlangsung,selesai',
            'catatan' => 'nullable|string',
            'kehadiran_hadir' => 'nullable|integer|min:0',
            'kehadiran_sakit' => 'nullable|integer|min:0',
            'kehadiran_izin' => 'nullable|integer|min:0',
            'kehadiran_alfa' => 'nullable|integer|min:0',
        ], [
            'jadwal_pembelajaran_id.required' => 'Jadwal pembelajaran wajib dipilih.',
            'pertemuan_ke.required' => 'Pertemuan ke- wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'materi.required' => 'Materi pembelajaran wajib diisi.',
            'metode_pembelajaran.required' => 'Metode pembelajaran wajib diisi.',
            'status.required' => 'Status kegiatan wajib dipilih.',
        ]);

        KegiatanBelajar::create($request->all());

        return redirect()->route('kegiatan-belajar.index')->with('success', 'Kegiatan belajar berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kegiatan belajar.
     */
    public function show(string $id)
    {
        $kegiatan = KegiatanBelajar::with('jadwalPembelajaran.kelas', 'jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')->findOrFail($id);
        return view('admin.kegiatan-belajar.show', compact('kegiatan'));
    }

    /**
     * Menampilkan form edit kegiatan (Admin).
     */
    public function edit(string $id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
        $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah', 'dosen')->get();
        return view('admin.kegiatan-belajar.edit', compact('kegiatan', 'jadwals'));
    }

    /**
     * Memperbarui data kegiatan di database (Admin).
     */
    public function update(Request $request, string $id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);

        $request->validate([
            'jadwal_pembelajaran_id' => 'required|exists:jadwal_pembelajaran,id',
            'pertemuan_ke' => 'required|numeric|min:1|max:16',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'metode_pembelajaran' => 'required|string|max:100',
            'tugas' => 'nullable|string',
            'status' => 'required|in:terjadwal,berlangsung,selesai',
            'catatan' => 'nullable|string',
            'kehadiran_hadir' => 'nullable|integer|min:0',
            'kehadiran_sakit' => 'nullable|integer|min:0',
            'kehadiran_izin' => 'nullable|integer|min:0',
            'kehadiran_alfa' => 'nullable|integer|min:0',
        ]);

        $kegiatan->update($request->all());

        return redirect()->route('kegiatan-belajar.index')->with('success', 'Kegiatan belajar berhasil diperbarui.');
    }

    /**
     * Menghapus data kegiatan dari database (Admin).
     */
    public function destroy(string $id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan-belajar.index')->with('success', 'Kegiatan belajar berhasil dihapus.');
    }

    // ==========================================
    // SEKSI KHUSUS DOSEN
    // ==========================================

    /**
     * Menampilkan daftar kegiatan belajar milik dosen yang login.
     */
    public function kegiatanDosen()
    {
        $dosen = auth()->user()->dosen;
        if (!$dosen) {
            return redirect()->route('dashboard')->with('error', 'Profil dosen tidak ditemukan.');
        }

        // Ambil jadwal mengajar dosen
        $jadwalIds = JadwalPembelajaran::where('dosen_id', $dosen->id)->pluck('id');

        $kegiatan = KegiatanBelajar::with('jadwalPembelajaran.kelas', 'jadwalPembelajaran.mataKuliah')
            ->whereIn('jadwal_pembelajaran_id', $jadwalIds)
            ->latest()
            ->paginate(10);

        return view('dosen.kegiatan.index', compact('kegiatan', 'dosen'));
    }

    /**
     * Menampilkan form tambah kegiatan bagi dosen (terbatas pada jadwalnya sendiri).
     */
    public function createKegiatanDosen()
    {
        $dosen = auth()->user()->dosen;
        if (!$dosen) {
            return redirect()->route('dashboard')->with('error', 'Profil dosen tidak ditemukan.');
        }

        // Hanya jadwal milik dosen bersangkutan yang bisa dipilih
        $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->get();

        return view('dosen.kegiatan.create', compact('jadwals', 'dosen'));
    }

    /**
     * Menyimpan kegiatan belajar baru dari dosen.
     */
    public function storeKegiatanDosen(Request $request)
    {
        $dosen = auth()->user()->dosen;
        
        $request->validate([
            'jadwal_pembelajaran_id' => 'required|exists:jadwal_pembelajaran,id',
            'pertemuan_ke' => 'required|numeric|min:1|max:16',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'metode_pembelajaran' => 'required|string|max:100',
            'tugas' => 'nullable|string',
            'status' => 'required|in:terjadwal,berlangsung,selesai',
            'catatan' => 'nullable|string',
            'kehadiran_hadir' => 'nullable|integer|min:0',
            'kehadiran_sakit' => 'nullable|integer|min:0',
            'kehadiran_izin' => 'nullable|integer|min:0',
            'kehadiran_alfa' => 'nullable|integer|min:0',
        ]);

        // Proteksi agar dosen tidak input kegiatan untuk jadwal orang lain
        $jadwal = JadwalPembelajaran::findOrFail($request->jadwal_pembelajaran_id);
        if ($jadwal->dosen_id !== $dosen->id) {
            return back()->with('error', 'Anda tidak berwenang menambahkan kegiatan ke jadwal ini.');
        }

        KegiatanBelajar::create($request->all());

        return redirect()->route('dosen.kegiatan')->with('success', 'Kegiatan belajar berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kegiatan bagi dosen (hanya miliknya).
     */
    public function editKegiatanDosen($id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
        $dosen = auth()->user()->dosen;

        // Proteksi kepemilikan jadwal kegiatan
        if ($kegiatan->jadwalPembelajaran->dosen_id !== $dosen->id) {
            return redirect()->route('dosen.kegiatan')->with('error', 'Anda tidak berwenang mengedit kegiatan ini.');
        }

        $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->get();

        return view('dosen.kegiatan.edit', compact('kegiatan', 'jadwals', 'dosen'));
    }

    /**
     * Memperbarui kegiatan dari dosen.
     */
    public function updateKegiatanDosen(Request $request, $id)
    {
        $kegiatan = KegiatanBelajar::findOrFail($id);
        $dosen = auth()->user()->dosen;

        // Proteksi kepemilikan
        if ($kegiatan->jadwalPembelajaran->dosen_id !== $dosen->id) {
            return redirect()->route('dosen.kegiatan')->with('error', 'Anda tidak berwenang memperbarui kegiatan ini.');
        }

        $request->validate([
            'jadwal_pembelajaran_id' => 'required|exists:jadwal_pembelajaran,id',
            'pertemuan_ke' => 'required|numeric|min:1|max:16',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'metode_pembelajaran' => 'required|string|max:100',
            'tugas' => 'nullable|string',
            'status' => 'required|in:terjadwal,berlangsung,selesai',
            'catatan' => 'nullable|string',
            'kehadiran_hadir' => 'nullable|integer|min:0',
            'kehadiran_sakit' => 'nullable|integer|min:0',
            'kehadiran_izin' => 'nullable|integer|min:0',
            'kehadiran_alfa' => 'nullable|integer|min:0',
        ]);

        $kegiatan->update($request->all());

        return redirect()->route('dosen.kegiatan')->with('success', 'Kegiatan belajar berhasil diperbarui.');
    }



    // ==========================================
    // SEKSI KHUSUS MAHASISWA
    // ==========================================

    /**
     * Menampilkan kegiatan pembelajaran kelas mahasiswa bersangkutan.
     */
    public function kegiatanMahasiswa()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Cari kelas
        $kelas = Kelas::where('prodi', $mahasiswa->prodi)
            ->where('angkatan', $mahasiswa->angkatan)
            ->first();

        $kegiatan = collect();
        if ($kelas) {
            $jadwalIds = JadwalPembelajaran::where('kelas_id', $kelas->id)->pluck('id');
            $kegiatan = KegiatanBelajar::with('jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')
                ->whereIn('jadwal_pembelajaran_id', $jadwalIds)
                ->latest()
                ->paginate(10);
        }

        return view('mahasiswa.kegiatan.index', compact('kegiatan', 'mahasiswa', 'kelas'));
    }

    // ==========================================
    // SEKSI KHUSUS KAPRODI
    // ==========================================

    /**
     * Menampilkan seluruh kegiatan prodi untuk monitoring Kaprodi.
     */
    public function monitoringKegiatan()
    {
        $kegiatan = KegiatanBelajar::with('jadwalPembelajaran.kelas', 'jadwalPembelajaran.mataKuliah', 'jadwalPembelajaran.dosen')
            ->latest()
            ->paginate(10);

        return view('kaprodi.kegiatan.index', compact('kegiatan'));
    }
}
