<?php

namespace App\Layers\Service;

use App\Layers\Data\IGameData;

class GameService implements IGameService
{
    private IGameData $gameData;

    public function __construct(IGameData $gameData)
    {
        $this->gameData = $gameData;
    }

    public function getCurrentWeekGames()
    {
        $firstTwoNotPlayedGames = $this->gameData->getFirstTwoNotPlayed();

        return $firstTwoNotPlayedGames;
    }
}
