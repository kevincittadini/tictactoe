<?php

declare(strict_types=1);

namespace TicTacToe\Infrastructure\Repository\Read;

use Doctrine\ORM\EntityManagerInterface;
use TicTacToe\Application\Entity\Game as GameEntity;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;

final class GameRepository implements \TicTacToe\Application\Repository\Read\GameRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function get(Id $id): Game|null
    {
        /** @var GameEntity|null $gameEntity */
        $gameEntity = $this->em->getRepository(GameEntity::class)->find($id->toString());

        if (!$gameEntity) {
            return null;
        }

        return Game::fromArray([
            'id' => $id->toString(),
            'status' => $gameEntity->getStatus(),
            'board' => $gameEntity->getBoard(),
            'nextPlayer' => $gameEntity->getNextPlayer(),
            'winner' => $gameEntity->getWinner(),
        ]);
    }
}
