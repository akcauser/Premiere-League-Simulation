<?php

namespace App\Http\Controllers;

use App\Helpers\SimulationHelper;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $pointTable = SimulationHelper::getPointTable();

        return view('simulation', compact('pointTable'));
    }
}
