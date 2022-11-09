<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\Command;
use TicTacToe\Domain\Game;

final class CreateGame implements Command
{
    public function __construct(
        public readonly Game $game
    ) {
    }
}
