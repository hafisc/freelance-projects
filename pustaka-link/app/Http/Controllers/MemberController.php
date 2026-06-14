<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar anggota perpustakaan.
     * Mendukung fitur pencarian berdasarkan nama atau kode anggota.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('member_code', 'like', "%{$search}%");
        })
        ->orderBy('member_code', 'asc')
        ->paginate(10)
        ->withQueryString();

        return view('members.index', compact('members', 'search'));
    }

    /**
     * Menampilkan form untuk mendaftarkan anggota baru.
     */
    public function create()
    {
        // Generate otomatis member code rekomendasi jika diinginkan
        $lastMember = Member::orderBy('id', 'desc')->first();
        $nextCode = 'AGT-0001';
        if ($lastMember) {
            $lastNum = (int) substr($lastMember->member_code, 4);
            $nextCode = 'AGT-' . sprintf('%04d', $lastNum + 1);
        }

        return view('members.create', compact('nextCode'));
    }

    /**
     * Menyimpan data anggota baru ke database.
     * Menggunakan StoreMemberRequest untuk validasi.
     */
    public function store(StoreMemberRequest $request)
    {
        Member::create($request->validated());

        return redirect()->route('members.index')
            ->with('toast_success', 'Data anggota baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan informasi detail anggota beserta riwayat transaksi peminjamannya.
     */
    public function show(Member $member)
    {
        // Eager load data peminjaman beserta detail buku
        $member->load(['borrowings' => function ($query) {
            $query->orderBy('borrow_date', 'desc');
        }, 'borrowings.borrowingDetails.book']);

        return view('members.show', compact('member'));
    }

    /**
     * Menampilkan form untuk mengedit data anggota.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Memperbarui data anggota di database.
     * Menggunakan UpdateMemberRequest untuk validasi.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return redirect()->route('members.index')
            ->with('toast_success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Menghapus data anggota dari database.
     * Mencegah penghapusan jika anggota memiliki riwayat transaksi peminjaman (foreign key constraint).
     */
    public function destroy(Member $member)
    {
        // Cek jika anggota masih memiliki relasi peminjaman di database
        if ($member->borrowings()->exists()) {
            return redirect()->route('members.index')
                ->with('toast_error', 'Gagal menghapus! Anggota ini masih memiliki riwayat transaksi peminjaman.');
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('toast_success', 'Data anggota berhasil dihapus.');
    }
}
