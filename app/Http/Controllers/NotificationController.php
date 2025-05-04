<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\GeneralNotification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     * The notifications will be grouped by category.
     */
    public function index(Request $request)
    {
        $user = $request->user();  // Get the authenticated user

        // Fetch all notifications for this user
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($n) => $n->data['category'] ?? 'general');  // Group by category
        
        return response()->json($notifications);
    }

    /**
     * Get the unread notification count by category for the authenticated user.
     */
    public function counts(Request $request)
    {
        $userId = $request->query('userId');
    
        // Get user role
        $user = \App\Models\User::find($userId);
    
        // Build base query
        $query = DB::table('notifications')
            ->select(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.category')) as category"), DB::raw('count(*) as count'))
            ->whereNull('read_at');
    
        // If not admin, filter by user ID
        if ($user && $user->role !== 'admin') {
            $query->where('notifiable_id', $userId);
        }
    
        // Group by category
        $counts = $query->groupBy(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.category'))"))->get();
    
        return response()->json($counts);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);  // Find notification by ID
        $notification->markAsRead();  // Mark the notification as read

        return response()->json(['message' => 'Notification marked as read']);
    }

    /**
     * Send a custom notification to a user and broadcast it to the Socket.IO server.
     */
    public function sendNotification(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|exists:users,id',  // Ensure user exists
            'message' => 'required|string',
            'title' => 'nullable|string',
            'category' => 'required|string',
        ]);

        $user = User::find($validated['userId']);

        // Send the notification to the user
        $user->notify(new GeneralNotification(
            $validated['message'],
            $validated['title'] ?? 'Notification',
            $validated['category']
        ));

        return response()->json(['message' => 'Notification sent']);
    }

    public function list(Request $request)
    {
        $userId = $request->query('userId');
        $user = \App\Models\User::find($userId);

        $query = \DB::table('notifications')
            ->leftJoin('users', 'notifications.notifiable_id', '=', 'users.id')
            ->whereNull('notifications.read_at')
            ->select(
                'notifications.*',
                'users.name as user_name',
                'users.image_path as user_image' // Make sure 'image' exists in your users table
            )
            ->orderByDesc('notifications.created_at')
            ->limit(100);

        if ($user && $user->role !== 'admin') {
            $query->where('notifications.notifiable_id', $userId);
        }

        $notifications = $query->get();

        return response()->json($notifications);
    }


}
