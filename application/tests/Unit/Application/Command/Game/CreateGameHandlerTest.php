<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application\Command\Game;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Command\Game\CreateGameHandler;
use TicTacToe\Application\Repository\Write\GameRepository;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Id;

class CreateGameHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function test_it_stores_new_game(): void
    {
        $id = new Id(1);
        $game = Game::default($id);

        $gameRepository = $this->prophesize(GameRepository::class);
        $gameRepository->store($game)->shouldBeCalled();

        (new CreateGameHandler($gameRepository->reveal()))(new CreateGame($game));
    }
}