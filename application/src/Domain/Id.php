<?php

namespace TicTacToe\Domain;

final class Id
{
    public function __construct(
        private readonly int|string $id
    ) {
    }

    public function toString(): string
    {
        return (string) $this->id;
    }
}
