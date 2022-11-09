<?php

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Write\GameRepository;

final class CreateGameHandler implements CommandHandler
{
    public function __construct(
        private readonly GameRepository $gameRepository
    ) {
    }

    public function __invoke(CreateGame $command): void
    {
        $this->gameRepository->store($command->game);
    }
}
