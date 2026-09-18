<?php

// app/Http/Controllers/Api/StandingController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FootballApiService;

class StandingController extends Controller
{
    protected array $leagueMap = [
        'la-liga' => 140,
        'premier-league' => 39,
        'serie-a' => 135,
    ];

    public function show(string $slug, FootballApiService $footballApi)
    {
        if (!isset($this->leagueMap[$slug])) {
            return response()->json(['message' => 'Liga tidak ditemukan'], 404);
        }

        $leagueId = $this->leagueMap[$slug];
        $standings = $footballApi->getStandings(leagueId: $leagueId, season: 2024);

        return response()->json([
            'league_slug' => $slug,
            'standings' => $standings,
        ]);
    }
}