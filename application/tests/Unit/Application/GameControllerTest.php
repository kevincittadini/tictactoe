<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use TicTacToe\Application\Controller\GameController;
use TicTacToe\Application\Repository\Write\GameRepository as WriteGameRepository;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Id;
use TicTacToe\Domain\Player;

class GameControllerTest extends TestCase
{
    use ProphecyTrait;

    private WriteGameRepository|ObjectProphecy $writeGameRepository;
    private GameController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->writeGameRepository = $this->prophesize(WriteGameRepository::class);

        $this->controller = new GameController(
            $this->writeGameRepository->reveal()
        );
    }

    public function test_creates_new_game(): void
    {
        $this->writeGameRepository->store(Argument::type(Game::class))->shouldBeCalled();
        $response = $this->responseToArray($this->controller->createAction());

        $this->assertTrue(Uuid::isValid($response['gameId']));
        $this->assertEquals(Board::default()->status, $response['board']);
    }

    private function responseToArray(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }
}