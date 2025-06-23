<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $iconMap = [
        'php' => 'fab fa-php',
        'javascript' => 'fab fa-js-square',
        'python' => 'fab fa-python',
        'laravel' => 'fab fa-laravel',
        'react' => 'fab fa-react',
        'vue' => 'fab fa-vuejs',
        'angular' => 'fab fa-angular',
        'nodejs' => 'fab fa-node-js',
        'node.js' => 'fab fa-node-js',
        'wordpress' => 'fab fa-wordpress',
        'bootstrap' => 'fab fa-bootstrap',
        'css' => 'fab fa-css3-alt',
        'html' => 'fab fa-html5',
        'sass' => 'fab fa-sass',
        'docker' => 'fab fa-docker',
        'git' => 'fab fa-git-alt',
        'github' => 'fab fa-github',
        'java' => 'fab fa-java',
        'android' => 'fab fa-android',
        'ios' => 'fab fa-apple',
        'linux' => 'fab fa-linux',
        'aws' => 'fab fa-aws',
        'database' => 'fas fa-database',
        'api' => 'fas fa-code',
        'security' => 'fas fa-shield-alt',
        'mobile' => 'fas fa-mobile-alt',
        'design' => 'fas fa-palette',
        'tutorial' => 'fas fa-book',
        'news' => 'fas fa-newspaper',
        'tools' => 'fas fa-tools',
        'tips' => 'fas fa-lightbulb',
    ];

    public function index()
    {
        $iconMap = $this->iconMap;

        $categories = Category::all();
        $phpId = Category::find(1);
        $phpCategory = Post::whereBelongsTo($phpId)->get()->take(3);
        $jsId = Category::find(2);
        $jsCategory = Post::whereBelongsTo($jsId)->get()->take(3);
        $nodeJsId = Category::find(2);
        $nodeJsCategory = Post::whereBelongsTo($nodeJsId)->get()->take(3);
        // return $phpCategory;
        $mostUsedCategories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(4)
            ->get();
        // return $mostUsedCategories;
        return view('categories.index', compact('phpCategory', 'categories', 'jsCategory', 'nodeJsCategory', 'mostUsedCategories', 'iconMap'));
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
        $iconMap = $this->iconMap;
        // If you want to show all categories (as your current template expects)
        // $categories = Category::with(['posts.user'])->get();
        $posts = Post::whereBelongsTo($category)->get();
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(4)
            ->get();
        $categories = Post::whereBelongsTo($category)->get();
        // return $relatedCategories;
        // return $posts;
        // Pass the current category for breadcrumbs and hero section
        return view('categories.show', compact('categories', 'category', 'posts', 'relatedCategories', 'iconMap'));
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
