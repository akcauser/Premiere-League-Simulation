<?php

namespace App\Http\Controllers;

use App\Helpers\SimulationHelper;
use App\Layers\Service\IGameService;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    private IGameService $gameService;

    public function __construct(IGameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $pointTable = SimulationHelper::getPointTable();

        $lastWeekGames = $this->gameService->getLastWeekGames();

        return view('simulation', compact('pointTable', 'lastWeekGames'));
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
