<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class Game
{
    private function __construct(
        public readonly Id $id,
        public readonly GameStatus $status,
        public readonly Player $nextPlayer,
        public readonly Player $winner,
    )
    {

    }

    public static function fromArray(array $gameData): self
    {
        return new self(
            $gameData['id'],
            $gameData['status'],
            $gameData['nextPlayer'],
            $gameData['winner'],
        );
    }
}