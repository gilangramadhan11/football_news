<?php
// app/Services/FootballApiService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class FootballApiService
{
    protected string $baseUrl = 'https://v3.football.api-sports.io';

    public function getStandings(int $leagueId = 39, int $season = 2024): array
    {
        // Cache 6 jam — klasemen nggak perlu update tiap detik, hemat kuota API
        return Cache::remember("standings-{$leagueId}-{$season}", now()->addHours(6), function () use ($leagueId, $season) {
            $response = Http::withHeaders([
                'x-apisports-key' => config('services.api_football.key'),
            ])->get("{$this->baseUrl}/standings", [
                'league' => $leagueId,
                'season' => $season,
            ]);

            if ($response->failed()) {
                \Log::error('API Football Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [];
            }

            return $response->json()['response'][0]['league']['standings'][0] ?? [];
        });
    }
    
    public function getWeekFixtures(array $leagueIds, int $season = 2024): array
    {
        

        $from = '2024-08-16';
        $to = '2024-08-19';

        return Cache::remember("fixtures-week-" . implode('-', $leagueIds) . "-{$from}", now()->addHours(2), function () use ($leagueIds, $season, $from, $to) {
            $allFixtures = collect();

            foreach ($leagueIds as $leagueId) {
                $response = Http::withHeaders([
                    'x-apisports-key' => config('services.api_football.key'),
                ])->get("{$this->baseUrl}/fixtures", [
                    'league' => $leagueId,
                    'season' => $season,
                    'from' => $from,
                    'to' => $to,
                ]);

                if ($response->successful()) {
                    $allFixtures = $allFixtures->merge($response->json()['response'] ?? []);
                }
            }

            // Grouping: tanggal -> liga -> list pertandingan
            return $allFixtures
                ->sortBy('fixture.date')
                ->take(8)
                ->groupBy(fn($f) => \Carbon\Carbon::parse($f['fixture']['date'])->format('Y-m-d'))
                ->map(fn($matches) => $matches->groupBy('league.name'))
                ->toArray();
        });
    }

    public function getTopScorers(int $leagueId = 39, int $season = 2024): array
    {
        return Cache::remember("top-scorers-{$leagueId}-{$season}", now()->addHours(12), function() use ($leagueId, $season) {
            $response = Http::withHeaders([
                'x-apisports-key' => config('services.api_football.key'),
            ])->get('https://v3.football.api-sports.io/players/topscorers', [
                'league' => $leagueId,
                'season' => $season,
            ]);

            if ($response->failed()) {
                return [];
            }

            return array_slice($response->json()['response'] ?? [], 0, 10);
        });
    }

    public function getTopAssists(int $leagueId = 140, int $season = 2024): array
    {
        return Cache::remember("top-assists-{$leagueId}-{$season}", now()->addHours(12), function() use ($leagueId, $season) {
            $response = Http::withHeaders([
                'x-apisports-key' => config('services.api_football.key'),
            ])->get('https://v3.football.api-sports.io/players/topassists', [
                'league' => $leagueId,
                'season' => $season,
            ]);

            if ($response->failed()) {
                return [];
            }

            return array_slice($response->json()['response'] ?? [], 0, 5);
        });
    }


}

