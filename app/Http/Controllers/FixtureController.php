<?php

namespace App\Http\Controllers;

use App\Helpers\FixtureHelper;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixtureController extends Controller
{
    public function index()
    {
        $fixtureCreated = FixtureHelper::checkFixtureCreated();
        if (!$fixtureCreated){
            FixtureHelper::generateFixture();
        }

        // get fixture
        $fixture = FixtureHelper::getFixture();


        return view('fixture', compact('fixture'));
    }
}
