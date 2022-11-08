<?php

namespace TicTacToe\Application\Service;

use TicTacToe\Application\Command\Command;

interface CommandHandlerManagerInterface
{
    public function handle(Command $command): void;
}
