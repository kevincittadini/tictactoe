<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Controller\GameController;
use TicTacToe\Application\Service\CommandHandlerManagerInterface;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;


class GameControllerTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $commandHandlerManager;
    private GameController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandHandlerManager = $this->prophesize(CommandHandlerManagerInterface::class);

        $this->controller = new GameController(
            $this->commandHandlerManager->reveal()
        );
    }

    public function test_creates_new_game(): void
    {
        $this->commandHandlerManager->handle(Argument::type(CreateGame::class))->shouldBeCalled();
        $response = $this->responseToArray($this->controller->createAction());

        $this->assertTrue(Uuid::isValid($response['gameId']));
        $this->assertEquals(Board::default()->status, $response['board']);
    }

    private function responseToArray(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }
}