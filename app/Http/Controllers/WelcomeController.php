<?php

namespace App\Http\Controllers;

use App\Layers\Service\IGameService;
use App\Models\Team;

class WelcomeController extends Controller
{
    private $gameService;

    public function __construct(IGameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function welcome()
    {
        $teams = Team::all();

        // if fixture generated before, then redirect fixture page.
        $fixtureCreated = $this->gameService->checkFixtureCreated();
        if ($fixtureCreated){
            return redirect()->route('fixture');
        }

        return view('welcome', compact('teams'));
    }
}
