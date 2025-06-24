<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        // most follower user list

        // Most followed users
        $mostFollowerUser = User::withCount('followers')
            ->having('followers_count', '>', 0)  // Only users with followers
            ->orderBy('followers_count', 'desc')
            ->limit(4)
            ->get();

        // return $mostFollowerUser;
        // Most active posters
        $mostPostUser = User::withCount('posts')
            ->having('posts_count', '>', 0)  // Only users with posts
            ->orderBy('posts_count', 'desc')
            ->limit(4)
            ->get();
        // return $mostPostUser;
        // Most clapped users (assuming you want claps received)
        $mostClapUser = User::withCount('receivedClaps')
            ->having('received_claps_count', '>', 0)
            ->orderBy('received_claps_count', 'desc')
            ->limit(4)
            ->get();
        // return $mostClapUser;
        return view('authors.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
