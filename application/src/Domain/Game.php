<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

/**
 * @psalm-type GameArray = array{id: int|string, status: string, board: string, nextPlayer: string, winner: string}
 */
final class Game
{
    private function __construct(
        public readonly Id $id,
        public readonly GameStatus $status,
        public readonly Board $board,
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
            Board::fromStatus($gameData['board']),
            Player::from($gameData['nextPlayer']),
            Player::from($gameData['winner']),
        );
    }

    public function hasBeenWon(): bool
    {
        foreach (Board::WINNING_CONDITIONS as $winningCondition) {
            if (1 === preg_match('/'.$winningCondition.'/', $this->board->status)) {
                return true;
            }
        }

        return false;
    }
}
