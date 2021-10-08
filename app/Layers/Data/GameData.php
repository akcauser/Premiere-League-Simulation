<?php

namespace App\Layers\Data;

use App\Models\Game;

class GameData implements IGameData
{
    public function getFirstTwoNotPlayed()
    {
        return Game::where('played', false)->limit(2)->orderBy('week')->get();
    }
}
