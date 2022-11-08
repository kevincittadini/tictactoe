<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

enum Player: int
{
    case NONE = 0;
    case ONE = 1;
    case TWO = 2;
}
