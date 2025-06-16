<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addPostToSeries(Request $request, Series $series)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'position' => 'required|integer|min:0',
        ]);

        $series->posts()->attach($validated['post_id'], ['position' => $validated['position']]);

        return response()->json(['message' => 'Post added to series.']);
    }

    public function index()
    {
        //
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