<?php

namespace App\Layers\Service;

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
        foreach ($firstTwoNotPlayedGames as $game)
        {
            $game->score_1 = rand(0,5);
            $game->score_2 = rand(0,5);
            $game->played = true;
            $response = $this->gameData->update($game);
            if (!$response)
                Log::error("Play Method Error, Game not saved");
        }
    }

    public function reset()
    {
        return $this->gameData->deleteAll();
    }
}
