<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CustomerServiceController extends Controller
{
    //
	public function index() {

        // $userConversations = DB::table('messages as m')
        // ->join('users as u', 'u.id', '=', 'm.receiver_id')
        // ->where('m.sender_id', Auth::id())
        // ->whereRaw('m.created_at = (
        //     SELECT MAX(created_at)
        //     FROM messages
        //     WHERE sender_id = ? AND receiver_id = m.receiver_id
        // )', [Auth::id()])
        // ->select(
            // 'u.id as user_id',
            // 'u.name as user_name',
            // 'u.image_path as user_image_path',
            // 'u.role as user_role',
            // 'm.is_read as message_is_read',
            // 'm.sender_id as message_sender_id',
            // 'm.created_at as message_created_at',
            // 'm.message as message_content'
        // )
        // ->orderBy('m.created_at', 'desc')
        // ->get();

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

		return view('admin.customer_service',compact('userConversations'));
	}
}
