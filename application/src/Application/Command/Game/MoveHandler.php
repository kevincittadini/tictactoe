<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Read\GameRepository as ReadGameRepository;
use TicTacToe\Application\Repository\Write\GameRepository as WriteGameRepository;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;

final class MoveHandler implements CommandHandler
{
    public function __construct(
        private readonly ReadGameRepository $readGameRepository,
        private readonly WriteGameRepository $writeGameRepository,
    ) {
    }

    public function __invoke(Move $move): Game
    {
        $game = $this->readGameRepository->get($move->gameId);

        if (!$game) {
            throw new \DomainException('Game not found.');
        }

        if (GameStatus::CLOSE === $game->status) {
            throw new \DomainException('Game is closed.');
        }

        if (!$game->board->moveCanBeDoneInCell($move->boardCell)) {
            throw new \DomainException('Selected move cannot be performed because the cell is not empty.');
        }

        if (!$move->player->isValidPlayerToMove()) {
            throw new \DomainException('Player not valid.');
        }

        if ($game->nextPlayer !== $move->player) {
            throw new \DomainException(sprintf('Player %s is the next to move.', $game->nextPlayer->value));
        }

//        $newGameState = [
//            'id' => $game->id->toString(),
//            'status' =>
//        ];
//
//        $newGameInstance = Game::fromArray($newGameState);
//
//        return $newGameInstance;
        return $game;
    }
}
