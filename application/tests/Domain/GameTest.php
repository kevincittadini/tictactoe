<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Domain;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
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
}