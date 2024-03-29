<?php

declare(strict_types=1);

namespace TicTacToe\Infrastructure\Repository\Write;

use Doctrine\ORM\EntityManagerInterface;
use TicTacToe\Application\Entity\Game;
use TicTacToe\Application\Repository\Write\GameRepository as WriteGameRepository;
use TicTacToe\Domain\Game as GameDTO;

/** @psalm-suppress UndefinedInterfaceMethod */
final class GameRepository implements WriteGameRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function store(GameDTO $game): void
    {
        $gameEntity = new Game();
        $gameEntity->setId($game->id->toString());
        $gameEntity->setBoard($game->board->status);
        $gameEntity->setStatus($game->status->value);
        $gameEntity->setNextPlayer($game->nextPlayer->value);
        $gameEntity->setWinner($game->winner->value);

        $this->em->merge($gameEntity);
        $this->em->flush();
    }
}
