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

        $currentWeekGames = $this->gameService->getCurrentWeekGames();

        return view('simulation', compact('pointTable', 'currentWeekGames'));
    }
}
