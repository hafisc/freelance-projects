<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Mendaftar sebagai pencari kerja baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ], 201);
    }

    // Masuk log pencari kerja
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial login salah',
                'errors' => null,
            ], 401);
        }

        // Hapus token sebelumnya jika ada (opsional)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ], 200);
    }

    // Mendapatkan profil pencari kerja yang sedang masuk log
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil profil',
            'data' => $request->user(),
        ], 200);
    }

    // Memperbarui profil pencari kerja
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->all();

        // Decode JSON strings for array fields if they are sent as strings (due to multipart encoding)
        if ($request->has('skills') && is_string($request->input('skills'))) {
            $data['skills'] = json_decode($request->input('skills'), true);
        }
        if ($request->has('education') && is_string($request->input('education'))) {
            $data['education'] = json_decode($request->input('education'), true);
        }
        if ($request->has('experience') && is_string($request->input('experience'))) {
            $data['experience'] = json_decode($request->input('experience'), true);
        }

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'cv' => 'nullable', // Bisa berupa berkas unggahan atau string path lama
            'summary' => 'nullable|string',
            'skills' => 'nullable|array',
            'education' => 'nullable|array',
            'experience' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cvPath = $user->cv;

        // Proses unggah berkas CV jika ada berkas baru yang dikirimkan
        if ($request->hasFile('cv')) {
            $fileValidator = Validator::make($request->all(), [
                'cv' => 'file|mimes:pdf,doc,docx|max:5120',
            ]);

            if ($fileValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format berkas tidak valid atau terlalu besar (maksimal 5MB PDF/Word)',
                    'errors' => $fileValidator->errors(),
                ], 422);
            }

            // Hapus berkas lama dari storage jika ada
            if ($user->cv && Storage::disk('public')->exists($user->cv)) {
                Storage::disk('public')->delete($user->cv);
            }

            $file = $request->file('cv');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('cv', $fileName, 'public');
            $cvPath = $path;
        } elseif ($request->exists('cv') && empty($request->cv)) {
            // Jika field cv dikirim kosong secara eksplisit, hapus berkas
            if ($user->cv && Storage::disk('public')->exists($user->cv)) {
                Storage::disk('public')->delete($user->cv);
            }
            $cvPath = null;
        }

        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'cv' => $cvPath,
            'summary' => $data['summary'] ?? null,
            'skills' => $data['skills'] ?? null,
            'education' => $data['education'] ?? null,
            'experience' => $data['experience'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user,
        ], 200);
    }

    // Keluar log pencari kerja
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil keluar log',
            'data' => null,
        ], 200);
    }
}
