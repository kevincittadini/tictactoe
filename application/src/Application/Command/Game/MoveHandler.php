<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Read\GameRepository as ReadGameRepository;

final class MoveHandler implements CommandHandler
{
    public function __construct(
        private readonly ReadGameRepository $readGameRepository,
    )
    {

    }

    public function __invoke(Move $move): void
    {
        $game = $this->readGameRepository->get($move->gameId);
    }
}