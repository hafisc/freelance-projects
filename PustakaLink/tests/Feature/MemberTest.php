<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Member;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user petugas tiruan untuk autentikasi testing
        $this->user = User::create([
            'name' => 'Petugas Test',
            'email' => 'petugastest@pustakalink.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);
    }

    /**
     * Uji apakah petugas dapat melihat daftar anggota.
     */
    public function test_petugas_can_view_member_index(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('members.index'));

        $response->assertStatus(200);
        $response->assertViewHas('members');
    }

    /**
     * Uji apakah petugas dapat menambah anggota baru dengan data valid.
     */
    public function test_petugas_can_create_member(): void
    {
        $memberData = [
            'member_code' => 'AGT-9999',
            'name' => 'Anggota Test PHPUnit',
            'gender' => 'Laki-laki',
            'phone' => '0812345678',
            'address' => 'Alamat Anggota Test',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('members.store'), $memberData);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', [
            'member_code' => 'AGT-9999',
            'name' => 'Anggota Test PHPUnit',
        ]);
    }

    /**
     * Uji apakah petugas dapat mengubah informasi data anggota.
     */
    public function test_petugas_can_update_member(): void
    {
        $member = Member::create([
            'member_code' => 'AGT-0101',
            'name' => 'Anggota Sebelum Diubah',
            'gender' => 'Perempuan',
            'phone' => '08112233',
        ]);

        $updatedData = [
            'member_code' => 'AGT-0101',
            'name' => 'Anggota Sesudah Diubah',
            'gender' => 'Perempuan',
            'phone' => '08998877',
            'address' => 'Alamat baru',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('members.update', $member->id), $updatedData);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'name' => 'Anggota Sesudah Diubah',
            'phone' => '08998877',
        ]);
    }

    /**
     * Uji apakah petugas dapat menghapus anggota.
     */
    public function test_petugas_can_delete_member(): void
    {
        $member = Member::create([
            'member_code' => 'AGT-0202',
            'name' => 'Anggota Untuk Dihapus',
            'gender' => 'Laki-laki',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('members.destroy', $member->id));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('members', [
            'id' => $member->id,
        ]);
    }
}
