<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return response()->json($articles);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->with(['category', 'user'])->firstOrFail();
        return response()->json($article);
    }
}