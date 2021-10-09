<?php

namespace App\Http\Controllers;

use App\Helpers\FixtureHelper;
use App\Layers\Service\IGameService;
use App\Models\Team;
use Illuminate\Http\Request;

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

        // check fixture generated or not
        $fixtureCreated = $this->gameService->checkFixtureCreated();
        if ($fixtureCreated){
            return redirect()->route('fixture');
        }

        return view('welcome', compact('teams'));
    }
}
