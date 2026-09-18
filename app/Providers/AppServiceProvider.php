<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Article;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        URL::forceScheme('https');
        View::composer('layouts.frontend', function ($view) {

            $breakingNews = Article::where('status', 'published')
                ->latest('published_at')
                ->take(8)
                ->get();

            $view->with('breakingNews', $breakingNews);

        });
    }
}
