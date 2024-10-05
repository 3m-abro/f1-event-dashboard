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
}
