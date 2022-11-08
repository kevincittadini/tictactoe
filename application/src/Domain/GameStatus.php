<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

enum GameStatus: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
}
