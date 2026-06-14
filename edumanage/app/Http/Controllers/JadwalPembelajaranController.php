<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JadwalPembelajaran;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\MataKuliah;

class JadwalPembelajaranController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal pembelajaran (Admin).
     */
    public function index()
    {
        $jadwal = JadwalPembelajaran::with('kelas', 'dosen', 'mataKuliah')->latest()->paginate(10);
        return view('admin.jadwal-pembelajaran.index', compact('jadwal'));
    }

    /**
     * Menampilkan form tambah jadwal baru.
     */
    public function create()
    {
        $kelas = Kelas::all();
        $dosen = Dosen::all();
        $mataKuliah = MataKuliah::all();
        return view('admin.jadwal-pembelajaran.create', compact('kelas', 'dosen', 'mataKuliah'));
    }

    /**
     * Menyimpan data jadwal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
        ], [
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'dosen_id.required' => 'Dosen wajib dipilih.',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'hari.required' => 'Hari wajib dipilih.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'ruangan.required' => 'Ruangan wajib diisi.',
        ]);

        JadwalPembelajaran::create($request->all());

        return redirect()->route('jadwal-pembelajaran.index')->with('success', 'Jadwal pembelajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail jadwal (alihkan ke index).
     */
    public function show(string $id)
    {
        return redirect()->route('jadwal-pembelajaran.index');
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(string $id)
    {
        $jadwal = JadwalPembelajaran::findOrFail($id);
        $kelas = Kelas::all();
        $dosen = Dosen::all();
        $mataKuliah = MataKuliah::all();
        return view('admin.jadwal-pembelajaran.edit', compact('jadwal', 'kelas', 'dosen', 'mataKuliah'));
    }

    /**
     * Memperbarui data jadwal di database.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = JadwalPembelajaran::findOrFail($id);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
        ], [
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal-pembelajaran.index')->with('success', 'Jadwal pembelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus data jadwal dari database.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalPembelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal-pembelajaran.index')->with('success', 'Jadwal pembelajaran berhasil dihapus.');
    }

    /**
     * Menampilkan jadwal mengajar milik Dosen bersangkutan.
     */
    public function jadwalDosen()
    {
        $dosen = auth()->user()->dosen;
        
        if (!$dosen) {
            return redirect()->route('dashboard')->with('error', 'Profil dosen tidak ditemukan.');
        }

        $jadwals = JadwalPembelajaran::with('kelas', 'mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->latest()
            ->paginate(10);

        return view('dosen.jadwal.index', compact('jadwals', 'dosen'));
    }

    /**
     * Menampilkan jadwal kuliah milik Mahasiswa bersangkutan.
     */
    public function jadwalMahasiswa()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Cari kelas mahasiswa berdasarkan prodi & angkatan yang sama
        $kelas = Kelas::where('prodi', $mahasiswa->prodi)
            ->where('angkatan', $mahasiswa->angkatan)
            ->first();

        $jadwals = collect();
        if ($kelas) {
            $jadwals = JadwalPembelajaran::with('dosen', 'mataKuliah')
                ->where('kelas_id', $kelas->id)
                ->paginate(10);
        }

        return view('mahasiswa.jadwal.index', compact('jadwals', 'mahasiswa', 'kelas'));
    }

    /**
     * Menampilkan monitoring jadwal kuliah global untuk Kaprodi.
     */
    public function monitoringJadwal()
    {
        $jadwal = JadwalPembelajaran::with('kelas', 'dosen', 'mataKuliah')->latest()->paginate(10);
        return view('kaprodi.jadwal.index', compact('jadwal'));
    }
}
