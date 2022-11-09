<?php

declare(strict_types=1);

namespace TicTacToe\Application\Command\Game;

use TicTacToe\Application\Command\CommandHandler;
use TicTacToe\Application\Repository\Read\GameRepository as ReadGameRepository;
use TicTacToe\Application\Repository\Write\GameRepository as WriteGameRepository;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Player;

/**
 * @psalm-type GameArray = array{id: int|string, status: string, board: string, nextPlayer: string, winner: string}
 */
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

        $gameData = $this->doMove($game, $move);

        return Game::fromArray($gameData);
    }

    /** @return GameArray */
    private function doMove(Game $game, Move $move): array
    {
        $newBoard = $this->getNewBoardFromMove($game, $move);
        $newGameStatus = $newBoard->isInWinningCondition() || $newBoard->isInStaleCondition() ? GameStatus::CLOSE : GameStatus::OPEN;

        $winner = $newBoard->isInWinningCondition() ? $move->player : Player::NONE;
        $nextPlayer = Player::ONE === $move->player ? Player::TWO : Player::ONE;
        if (GameStatus::CLOSE === $newGameStatus) {
            $nextPlayer = Player::NONE;
        }

        return [
            'id' => $game->id->toString(),
            'status' => $newGameStatus->value,
            'board' => $newBoard->status,
            'nextPlayer' => $nextPlayer->value,
            'winner' => $winner->value,
        ];
    }

    private function getNewBoardFromMove(Game $game, Move $move): Board
    {
        $newBoardStatus = $game->board->status;
        $newBoardStatus[$move->boardCell->cellCoordinate - 1] = $move->player->value;

        return Board::fromStatus($newBoardStatus);
    }
}
