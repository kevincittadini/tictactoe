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
}