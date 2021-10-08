<?php

namespace App\Layers\Data;

use App\Models\Game;

interface IGameData
{
    public function getFirstTwoNotPlayed();

    public function update(Game $game): bool;

    public function getLastTwoPlayed();

    public function deleteAll();
}