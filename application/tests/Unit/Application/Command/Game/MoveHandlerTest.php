<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application\Command\Game;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TicTacToe\Application\Command\Game\Move;
use TicTacToe\Application\Command\Game\MoveHandler;
use TicTacToe\Application\Repository\Read\GameRepository as ReadGameRepository;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\BoardCell;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Id;
use TicTacToe\Domain\Player;

class MoveHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test_it_handles_game_move(): void
    {
        $gameId = new Id(1);
        $game = Game::fromArray([
            'id' => $gameId->toString(),
            'status' => GameStatus::OPEN->value,
            'board' => Board::default()->status,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ]);

        $player = Player::ONE;
        $boardCell = BoardCell::withCoordinate(1);

        $readRepository = $this->prophesize(ReadGameRepository::class);
        $readRepository->get($gameId)->willReturn($game)->shouldBeCalled();

        $handler = new MoveHandler($readRepository->reveal());

        $handler(new Move(
            $gameId,
            $player,
            $boardCell
        ));
    }
}