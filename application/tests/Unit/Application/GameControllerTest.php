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
use TicTacToe\Application\Repository\Read\GameRepository;
use TicTacToe\Application\Service\CommandHandlerManagerInterface;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameStatus;
use TicTacToe\Domain\Id;
use TicTacToe\Domain\Player;


class GameControllerTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $commandHandlerManager;
    private GameController $controller;
    private ObjectProphecy $gameRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandHandlerManager = $this->prophesize(CommandHandlerManagerInterface::class);
        $this->gameRepository = $this->prophesize(GameRepository::class);

        $this->controller = new GameController(
            $this->commandHandlerManager->reveal(),
            $this->gameRepository->reveal(),
        );
    }

    public function test_creates_new_game(): void
    {
        $this->commandHandlerManager->handle(Argument::type(CreateGame::class))->shouldBeCalled();
        $response = $this->responseToArray($this->controller->createAction());

        $this->assertTrue(Uuid::isValid($response['gameId']));
        $this->assertEquals(Board::default()->status, $response['board']);
    }

    public function test_returns_game_data_structure(): void
    {
        $response = $this->responseToArray($this->controller->createAction());
        $gameId = $response['gameId'];

        $gameDataStructure = [
            'id' => $gameId,
            'board' => Board::default()->status,
            'winner' => Player::NONE->value,
            'nextPlayer' => Player::TWO->value,
            'status' => GameStatus::OPEN->value,
        ];

        $game = Game::fromArray($gameDataStructure);

        $this->gameRepository->get(new Id($gameId))->shouldBeCalled()->willReturn($game);

        $actualResponse = $this->responseToArray($this->controller->getAction($gameId));
        $expectedResponse = [
            'board' => Board::default()->status,
            'winner' => Player::NONE->value,
            'staleCondition' => false,
            'gameStatus' => GameStatus::OPEN->value,
        ];

        $this->assertEquals($expectedResponse, $actualResponse);
    }

    public function test_it_throws_an_error_if_game_is_not_found(): void
    {
        $gameId = '123';

        $this->gameRepository->get(new Id($gameId))->shouldBeCalled()->willReturn(null);
        $actualResponse = $this->responseToArray($this->controller->getAction($gameId));

        $this->assertEquals(['error' => 'Game not found'], $actualResponse);
    }

    private function responseToArray(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }
}