<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk memperbarui data anggota.
     */
    public function rules(): array
    {
        $memberId = $this->route('member') instanceof \App\Models\Member 
            ? $this->route('member')->id 
            : $this->route('member');

        return [
            'member_code' => ['required', 'string', 'max:50', 'unique:members,member_code,' . $memberId],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi.
     */
    public function messages(): array
    {
        return [
            'member_code.required' => 'Kode anggota wajib diisi.',
            'member_code.unique' => 'Kode anggota sudah digunakan oleh anggota lain.',
            'name.required' => 'Nama anggota wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
        ];
    }
}
