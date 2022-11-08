<?php

declare(strict_types=1);

namespace TicTacToe\Application\Repository\Read;

use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;

interface GameRepository
{
    public function get(Id $id): Game;
}
