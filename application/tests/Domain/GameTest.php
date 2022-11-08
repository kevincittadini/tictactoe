<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Domain;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TicTacToe\Application\Game\Id;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Player;

class GameTest extends TestCase
{
    public function test_it_holds_game_data(): void
    {
        $data = [
            'id' => new Id(Uuid::uuid4()),
            'status' => GameStatus::OPEN,
            'nextPlayer' => Player::ONE,
            'winner' => Player::NONE,
        ];

        $game = Game::fromArray($data);

        $this->assertSame($data['id'], $game->id);
        $this->assertSame($data['status'], $game->status);
        $this->assertSame($data['nextPlayer'], $game->nextPlayer);
        $this->assertSame($data['winner'], $game->winner);
    }
}