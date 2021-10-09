<?php

namespace App\Layers\Service;

interface IGameService
{
    public function getLastWeekGames();

    public function play();

    public function reset();

    public function playAll();

    public function getPlayedGames();

    public function getPredictions();

    public function getFixture();

    public function checkFixtureCreated(): bool;

    public function generateFixture(): bool;

    public function getPointTable(): array;
}
