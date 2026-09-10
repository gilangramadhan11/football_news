<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $chart = Article::selectRaw("
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as total
            ")
            ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->get();
        $monthlyData = array_fill(1, 12, 0);
            foreach ($chart as $item) {

                $monthlyData[$item->month] = $item->total;

            }
        $chartLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'

            ];
        $chartData = array_values($monthlyData);
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $statusChart = [ 
            'Published' => $publishedArticles,
            'Draft' => $draftArticles,
        ];
        $recentActivities = Article::latest()->take(5)->get();
        $popularCategories = Category::withCount('articles')
        ->orderBy('articles_count', 'desc')
        ->take(5)
        ->get();
        $topArticles = Article::orderByDesc('views')
        ->take(5)
        ->get();
        $topLikes = Article::orderByDesc('likes')
        ->take(5)
        ->get();
        $currentMonth = Article::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $previousMonth = Article::whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->count();
        if ($previousMonth > 0) {
            $percentageChange =
                (($currentMonth - $previousMonth) / $previousMonth) * 100;
        } else {
            $percentageChange = $currentMonth > 0 ? 100 : 0;
        }
        $percentageChange = round($percentageChange, 1);
        $currentViews = Article::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('views');

        $previousViews = Article::whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->sum('views');


        $currentLikes = Article::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('likes');

        $previousLikes = Article::whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->sum('likes');
        $viewsPercentage = $previousViews > 0
            ? (($currentViews - $previousViews) / $previousViews) * 100
            : ($currentViews > 0 ? 100 : 0);

        $likesPercentage = $previousLikes > 0
            ? (($currentLikes - $previousLikes) / $previousLikes) * 100
            : ($currentLikes > 0 ? 100 : 0);

        $viewsPercentage = round($viewsPercentage, 1);
        $likesPercentage = round($likesPercentage, 1);
        $totalViews = Article::sum('views');
        $totalLikes = Article::sum('likes');
        $latesArticles = Article::with('category')
            ->latest('created_at')
            ->take(5)
            ->get();
        return view('dashboard', [
            'totalCategories' => Category::count(),
            'totalArticles' => Article::count(),
            'publishedArticles' => Article::where('status', 'published')->count(),
            'draftArticles' => Article::where('status', 'draft')->count(),
            'latestArticles' => $latesArticles,
            'popularCategories' => $popularCategories,
            'chart' => $chart,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'statusChart' => $statusChart,
            'recentActivities' => $recentActivities,
            'topArticles' => $topArticles,
            'topLikes' => $topLikes,
            'currentMonth' => $currentMonth,
            'previousMonth' => $previousMonth,
            'percentageChange' => $percentageChange,
            'totalViews' => $totalViews,
            'totalLikes' => $totalLikes,
            'viewsPercentage' => $viewsPercentage,
            'likesPercentage' => $likesPercentage,
        ]);
    }
}
