<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
Use App\Models\Category;
use Illuminate\Support\Str;
use App\Services\FootballApiService;

class HomeController extends Controller
{
    public function index(FootballApiService $footballApi)
    {

        $standings = $footballApi->getStandings(leagueId: 140, season: 2024);
        $weekFixtures = $footballApi->getWeekFixtures([140], season: 2024);
        $topScorers = $footballApi->getTopScorers(leagueId: 39, season: 2024);
        $topAssists = $footballApi->getTopAssists(leagueId: 140, season: 2024);

        $featured = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $trending = Article::where('status', 'published')
            ->where('id', '!=', optional($featured->first())->id)
            ->latest()
            ->take(5)
            ->get();

        $query = Article::with('category')
            ->where('status', 'published');
            
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('content', 'like', '%' . request('search') . '%');
            });
        }

        if ($featured->isNotEmpty()) {
            $query->whereNotIn('id', [$featured->first()->id]);
        }
        
        $articles = $query->latest('published_at')->paginate(5)->withQueryString();

        $categories = Category::withCount('articles')
            ->orderBy('name')
            ->get();

        $recentArticles = Article::where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        $popularArticles = Article::where('status', 'published')
            ->whereYear('published_at', now()->year)
            ->whereMonth('published_at', now()->month)
            ->orderByDesc('views')
            ->first();

        if (!$popularArticles) {
            $popularArticles = Article::where('status', 'published')
                ->orderByDesc('views')
                ->first();
}
        
        $breakingNews = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();
        

        $seoTitle = 'Football News - Berita Sepak Bola Terbaru';

        $seoDescription = 'Football News menghadirkan berita sepak bola terbaru, transfer pemain, Liga Inggris, Liga Champions, Serie A, La Liga, dan Tim Nasional.';

        $seoImage = asset('images/default-news.jpg');

        $topScorers = collect($topScorers)
            ->values()
            ->map(function ($player, $index){
                $player['rank'] = $index + 1;
                return $player;
            });

        $topAssists = collect($topAssists)
            ->values()
            ->map(function ($player, $index){
                $player['rank'] = $index + 1;
                return $player;
            });    

        return view('home', compact(
            'featured', 
            'articles', 
            'categories',
            'recentArticles',
            'popularArticles',
            'trending',
            'breakingNews',
            'seoTitle',
            'seoDescription',
            'seoImage',
            'standings',
            'weekFixtures',
            'topScorers',
            'topAssists'
        ));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::with('category')
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(5)
            ->withQueryString();
        
        $categories = Category::withCount('articles')->get();

        $recentArticles = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularArticles = Article::where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->get();
        
        $breakingNews = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('category', compact(
            'category',
            'articles',
            'categories',
            'recentArticles',
            'popularArticles',
            'breakingNews'
        ));
    }

    public function show($slug)
    {
        $article = Article::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $article->increment('views');

        $relatedArticles = Article::with('category')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount('articles')->get();

        $recentArticles = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularArticles = Article::where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->get();
        $breakingNews = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $liked = session()->has('liked_article_' . $article->id);

        $seoTitle = $article->title;

        $seoDescription = Str::limit(
            strip_tags($article->content),
            160
        );

        $seoImage = $article->thumbnail
        ? asset('storage/' . $article->thumbnail)
        : asset('images/default-news.jpg');
        return view('articles.show', compact(
            'article',
            'relatedArticles',
            'categories',
            'recentArticles',
            'popularArticles',
            'breakingNews',
            'liked',
            'seoTitle',
            'seoDescription',
            'seoImage'
        ));
    }

    public function like(Request $request, Article $article)
    {
        $sessionKey = 'liked_article_' . $article->id;

        if (!$request->session()->has($sessionKey)) {

            $article->increment('likes');

            $request->session()->put($sessionKey, true);

            // Ambil data terbaru dari database
            $article->refresh();
        }

        return response()->json([
            'likes' => $article->likes,
            'liked' => true,
        ]);
    }

    public function api(FootballApiService $footballApi)
    {
        $featured = Article::with('category', 'user')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $breakingNews = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $recentArticles = Article::with('category', 'user')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        $standings = $footballApi->getStandings(leagueId: 140, season: 2024);
        $weekFixtures = $footballApi->getWeekFixtures([140], season: 2024);
        $topScorers = $footballApi->getTopScorers(leagueId: 140, season: 2024);
        $topAssists = $footballApi->getTopAssists(leagueId: 140, season: 2024);

        $populerArticles = Article::with('category', 'user')
            ->where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->get();
        
        $trending = Article::with('category', 'user')
            ->where('status', 'published')
            ->where('id', '!=', optional($featured->first())->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'featured' => $featured->map(function ($article) {
                $article->thumbnail = $article->thumbnail
                    ? 'https://footballnews-production.up.railway.app/storage/' . $article->thumbnail
                    : 'https://footballnews-production.up.railway.app/images/default-news.jpg';

                return $article;
            }),
            'breakingNews' => $breakingNews,
            'recentArticles' => $recentArticles,
            'weekFixtures' => $weekFixtures,
            'populerArticles' => $populerArticles,
            'trending' => $trending,
            'standings' => $standings,
            'topScorers' => $topScorers,
            'topAssists' => $topAssists,
        ]);
    }

    public function apiShow($slug)
    {
        $article = Article::with('category', 'user')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedArticles = Article::with('category', 'user')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount('articles')
            ->get();

        $breakingNews = Article::where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        return response()->json([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'content' => $article->content,
                'thumbnail' => $article->thumbnail,
                'published_at' => $article->published_at,
                'views' => $article->views,
                'user' => [
                    'id' => $article->user->id,
                    'name' => $article->user->name,
                    'email' => $article->user->email,
                ],
                'category' => [
                    'name' => $article->category->name,
                ],
                'related_articles' => $relatedArticles,
                'categories' => $categories,
                'breakingNews' => $breakingNews,
            ],
        ]);
    }
}
