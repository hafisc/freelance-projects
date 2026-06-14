<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Get all members.
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'active' => $user->status === 'active' ? 1 : 0,
                'avatar_url' => $user->avatar_url,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Add a new member.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create user with default password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?? 'member_' . time() . '@tps3r.com',
            'phone' => $request->phone,
            'role' => $request->role === 'Koordinator' || $request->role === 'Administrasi' || $request->role === 'admin' ? 'admin' : ($request->role === 'petugas' || $request->role === 'Teknisi' ? 'petugas' : 'member'),
            'password' => Hash::make('Member123'),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil ditambahkan.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'active' => 1,
            ],
        ], 201);
    }

    /**
     * Update a member.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'role' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('phone')) $user->phone = $request->phone;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('role')) {
            $roleVal = $request->role;
            $user->role = $roleVal === 'Koordinator' || $roleVal === 'Administrasi' || $roleVal === 'admin' ? 'admin' : ($roleVal === 'petugas' || $roleVal === 'Teknisi' ? 'petugas' : 'member');
        }
        if ($request->has('active')) {
            $user->status = $request->active ? 'active' : 'inactive';
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil diperbarui.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'active' => $user->status === 'active' ? 1 : 0,
            ],
        ]);
    }

    /**
     * Delete a member.
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil dihapus.',
        ]);
    }
}
