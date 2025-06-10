<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'follower_id' => 'required|exists:users,id',
            'followed_id' => 'required|exists:users,id|different:follower_id',
        ]);

        $follow = UserFollow::firstOrCreate([
            'follower_id' => $request->follower_id,
            'followed_id' => $request->followed_id,
        ]);

        return response()->json(['message' => 'Followed successfully', 'data' => $follow]);
    }
}
