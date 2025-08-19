<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    public function follow(User $user)
    {
        $follower = Auth::user();
        if ($follower->id === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself'], 400);
        }
        $follower->follow($user);
        return response()->json(['message' => 'Followed successfully', 'following' => true]);
    }

    public function unfollow(User $user)
    {
        $follower = Auth::user();
        $follower->unfollow($user);
        return response()->json(['message' => 'Unfollowed successfully', 'following' => false]);
    }

    public function toggle(User $user)
    {
        $follower = Auth::user();

        if ($follower->id === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself'], 400);
        }

        $following = $follower->toggleFollow($user);
        $isFollowing = $follower->isFollowing($user);

        // Get the updated follower count for the user being followed/unfollowed
        $followerCount = $user->followers()->count();

        return response()->json([
            'message' => $isFollowing ? 'Followed successfully' : 'Unfollowed successfully',
            'following' => $isFollowing,
            'followers_count' => $followerCount
        ]);
    }
}
