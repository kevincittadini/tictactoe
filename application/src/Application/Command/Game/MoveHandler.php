<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Read\GameRepository as ReadGameRepository;

final class MoveHandler implements CommandHandler
{
    public function __construct(
        private readonly ReadGameRepository $readGameRepository,
    ) {
    }

    public function __invoke(Move $move): void
    {
        $game = $this->readGameRepository->get($move->gameId);

        if (!$game) {
            throw new \DomainException('Game not found.');
        }

        if (!$move->player->isMoveValid()) {
            throw new \DomainException('Player not valid.');
        }

        if ($game->nextPlayer !== $move->player) {
            throw new \DomainException(sprintf('Player %s is the next to move.', $game->nextPlayer->value));
        }
    }
}
