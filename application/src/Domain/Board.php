<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class Board
{
    private const DEFAULT = '000000000';

    public const WINNING_CONDITIONS = [
        // Rows
        '111......',
        '...111...',
        '......111',

        '222......',
        '...222...',
        '......222',

        // Columns
        '1..1..1..',
        '.1..1..1.',
        '..1..1..1',

        '2..2..2..',
        '.2..2..2.',
        '..2..2..2',

        // Diagonals
        '1...1...1',
        '..1.1.1..',

        '2...2...2',
        '..2.2.2..',
    ];

    private function __construct(
        public string $status,
    ) {
    }

    public function moveCanBeDoneInCell(BoardCell $boardCell): bool
    {
        return '0' === $this->status[$boardCell->cellCoordinate - 1];
    }

    public static function default(): self
    {
        return new self(
            self::DEFAULT,
        );
    }

    public static function fromStatus(string $status): self
    {
        if (!self::isValid($status)) {
            throw new \DomainException('Invalid board status.');
        }

        return new self($status);
    }

    public function isInWinningCondition(): bool
    {
        foreach (Board::WINNING_CONDITIONS as $winningCondition) {
            if (1 === preg_match('/'.$winningCondition.'/', $this->status)) {
                return true;
            }
        }

        return false;
    }

    public function isInStaleCondition(): bool
    {
        return 1 === preg_match('/[1-2]{9}/', $this->status) && !$this->isInWinningCondition();
    }

    private static function isValid(string $status): bool
    {
        $validPlayers = sprintf(
            '(%s|%s|%s|%s)',
            Player::NONE->value, Player::ONE->value, Player::TWO->value, Player::ANY->value
        );

        return 1 === preg_match('/['.$validPlayers.']{9}/', $status);
    }
}
