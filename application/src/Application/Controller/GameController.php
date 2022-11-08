<?php

declare(strict_types=1);

namespace TicTacToe\Application\Controller;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Service\CommandHandlerManagerInterface;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;

final class GameController
{
    public function __construct(
        private readonly CommandHandlerManagerInterface $commandHandlerManager,
    ) {
    }

    #[Route(
        path: '/api/game',
        methods: ['POST']
    )]
    public function createAction(): Response
    {
        $id = new Id(Uuid::uuid4()->toString());
        $game = Game::default($id);

        $this->commandHandlerManager->handle(
            new CreateGame($game)
        );

        return new JsonResponse([
            'gameId' => $id->toString(),
            'board' => $game->board->status,
        ]);
    }

    #[Route(
        path: '/api/game/:gameId/player/:playerId/move/:boardCell',
        methods: ['POST']
    )]
    public function moveAction(): Response
    {
        return new JsonResponse([]);
    }
}
