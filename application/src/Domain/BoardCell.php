<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class BoardCell
{
    private function __construct(
        public readonly int $cellCoordinate
    ) {
    }

    public static function withCoordinate(int $coordinate): self
    {
        if ($coordinate < 1 || $coordinate > 9) {
            throw new \DomainException('Invalid board cell.');
        }

        return new self($coordinate);
    }
}
