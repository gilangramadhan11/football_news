<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalViews = Article::sum('views');

        $totalLikes = Article::sum('likes');

        $totalArticles = Article::count();

        $totalCategories = Category::count();

        $topArticles = Article::where('status','published')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        $mostLiked = Article::where('status','published')
            ->orderByDesc('likes')
            ->take(5)
            ->get();

        $topCategories = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        $monthlyArticles = Article::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = Carbon::create()->month($i)->translatedFormat('M');
            $chartData[] = $monthlyArticles[$i] ?? 0;
        }

        $categoryChart = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        $categoryLabels = $categoryChart->pluck('name');

        $categoryData = $categoryChart->pluck('articles_count');
        return view('admin.analytics.index', compact(
            'totalViews',
            'totalLikes',
            'totalArticles',
            'totalCategories',
            'topArticles',
            'mostLiked',
            'topCategories',
            'chartLabels',
            'chartData',
            'categoryLabels',
            'categoryData'
        ));
    }
}