<?php

namespace App\Layers\Data;

use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameData implements IGameData
{
    public function getFirstTwoNotPlayed()
    {
        return Game::where('played', false)->limit(2)->orderBy('week')->get();
    }

    public function update(Game $game): bool
    {
        return $game->save();
    }

    public function getLastTwoPlayed()
    {
        return Game::where('played', true)->limit(2)->orderBy('week', 'desc')->get();
    }

    public function deleteAll()
    {
        return DB::table('games')->delete();
    }

    public function getPlayedGames()
    {
        return Game::where('played', true)->orderBy('week')->get();
    }
}
