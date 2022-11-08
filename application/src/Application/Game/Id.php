<?php

namespace TicTacToe\Application\Game;

use Ramsey\Uuid\UuidInterface;

final class Id implements \TicTacToe\Domain\Id
{
    public function __construct(
        public readonly int|string|UuidInterface $id
    ) {
    }
}
