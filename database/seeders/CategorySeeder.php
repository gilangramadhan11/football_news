<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'premier-league'],
            [
                'name' => 'Premier League',
                'description' => 'Berita seputar Liga Inggris',
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'la-liga'],
            [
                'name' => 'La Liga',
                'description' => 'Berita seputar Liga Spanyol',
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'serie-a'],
            [
                'name' => 'Serie A',
                'description' => 'Berita seputar Liga Italia',
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'bundesliga'],
            [
                'name' => 'Bundesliga',
                'description' => 'Berita seputar Liga Jerman',
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'liga-1-indonesia'],
            [
                'name' => 'Liga 1 Indonesia',

            'description' => 'Berita seputar Liga Indonesia',
        ]);

        Category::updateOrCreate(
            ['slug' => 'timnas-indonesia'],
            [
                'name' => 'Timnas Indonesia',
                'description' => 'Berita seputar Timnas Indonesia',
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'transfer'],
            [
                'name' => 'Transfer',
                'description' => 'Rumor dan berita transfer pemain',
            ]
        );
    }
}
