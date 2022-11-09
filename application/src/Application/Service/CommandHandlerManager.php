<?php

declare(strict_types=1);

namespace TicTacToe\Application\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use TicTacToe\Application\Command\Command;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Command\Game\CreateGameHandler;
use TicTacToe\Application\Command\Game\Move;
use TicTacToe\Application\Command\Game\MoveHandler;

final class CommandHandlerManager implements CommandHandlerManagerInterface
{
    private array $classesMap;

    public function __construct(
        private readonly ContainerInterface $container
    ) {
        $this->classesMap = [
            CreateGame::class => CreateGameHandler::class,
            Move::class => MoveHandler::class,
        ];
    }

    public function handle(Command $command): mixed
    {
        if (isset($this->classesMap[get_class($command)])) {
            $handlerClass = $this->classesMap[get_class($command)];
            $handler = $this->container->get($handlerClass);

            if (is_callable($handler)) {
                return $handler($command);
            }
        }

        return null;
    }
}
