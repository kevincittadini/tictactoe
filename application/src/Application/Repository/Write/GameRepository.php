<?php

declare(strict_types=1);

namespace TicTacToe\Application\Repository\Write;

use TicTacToe\Domain\Game;

interface GameRepository
{
    public function store(Game $game): void;
}
