<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Mengambil semua notifikasi milik user yang sedang login
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar notifikasi',
            'data' => $notifications,
        ], 200);
    }

    // Menandai semua notifikasi milik user yang sedang login sebagai telah dibaca
    public function markAllRead(Request $request)
    {
        $userId = $request->user()->id;

        Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil ditandai sebagai dibaca',
            'data' => null,
        ], 200);
    }

    // Menandai satu notifikasi tertentu sebagai telah dibaca
    public function markAsRead(Request $request, $id)
    {
        $userId = $request->user()->id;

        $notification = Notification::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil ditandai sebagai dibaca',
            'data' => $notification,
        ], 200);
    }
}
