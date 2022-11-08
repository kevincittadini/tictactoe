<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

/**
 * @psalm-type GameArray = array{id: int|string, status: string, nextPlayer: int, winner: int}
 */
final class Game
{
    private function __construct(
        public readonly Id $id,
        public readonly GameStatus $status,
        public readonly Player $nextPlayer,
        public readonly Player $winner,
    ) {
    }

    /**
     * @param GameArray $gameData
     */
    public static function fromArray(array $gameData): self
    {
        return new self(
            new Id($gameData['id']),
            GameStatus::from($gameData['status']),
            Player::from($gameData['nextPlayer']),
            Player::from($gameData['winner'])
        );
    }
}
