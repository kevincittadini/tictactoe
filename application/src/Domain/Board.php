<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class Board
{
    private function __construct(
        public string $status,
    ) {
    }

    public static function fromStatus(string $status): self
    {
        if (!self::isValid($status)) {
            throw new \DomainException("Invalid board status.");
        }

        return new self($status);
    }

    private static function isValid(string $status): bool
    {
        return preg_match("/[0-2]{9}/", $status) === 1;
    }
}
