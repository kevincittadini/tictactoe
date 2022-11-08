<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class Board
{
    private const DEFAULT = '000000000';

    const WINNING_CONDITIONS = [
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

    private static function isValid(string $status): bool
    {
        $validPlayers = sprintf(
            '(%s|%s|%s|%s)',
            Player::NONE->value, Player::ONE->value, Player::TWO->value, Player::ANY->value
        );

        return 1 === preg_match('/['.$validPlayers.']{9}/', $status);
    }
}
