<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // Untuk dropdown navbar
    public function index()
    {
        $categories = Category::orderBy('id')->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    // Untuk halaman /category/[slug]
    public function articles($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->where('status', 'published')
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(9);


        return response()->json([
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}