<?php

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Write\GameRepository;

final class CreateGameHandler implements CommandHandler
{
    public function __construct(
        private readonly GameRepository $writeGameRepository
    ) {
    }

    public function __invoke(CreateGame $command): void
    {
        $this->writeGameRepository->store($command->game);
    }
}
