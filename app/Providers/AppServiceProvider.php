<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Article;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.frontend', function ($view) {

            $breakingNews = Article::where('status', 'published')
                ->latest('published_at')
                ->take(8)
                ->get();

            $view->with('breakingNews', $breakingNews);

        });
    }
}
