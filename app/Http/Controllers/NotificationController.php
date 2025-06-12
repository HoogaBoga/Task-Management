<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Fetch notifications for the specific authenticated user.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // FIX: Use the user's primary ID t ao match what is being stored by AddTaskController.
        $userId = Auth::id();

        // Fetch all notifications for this specific user.
        $notifications = DB::table('notifications')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Decode the 'data' column.
        $notifications->each(function ($notification) {
            $notification->data = json_decode($notification->data, true);
        });

        // Get the count of unread notifications for this specific user.
        $unreadCount = DB::table('notifications')
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        // Return the data in the required format.
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark all of this user's notifications as read.
     */
    public function markAllAsRead()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // FIX: Use the primary user ID here as well for consistency.
        $userId = Auth::id();

        DB::table('notifications')
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications for this user marked as read.']);
    }
}
