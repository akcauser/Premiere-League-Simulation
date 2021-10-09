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

    public function getGamesByWeek($week)
    {
        return Game::where('week', $week)->get();
    }

    public function getAnyGame()
    {
        return Game::limit(1)->get();
    }

    public function save($team_1, $team_2, $week): bool
    {
        $game = new Game;
        $game->team_1 = $team_1;
        $game->team_2 = $team_2;
        $game->week = $week;
        return $game->save();
    }

    public function getPlayedGamesByTeam1($team1)
    {
        return Game::where('played', true)->where('team_1', $team1)->get();
    }

    public function getPlayedGamesByTeam2($team2)
    {
        return Game::where('played', true)->where('team_2', $team2)->get();
    }

    public function getNotPlayedGamesByTeam1($team1)
    {
        return Game::where('played', false)->where('team_1', $team1)->get();
    }

    public function getNotPlayedGamesByTeam2($team2)
    {
        return Game::where('played', false)->where('team_2', $team2)->get();
    }
}
