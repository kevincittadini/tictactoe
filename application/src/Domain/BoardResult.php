<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

enum BoardResult: int
{
    case NO_WINNING = 0;
    case ALWAYS_WINNING = 1;
    case ALMOST_WINNING = 2;
}
