<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application\Command\Game;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
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

    private Id $gameId;
    private Game $game;
    private BoardCell $boardCell;
    private Player $player;
    private ObjectProphecy $readRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gameId = new Id(1);
        $this->game = Game::fromArray([
            'id' => $this->gameId->toString(),
            'status' => GameStatus::OPEN->value,
            'board' => Board::default()->status,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ]);

        $this->player = Player::ONE;
        $this->boardCell = BoardCell::withCoordinate(1);

        $this->readRepository = $this->prophesize(ReadGameRepository::class);
    }

    public function test_it_throws_exception_if_game_is_not_found(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Game not found.");

        $this->readRepository->get($this->gameId)->willReturn(null)->shouldBeCalled();

        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $this->gameId,
            $this->player,
            $this->boardCell
        ));
    }

    public function test_it_throws_exception_if_game_is_closed_valid(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Game is closed.");

        $gameId = new Id(2);
        $game = Game::fromArray([
            'id' => $gameId->toString(),
            'status' => GameStatus::CLOSE->value,
            'board' => Board::default()->status,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::TWO->value,
        ]);

        $this->readRepository->get($gameId)->willReturn($game)->shouldBeCalled();

        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $gameId,
            Player::NONE,
            $this->boardCell
        ));
    }

    public function test_it_throws_exception_if_move_is_done_on_filled_cell(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Selected move cannot be performed because the cell is not empty.");

        $gameId = new Id(2);
        $game = Game::fromArray([
            'id' => $gameId->toString(),
            'status' => GameStatus::OPEN->value,
            'board' => Board::fromStatus('200000000')->status,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ]);

        $this->readRepository->get($gameId)->willReturn($game)->shouldBeCalled();

        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $gameId,
            Player::NONE,
            $this->boardCell
        ));
    }

    public function test_it_throws_exception_if_player_is_not_valid(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Player not valid.");

        $this->readRepository->get($this->gameId)->willReturn($this->game)->shouldBeCalled();

        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $this->gameId,
            Player::NONE,
            $this->boardCell
        ));
    }

    public function test_it_throws_exception_if_player_turn_is_not_valid(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Player 1 is the next to move.");

        $this->readRepository->get($this->gameId)->willReturn($this->game)->shouldBeCalled();

        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $this->gameId,
            Player::TWO,
            $this->boardCell
        ));
    }

    public function test_it_handles_game_move(): void
    {
        $this->readRepository->get($this->gameId)->willReturn($this->game)->shouldBeCalled();
        $handler = new MoveHandler($this->readRepository->reveal());

        $handler(new Move(
            $this->gameId,
            $this->player,
            $this->boardCell
        ));
    }
}