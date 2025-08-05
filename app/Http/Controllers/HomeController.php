<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'category')->latest()->limit(9)->get();
        return view('home', compact('posts'));
    }
}
