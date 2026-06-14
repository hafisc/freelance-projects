<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test active job list retrieval.
     */
    public function test_can_retrieve_active_job_list(): void
    {
        // Seed active and inactive jobs
        Job::create([
            'title' => 'Driver',
            'company_name' => 'PT. Gloria Jasa Mandiri',
            'location' => 'Jakarta',
            'qualification' => 'SIM A',
            'description' => 'Drive vehicles',
            'status' => 'Aktif',
        ]);

        Job::create([
            'title' => 'Sales',
            'company_name' => 'PT. Gloria Jasa Mandiri',
            'location' => 'Tangerang',
            'qualification' => 'Motor',
            'description' => 'Sell products',
            'status' => 'Nonaktif',
        ]);

        $response = $this->getJson('/api/jobs');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Berhasil mengambil daftar lowongan pekerjaan',
            ]);

        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Driver', $response->json('data.0.title'));
    }

    /**
     * Test job detail retrieval.
     */
    public function test_can_retrieve_job_details(): void
    {
        $job = Job::create([
            'title' => 'Cashier',
            'company_name' => 'PT. Gloria Jasa Mandiri',
            'location' => 'Bekasi',
            'qualification' => 'Honest',
            'description' => 'Manage cashier',
            'status' => 'Aktif',
        ]);

        $response = $this->getJson("/api/jobs/{$job->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Cashier',
                ],
            ]);
    }

    /**
     * Test user registration.
     */
    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Registrasi berhasil',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user login.
     */
    public function test_user_can_login(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login berhasil',
            ]);

        $this->assertNotNull($response->json('data.token'));
    }

    /**
     * Test profile retrieval.
     */
    public function test_authenticated_user_can_retrieve_profile(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/profile');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'email' => 'test@example.com',
                ],
            ]);
    }

    /**
     * Test profile update.
     */
    public function test_authenticated_user_can_update_profile(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/profile/update', [
            'name' => 'Updated User Name',
            'phone' => '08999999999',
            'address' => 'Updated Address',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User Name',
            'phone' => '08999999999',
            'address' => 'Updated Address',
        ]);
    }

    /**
     * Test job application submission.
     */
    public function test_authenticated_user_can_apply_for_job(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);

        $job = Job::create([
            'title' => 'Driver',
            'company_name' => 'PT. Gloria Jasa Mandiri',
            'location' => 'Jakarta',
            'qualification' => 'SIM A',
            'description' => 'Drive vehicles',
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/applications', [
            'job_id' => $job->id,
            'full_name' => 'Test User Application',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta Selatan',
            'note' => 'I am interested',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Lamaran pekerjaan berhasil dikirim',
            ]);

        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->id,
            'job_id' => $job->id,
            'full_name' => 'Test User Application',
            'status' => 'Menunggu',
        ]);
    }

    /**
     * Test application history retrieval.
     */
    public function test_authenticated_user_can_retrieve_application_history(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);

        $job = Job::create([
            'title' => 'Driver',
            'company_name' => 'PT. Gloria Jasa Mandiri',
            'location' => 'Jakarta',
            'qualification' => 'SIM A',
            'description' => 'Drive vehicles',
            'status' => 'Aktif',
        ]);

        JobApplication::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'full_name' => 'Test User Application',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta Selatan',
            'note' => 'I am interested',
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/applications/my-results');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Berhasil mengambil riwayat lamaran Anda',
            ]);

        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Driver', $response->json('data.0.job.title'));
    }
}
