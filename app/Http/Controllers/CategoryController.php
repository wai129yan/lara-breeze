<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'description' => 'nullable|string',
        ]);

        return Category::create($validated);
    }

    public function show(Category $category)
    {
        // If you want to show all categories (as your current template expects)
        $categories = Category::with(['posts.user'])->get();

        // Pass the current category for breadcrumbs and hero section
        return view('categories.show', compact('categories', 'category'));
    }

    public function edit($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Return the edit view with the category data
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        // Redirect back to index with a success alert
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
