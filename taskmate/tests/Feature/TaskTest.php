<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan tamu (guest) yang belum login tidak bisa mengakses halaman utama.
     */
    public function test_guest_cannot_access_protected_pages(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/tasks')->assertRedirect('/login');
        $this->get('/calendar')->assertRedirect('/login');
    }

    /**
     * Memastikan user yang login dapat menambahkan tugas baru.
     */
    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/tasks', [
                'title' => 'Tugas Matematika',
                'description' => 'Mengerjakan halaman 20',
                'category' => 'Kuliah',
                'deadline' => '2026-06-15',
                'status' => 'belum_dikerjakan',
                'priority' => 'tinggi',
            ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Tugas Matematika',
            'status' => 'belum_dikerjakan',
        ]);
    }

    /**
     * Memastikan validasi form tambah tugas bekerja.
     */
    public function test_create_task_requires_title_and_deadline(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/tasks', [
                'title' => '',
                'deadline' => '',
            ]);

        $response->assertSessionHasErrors(['title', 'deadline']);
    }

    /**
     * Memastikan isolasi data (data scoping): user tidak bisa melihat tugas milik user lain.
     */
    public function test_user_only_sees_own_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskA = Task::create([
            'user_id' => $userA->id,
            'title' => 'Tugas User A',
            'deadline' => '2026-06-15',
            'status' => 'belum_dikerjakan',
            'priority' => 'sedang',
        ]);

        $taskB = Task::create([
            'user_id' => $userB->id,
            'title' => 'Tugas User B',
            'deadline' => '2026-06-15',
            'status' => 'belum_dikerjakan',
            'priority' => 'sedang',
        ]);

        // Login sebagai User A, harus melihat tugas A tapi tidak tugas B
        $response = $this->actingAs($userA)->get('/tasks');
        $response->assertStatus(200);
        $response->assertSee($taskA->title);
        $response->assertDontSee($taskB->title);
    }

    /**
     * Memastikan user tidak dapat mengedit/mengupdate tugas milik user lain.
     */
    public function test_user_cannot_edit_other_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskB = Task::create([
            'user_id' => $userB->id,
            'title' => 'Tugas User B',
            'deadline' => '2026-06-15',
            'status' => 'belum_dikerjakan',
            'priority' => 'sedang',
        ]);

        // Coba akses form edit tugas B sebagai User A, harus 403 Forbidden
        $this->actingAs($userA)
            ->get("/tasks/{$taskB->id}/edit")
            ->assertStatus(403);

        // Coba kirim update request tugas B sebagai User A, harus 403 Forbidden
        $this->actingAs($userA)
            ->patch("/tasks/{$taskB->id}", [
                'title' => 'Ubah Paksa',
                'deadline' => '2026-06-20',
                'status' => 'selesai',
                'priority' => 'tinggi',
            ])
            ->assertStatus(403);
    }

    /**
     * Memastikan user tidak dapat menghapus tugas milik user lain.
     */
    public function test_user_cannot_delete_other_users_task(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskB = Task::create([
            'user_id' => $userB->id,
            'title' => 'Tugas User B',
            'deadline' => '2026-06-15',
            'status' => 'belum_dikerjakan',
            'priority' => 'sedang',
        ]);

        // Coba kirim delete request tugas B sebagai User A, harus 403 Forbidden
        $this->actingAs($userA)
            ->delete("/tasks/{$taskB->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $taskB->id]);
    }

    /**
     * Memastikan user dapat menghapus tugas miliknya sendiri.
     */
    public function test_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::create([
            'user_id' => $user->id,
            'title' => 'Tugas Sendiri',
            'deadline' => '2026-06-15',
            'status' => 'belum_dikerjakan',
            'priority' => 'sedang',
        ]);

        $this->actingAs($user)
            ->delete("/tasks/{$task->id}")
            ->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Memastikan kalender menampilkan tanggal deadline tugas dengan benar.
     */
    public function test_calendar_displays_task_deadlines(): void
    {
        $user = User::factory()->create();
        
        $task = Task::create([
            'user_id' => $user->id,
            'title' => 'Ujian Akhir Semester',
            'deadline' => '2026-06-18',
            'status' => 'belum_dikerjakan',
            'priority' => 'tinggi',
        ]);

        // Membuka kalender bulan Juni 2026
        $response = $this->actingAs($user)
            ->get('/calendar?month=6&year=2026&date=2026-06-18');

        $response->assertStatus(200);
        $response->assertSee('Ujian Akhir Semester');
    }
}
