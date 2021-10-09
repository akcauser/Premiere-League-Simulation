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

    public function getMatchTeams()
    {
        return Game::select('team_1')->groupBy('team_1')->orderBy('team_1')->get();
    }

    public function getPlayedGamesByTeam($teamName)
    {
        return Game::where('played', true)->orWhere(function ($query) use ($teamName){
            $query->where('team_1', $teamName);
            $query->where('team_2', $teamName);
        })->get();
    }

    public function remainingWeekNumber()
    {
        $nextFirstMatch = Game::where('played', false)->orderBy('week')->first();
        if (!isset($nextFirstMatch))
            return 0;
        return 7 - $nextFirstMatch->week;
    }
}
