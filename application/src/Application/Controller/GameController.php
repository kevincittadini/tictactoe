<?php

declare(strict_types=1);

namespace TicTacToe\Application\Controller;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TicTacToe\Application\Repository\Write\GameRepository;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;

final class GameController
{
    public function __construct(
        private GameRepository $writeGameRepository,
    ) {
    }

    #[Route(path: '/api/game', methods: ['POST'])]
    public function createAction(): Response
    {
        $id = new Id(Uuid::uuid4()->toString());

        $game = Game::default($id);

        $this->writeGameRepository->store($game);

        return new JsonResponse([
            'gameId' => $id->toString(),
            'board' => $game->board->status,
        ]);
    }
}
