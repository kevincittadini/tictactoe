<?php

declare(strict_types=1);

namespace TicTacToe\Application\Controller;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Command\Game\Move;
use TicTacToe\Application\Service\CommandHandlerManagerInterface;
use TicTacToe\Domain\BoardCell;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;
use TicTacToe\Domain\Player;

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
        try {
            $id = new Id(Uuid::uuid4()->toString());
            $game = Game::default($id);

            $this->commandHandlerManager->handle(new CreateGame($game));

            return new JsonResponse(
                [
                    'gameId' => $id->toString(),
                    'board' => $game->board->status,
                ],
                Response::HTTP_CREATED
            );
        } catch (\DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(
        path: '/api/game/:gameId/player/:playerId/move/:boardCell',
        methods: ['POST']
    )]
    public function moveAction(string $gameId, string $playerId, string $boardCell): Response
    {
        try {
            $gameId = new Id($gameId);
            $movingPlayer = Player::from($playerId);
            $boardCell = BoardCell::withCoordinate((int) $boardCell);

            $moveCommand = new Move(
                $gameId,
                $movingPlayer,
                $boardCell
            );

            /** @var Game $game */
            $game = $this->commandHandlerManager->handle($moveCommand);

            return new JsonResponse(
                [
                    'board' => $game->board->status,
                    'winner' => $game->winner->value,
                    'staleCondition' => $game->board->isInStaleCondition(),
                    'gameStatus' => $game->status->value,
                ],
                Response::HTTP_OK
            );
        } catch (\DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
