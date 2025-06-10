<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClapController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'post_id' => 'required|exists:posts,id',
        'user_id' => 'required|exists:users,id',
        'clap_count' => 'nullable|integer|min:1',
    ]);

    $clap = Clap::updateOrCreate(
        ['post_id' => $validated['post_id'], 'user_id' => $validated['user_id']],
        ['clap_count' => DB::raw("clap_count + " . ($validated['clap_count'] ?? 1))]
    );

    return response()->json($clap);
}
}
