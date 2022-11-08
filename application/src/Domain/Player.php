<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

enum Player: string
{
    case NONE = '0';
    case ONE = '1';
    case TWO = '2';
    case ANY = '.';
}
