<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Notifications\ArticleCreatedNotification;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keyword = request()->query('keyword');
        $category = request()->query('category');
        $status = request()->query('status');
        $sort = request()->query('sort') ?? 'latest';

        $articles = Article::with('category')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('slug', 'like', "%{$keyword}%");
            });
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        switch ($sort) {
            case 'oldest':
                $articles->oldest();
                break;
            case 'title_asc':
                $articles->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $articles->orderBy('title', 'desc');
                break;
            default:
                $articles->latest();
                break;
        }
        if (auth()->user()->role === 'author') {
            $articles=$articles->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        }else{
        $articles = $articles
            ->paginate(10)
            ->withQueryString();
        }
        $categories = Category::orderBy('name')->get();
            
        return view('articles.index', compact(
            'articles', 
            'keyword', 
            'categories', 
            'status', 
            'category', 
            'sort'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        $validated['user_id'] = auth()->id();
        $article = Article::create($validated);

        User::first()->notify(
            new ArticleCreatedNotification($article)
        );

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
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
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
        if (
            auth()->user()->role === 'author' 
            && 
            $article->user_id !== auth()->id()
        ){
            abort(403);
        }
         
        $categories = Category::orderBy('name')->get();

        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        Gate::authorize('update', $article);
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {

            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $data['thumbnail'] = $request
                ->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $article = Article::findOrFail($id);
        $this->authorize('delete', $article);
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
