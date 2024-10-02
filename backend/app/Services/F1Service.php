<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class F1Service {
    protected $baseUrl = 'https://ergast.com/api/f1';

    public function getRaceSchedule() {
        $response = Http::get("{$this->baseUrl}/current.json");
        return $response->json();
    }

    public function getTeamStandings() {
        $response = Http::get("{$this->baseUrl}/current/constructorStandings.json");
        return $response->json();
    }

    public function getLiveRaceUpdates() {
        // Simulate real-time updates with random mock data for now
        return [
            'lap' => rand(1, 70),
            'leadDriver' => 'Max Verstappen',
            'status' => 'Race in Progress',
            'time' => now()->toTimeString(),
        ];
    }
}
