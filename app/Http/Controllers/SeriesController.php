<?php

// app/Http/Controllers/SeriesController.php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        return Series::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return Series::create($validated);
    }

    public function show(Series $series)
    {
        return $series;
    }

    public function update(Request $request, Series $series)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $series->update($validated);
        return $series;
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return response()->noContent();
    }
}