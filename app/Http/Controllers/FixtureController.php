<?php

namespace App\Http\Controllers;

use App\Layers\Service\IGameService;

class FixtureController extends Controller
{
    private $gameService;

    public function __construct(IGameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        //check fixture, if fixture not created, redirect welcome page
        $fixtureCreated = $this->gameService->checkFixtureCreated();
        if (!$fixtureCreated){
            return redirect()->route('welcome');
        }

        // get fixture
        $fixture = $this->gameService->getFixture();

        return view('fixture', compact('fixture'));
    }

    public function generate()
    {
        $this->gameService->generateFixture();
        return redirect()->route('fixture');
    }
}
