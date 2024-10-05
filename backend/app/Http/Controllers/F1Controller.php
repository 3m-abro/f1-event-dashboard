<?php

namespace App\Http\Controllers;

use App\Services\F1Service;
use Illuminate\Http\Request;

class F1Controller extends Controller {
    protected $f1Service;

    /**
     * F1Controller constructor.
     *
     * @param F1Service $f1Service The service to handle F1 related operations.
     */
    public function __construct(F1Service $f1Service) {
        $this->f1Service = $f1Service;
    }

    /**
     * Get the race schedule.
     *
     * @return \Illuminate\Http\JsonResponse The race schedule data.
     */
    public function getRaceSchedule() {
        return response()->json($this->f1Service->getRaceSchedule());
    }

    /**
     * Get the team standings.
     *
     * @return \Illuminate\Http\JsonResponse The team standings data.
     */
    public function getTeamStandings() {
        return response()->json($this->f1Service->getTeamStandings());
    }

    /**
     * Get live race updates.
     *
     * @return \Illuminate\Http\StreamingResponse The live race updates data.
     */
    public function getLiveRaceUpdates()
    {
        return response()->stream(function() {
            // Simulate the race updates using mock data
            $drivers = ['Max Verstappen', 'Lewis Hamilton', 'Charles Leclerc', 'Sergio Perez', 'Carlos Sainz'];

            // Continuously send updates every few seconds
            for ($lap = 1; $lap <= 10; $lap++) {
                $leadDriver = $drivers[array_rand($drivers)];
                $time = now()->format('H:i:s');

                $data = [
                    'lap' => $lap,
                    'leadDriver' => $leadDriver,
                    'status' => 'Race in Progress',
                    'time' => $time
                ];

                // Send the event data as SSE
                echo "event: raceUpdate\n";
                echo "data: " . json_encode($data) . "\n\n";

                // Flush the output buffer to ensure the data is sent immediately
                ob_flush();
                flush();

                // Sleep for 2 seconds to simulate real-time data
                sleep(2);
            }

            // Send final update when race ends
            $endData = [
                'lap' => 10,
                'leadDriver' => 'Max Verstappen',
                'status' => 'Race Finished',
                'time' => now()->format('H:i:s')
            ];

            echo "event: raceUpdate\n";
            echo "data: " . json_encode($endData) . "\n\n";

            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Access-Control-Allow-Origin' => 'https://f1-dashboard.local', // Add this header
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ]);
    }

}
