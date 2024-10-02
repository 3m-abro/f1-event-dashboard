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
    public function getLiveRaceUpdates() {
        return response()->stream(function() {
            while (true) {
                echo "data: " . json_encode($this->f1Service->getLiveRaceUpdates()) . "\n\n";
                ob_flush();
                flush();
                sleep(2); // Mock updates every 2 seconds
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }

}
