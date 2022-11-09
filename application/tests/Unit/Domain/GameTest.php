<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Id;
use TicTacToe\Domain\Player;

class GameTest extends TestCase
{
    public function test_it_holds_game_data(): void
    {
        $data = [
            'id' => Uuid::uuid4()->toString(),
            'status' => GameStatus::OPEN->value,
            'board' => Board::default()->status,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ];

        $game = Game::fromArray($data);

        $this->assertSame($data['id'], $game->id->toString());
        $this->assertSame($data['status'], $game->status->value);
        $this->assertSame($data['board'], $game->board->status);
        $this->assertSame($data['nextPlayer'], $game->nextPlayer->value);
        $this->assertSame($data['winner'], $game->winner->value);
    }

    public function test_it_creates_a_default_game(): void
    {
        $id = new Id(Uuid::uuid4()->toString());

        $game = Game::default($id);

        $this->assertEquals(GameStatus::OPEN, $game->status);
        $this->assertEquals(Board::default(), $game->board);
        $this->assertEquals(Player::ONE, $game->nextPlayer);
        $this->assertEquals(Player::NONE, $game->winner);
    }

    /** @dataProvider winnedGamesDataProvider */
    public function test_if_game_has_a_won_board(string $board, bool $expectedWonStatus): void
    {
        $data = [
            'id' => Uuid::uuid4()->toString(),
            'status' => GameStatus::OPEN->value,
            'board' => $board,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ];

        $game = Game::fromArray($data);

        $this->assertSame($expectedWonStatus, $game->hasBeenWon());
    }

    /** @dataProvider staleGamesDataProvider */
    public function test_if_game_has_a_stale_board(string $board, bool $expectedStaleStatus): void
    {
        $data = [
            'id' => Uuid::uuid4()->toString(),
            'status' => GameStatus::CLOSE->value,
            'board' => $board,
            'nextPlayer' => Player::ONE->value,
            'winner' => Player::NONE->value,
        ];

        $game = Game::fromArray($data);

        $this->assertSame($expectedStaleStatus, $game->isStale());
    }

    public function winnedGamesDataProvider(): array
    {
        return [
            [Board::default()->status, false],
            [Board::WINNING_CONDITIONS[0], true],
            [Board::WINNING_CONDITIONS[5], true],
            ['112221121', false],
            ['111221112', true],
            ['222112221', true],
            ['122212221', true],
            ['221212122', true],
            ['221202122', false],
        ];
    }

    public function staleGamesDataProvider(): array
    {
        return [
            [Board::default()->status, false],
            [Board::WINNING_CONDITIONS[0], false],
            [Board::WINNING_CONDITIONS[1], false],
            [Board::WINNING_CONDITIONS[2], false],
            [Board::WINNING_CONDITIONS[3], false],
            [Board::WINNING_CONDITIONS[4], false],
            [Board::WINNING_CONDITIONS[5], false],
            [Board::WINNING_CONDITIONS[6], false],
            [Board::WINNING_CONDITIONS[7], false],
            [Board::WINNING_CONDITIONS[8], false],
            [Board::WINNING_CONDITIONS[9], false],
            [Board::WINNING_CONDITIONS[10], false],
            [Board::WINNING_CONDITIONS[11], false],
            [Board::WINNING_CONDITIONS[12], false],
            [Board::WINNING_CONDITIONS[13], false],
            [Board::WINNING_CONDITIONS[14], false],
            [Board::WINNING_CONDITIONS[15], false],
            ['112221121', true],
            ['111221112', false],
            ['222112221', false],
            ['122212221', false],
            ['221212122', false],
            ['221202122', false],
            ['212211122', true],
        ];
    }
}