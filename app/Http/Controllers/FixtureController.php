<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index()
    {
        // get fixture
        $fixture = DataHelper::$fixtureDesign;

        return view('fixture', compact('fixture'));
    }
}
