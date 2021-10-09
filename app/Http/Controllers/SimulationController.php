<?php

namespace App\Http\Controllers;

use App\Layers\Service\IGameService;

class SimulationController extends Controller
{
    private $gameService;

    public function __construct(IGameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $pointTable = $this->gameService->getPointTable();
        $lastWeekGames = $this->gameService->getLastWeekGames();
        $playedGames = $this->gameService->getPlayedGames();
        $predictions = $this->gameService->getPredictions();

        return view('simulation', compact('pointTable', 'lastWeekGames', 'playedGames', 'predictions'));
    }

    public function play()
    {
        $this->gameService->play();

        return redirect()->route('simulation');
    }

    public function reset()
    {
        $this->gameService->reset();

        return redirect()->route('welcome');
    }

    public function playAll()
    {
        $this->gameService->playAll();

        return redirect()->route('simulation');
    }
}
