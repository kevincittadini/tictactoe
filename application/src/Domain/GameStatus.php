<?php

namespace TicTacToe\Domain;

enum GameStatus: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
}