<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\Command;
use TicTacToe\Domain\BoardCell;
use TicTacToe\Domain\Player;

final class Move implements Command
{
    public function __construct(
        public readonly Player $player,
        public readonly BoardCell $boardCell,
    ) {
    }
}
