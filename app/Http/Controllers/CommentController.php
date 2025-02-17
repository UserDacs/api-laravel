<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
    
        $comment = Comment::create([
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id
        ]);
    
        return response()->json([
            'message' => 'Comment added successfully.',
            'data' => $comment
        ], 201);
    }

     public function store_reply(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
    
        $comment = Comment::create([
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id
        ]);
    
        return response()->json([
            'message' => 'Comment added successfully.',
            'data' => $comment
        ], 201);
    }
}
