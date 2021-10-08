<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $teams = DataHelper::$teams;
        return view('welcome', compact('teams'));
    }
}
