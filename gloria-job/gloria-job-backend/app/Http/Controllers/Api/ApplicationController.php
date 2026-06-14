<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    // Mengirim lamaran pekerjaan baru oleh user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:jobs,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userId = $request->user()->id;
        $jobId = $request->job_id;

        // Cek apakah lowongan masih aktif
        $job = Job::find($jobId);
        if ($job->status !== 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan ini sudah tidak aktif',
                'errors' => null,
            ], 400);
        }

        // Cegah melamar berulang kali pada lowongan yang sama
        $alreadyApplied = JobApplication::where('user_id', $userId)
            ->where('job_id', $jobId)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengirim lamaran untuk lowongan ini sebelumnya',
                'errors' => null,
            ], 400);
        }

        $application = JobApplication::create([
            'user_id' => $userId,
            'job_id' => $jobId,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'status' => 'Menunggu', // Status awal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran pekerjaan berhasil dikirim',
            'data' => $application,
        ], 201);
    }

    // Mengambil daftar riwayat hasil lamaran milik user yang sedang login
    public function myResults(Request $request)
    {
        $userId = $request->user()->id;

        $applications = JobApplication::with('job')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil riwayat lamaran Anda',
            'data' => $applications,
        ], 200);
    }
}
