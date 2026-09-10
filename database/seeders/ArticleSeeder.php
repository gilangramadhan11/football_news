<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::updateOrCreate([
            'slug' => 'liverpool-juara-liga-inggris-2022-2023',
        ], [    
            'category_id' => 1,
            'title' => 'Liverpool juara Liga Inggris 2022/2023',
            'slug' => 'liverpool-juara-liga-inggris-2022-2023',
            'thumbnail' => 'null',
            'content' => 'Ini adalah contoh konten artikel.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Article::updateOrCreate([
            'slug' => 'barcelona-juara-la-liga-2022-2023',
        ], [    
            'category_id' => 2,
            'title' => 'Barcelona juara La Liga 2022/2023',
            'slug' => 'barcelona-juara-la-liga-2022-2023',
            'thumbnail' => 'null',
            'content' => 'Ini adalah contoh konten artikel.',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
