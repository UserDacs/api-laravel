<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'reply_to_id' => 'nullable|exists:messages,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages/images', 'public');
        }
        $nowFromDb = \DB::select("SELECT NOW() as now")[0]->now;
        $message = Message::create([
            'sender_id'    => Auth::id(),
            'receiver_id'  => $request->receiver_id,
            'reply_to_id'  => $request->reply_to_id,
            'message'      => $request->message,
            'image_path'   => $imagePath,
            'created_at'   => $nowFromDb
        ]);

        $userId = $request->receiver_id;

        $authId = Auth::id();

        $query = Message::select(
                'messages.*',
                'sender.name as sender_name',
                'sender.image_path as sender_image',
                'receiver.name as receiver_name',
                'receiver.image_path as receiver_image'
            )
            ->join('users as sender', 'sender.id', '=', 'messages.sender_id')
            ->join('users as receiver', 'receiver.id', '=', 'messages.receiver_id')
            ->orderBy('messages.created_at', 'desc'); // Latest first

        if ($userId) {
            $query->where(function ($q) use ($authId, $userId) {
                $q->where('messages.sender_id', $authId)
                ->where('messages.receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('messages.sender_id', $userId)
                ->where('messages.receiver_id', $authId);
            });
        } else {
            $query->where(function ($q) use ($authId) {
                $q->where('messages.sender_id', $authId)
                ->orWhere('messages.receiver_id', $authId);
            });
        }



        // Get only the latest message
        $message2 = $query->first();

        if ($message2) {
            $message2->created_at_human = formated_time($message2->created_at);
        }

        return response()->json(['status' => 200, 'message' => 'Message sent!', 'data' => $message2]);
    }

    public function contacts()
    {
        $authId = Auth::id();

        // All unique users na nakausap mo, either sent or received messages
        $contacts = DB::table('messages as m')
            ->join('users as u', function ($join) use ($authId) {
                $join->on('u.id', '=', DB::raw("CASE
                    WHEN m.sender_id = $authId THEN m.receiver_id
                    ELSE m.sender_id END"));
            })
            ->where(function ($q) use ($authId) {
                $q->where('m.sender_id', $authId)
                ->orWhere('m.receiver_id', $authId);
            })
            ->select('u.id', 'u.name', 'u.image_path', 'u.role')
            ->distinct()
            ->get();

        return response()->json($contacts);
    }

    public function inbox()
    {
        $userId = Auth::id();
        $messages = Message::with('sender')
            ->where('receiver_id', $userId)
            ->latest()
            ->get();

        // Apply human readable created_at
        foreach ($messages as $message) {
            $message->created_at_human = formated_time($message->created_at);
        }

        return response()->json($messages);
    }

    public function conversation($userId)
    {
        $authId = Auth::id();

        $query = Message::select(
                'messages.*',
                'sender.name as sender_name',
                'sender.image_path as sender_image',
                'receiver.name as receiver_name',
                'receiver.image_path as receiver_image'
            )
            ->join('users as sender', 'sender.id', '=', 'messages.sender_id')
            ->join('users as receiver', 'receiver.id', '=', 'messages.receiver_id')
            ->orderBy('messages.created_at', 'asc');

        if ($userId) {
            $query->where(function ($q) use ($authId, $userId) {
                $q->where('messages.sender_id', $authId)
                ->where('messages.receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('messages.sender_id', $userId)
                ->where('messages.receiver_id', $authId);
            });
        } else {
            $query->where(function ($q) use ($authId) {
                $q->where('messages.sender_id', $authId)
                ->orWhere('messages.receiver_id', $authId);
            });
        }

        $messages = $query->get();

        // Apply human readable created_at
        foreach ($messages as $message) {
            $message->created_at_human = formated_time($message->created_at);
            $message->user_auth_id = Auth::id();
            $message->user_auth_role = Auth::user()->role;

            if ($message->sender_id == Auth::id()) {
                $message->user_message_position = true;
            }else{
                $message->user_message_position = false;
            }
        }

        return response()->json($messages);
    }

    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $message->update(['is_read' => true]);

        return response()->json(['status' => 200, 'message' => 'Message marked as read']);
    }



    public function sendWeb(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'reply_to_id' => 'nullable|exists:messages,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages/images', 'public');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'reply_to_id' => $request->reply_to_id,
            'message' => $request->message,
            'image_path' => $imagePath,
        ]);

        return response()->json(['status' => 200, 'message' => 'Message sent!', 'data' => $message]);
    }

    public function inboxWeb()
    {
        $userId = Auth::id();
        $messages = Message::with('sender')
            ->where('receiver_id', $userId)
            ->latest()
            ->get();

        return response()->json($messages);
    }

    public function conversationWeb($userId)
    {
        $authId = Auth::id();

        if ($userId) {
            // Show only messages between $authId and $userId
            $messages = Message::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })->orderBy('created_at', 'asc')->get();
        } else {
            // Show all messages involving the current user
            $messages = Message::where(function ($q) use ($authId) {
                $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
            })->orderBy('created_at', 'asc')->get();
        }

        return response()->json($messages);
    }

    public function markAsReadWeb($id)
    {
        // Attempt to find the message
        $message = Message::where('id', $id)->first();

        // If the message is not found, return an error message
        if (!$message) {
            return response()->json(['status' => 404, 'message' => 'Message not found or not accessible.'], 404);
        }

        // Update the message as read
        $message->update(['is_read' => true]);

        return response()->json(['status' => 200, 'message' => 'Message marked as read']);
    }

    public function clicnt_sokect(){
        return view('client');
    }

    public function constac() {
        $authId = Auth::id();

        $sub = DB::table('messages as m1')
            ->select(DB::raw("CASE
                    WHEN m1.sender_id = $authId THEN m1.receiver_id
                    ELSE m1.sender_id END as user_id"),
                DB::raw('MAX(m1.created_at) as latest_created_at')
            )
            ->where(function ($q) use ($authId) {
                $q->where('m1.sender_id', $authId)
                ->orWhere('m1.receiver_id', $authId);
            })
            ->groupBy('user_id');

        $userConversations = DB::table('messages as m')
            ->joinSub($sub, 'latest', function ($join) use ($authId) {
                $join->on(DB::raw("CASE
                    WHEN m.sender_id = $authId THEN m.receiver_id
                    ELSE m.sender_id END"), '=', 'latest.user_id')
                    ->on('m.created_at', '=', 'latest.latest_created_at');
            })
            ->join('users as u', function ($join) use ($authId) {
                $join->on('u.id', '=', DB::raw("CASE
                    WHEN m.sender_id = $authId THEN m.receiver_id
                    ELSE m.sender_id END"));
            })
            ->select(
                'u.id as user_id',
                'u.name as user_name',
                'u.image_path as user_image_path',
                'u.role as user_role',
                'm.is_read as message_is_read',
                'm.sender_id as message_sender_id',
                'm.created_at as message_created_at',
                'm.message as message_content'
            )
            ->orderByDesc('m.created_at')
            ->get();

            foreach ($userConversations as $message) {
                $message->created_at_human = formated_time($message->message_created_at);
                $message->auth_idid = $authId;
            }

            return response()->json($userConversations);
    }
}
