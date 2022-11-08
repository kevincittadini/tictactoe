<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use TicTacToe\Application\Controller\GameController;
use TicTacToe\Application\Repository\Write\GameRepository as WriteGameRepository;

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

    public function it_creates_new_game(): void
    {

    }
}