<?php

declare(strict_types=1);

namespace TicTacToe\Application\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TicTacToe\Application\Repository\Write\GameRepository;

final class GameController
{
    public function __construct(
        GameRepository $writeGameRepository,
    ) {
    }

    #[Route(path: '/api/game', methods: ['POST'])]
    public function createAction(Request $request): Response
    {
        return new JsonResponse();
    }
}
