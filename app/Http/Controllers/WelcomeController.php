<?php

namespace App\Http\Controllers;

use App\Helpers\FixtureHelper;
use App\Models\Team;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $teams = Team::all();

        // check fixture generated or not
        $fixtureCreated = FixtureHelper::checkFixtureCreated();
        if ($fixtureCreated){
            return redirect()->route('fixture');
        }
        FixtureHelper::generateFixture();

        return view('welcome', compact('teams'));
    }
}
