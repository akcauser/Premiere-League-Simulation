<?php

namespace App\Layers\Service;

interface IGameService
{
    public function getLastWeekGames();

    public function play();

    public function reset();

    public function playAll();

    public function getPlayedGames();
}
