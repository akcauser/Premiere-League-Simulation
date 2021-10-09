<?php

namespace App\Layers\Service;

use App\Helpers\SimulationHelper;
use App\Layers\Data\IGameData;
use Illuminate\Support\Facades\Log;

class GameService implements IGameService
{
    private IGameData $gameData;

    public function __construct(IGameData $gameData)
    {
        $this->gameData = $gameData;
    }

    public function getLastWeekGames()
    {
        $lastTwoPlayed = $this->gameData->getLastTwoPlayed();

        if (count($lastTwoPlayed) == 0)
            $lastTwoPlayed = $this->gameData->getFirstTwoNotPlayed();

        return $lastTwoPlayed;
    }

    // todo: play game logic
    public function play()
    {
        $firstTwoNotPlayedGames = $this->gameData->getFirstTwoNotPlayed();
        if (count($firstTwoNotPlayedGames) == 0)
            return false;

        foreach ($firstTwoNotPlayedGames as $game)
        {
            $game->score_1 = rand(0,5);
            $game->score_2 = rand(0,5);
            $game->played = true;
            $response = $this->gameData->update($game);
            if (!$response)
                Log::error("Play Method Error, Game not saved");
        }

        return true;
    }

    public function reset()
    {
        return $this->gameData->deleteAll();
    }

    public function playAll()
    {
        $res = true;
        while ($res)
            $res = $this->play();
    }

    public function getPlayedGames()
    {
        return $this->gameData->getPlayedGames();
    }

    // todo: calculate prediction and logic
    public function getPredictions()
    {
        $predictions = [];
        $teams = $this->gameData->getMatchTeams();
        foreach ($teams as $team)
        {
            $predictions[$team->team_1] = 0;
        }

        // calculate prediction for each team
        $pointTable = SimulationHelper::getPointTable();
        $remainingWeekNumber = $this->gameData->remainingWeekNumber();


        foreach ($pointTable as $row){
            if ($pointTable[0]["pts"] - $row["pts"] > $remainingWeekNumber * 3)
                $predictions[$row["team"]] = 0;
        }

        // last 3 weeks check
        // if in last 3 week, check %100 case, if first_team_score - second_team_score > 9 then championship team = first_team
        // if in last 2 week, check %100 case, if first_team_score - second_team_score > 6 then championship team = first_team
        // if in last 1 week, check %100 case, if first_team_score - second_team_score > 3 then championship team = first_team
        if ($remainingWeekNumber < 3 && $pointTable[0]["pts"] - $pointTable[1]["pts"] > $remainingWeekNumber*3){
            $predictions[$pointTable[0]["team"]] = 100;
            $predictions[$pointTable[1]["team"]] = 0;
            $predictions[$pointTable[2]["team"]] = 0;
            $predictions[$pointTable[3]["team"]] = 0;
            return $predictions;
        }


        return $predictions;
    }
}
