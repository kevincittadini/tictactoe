<?php

declare(strict_types=1);

namespace TicTacToe\Application\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use TicTacToe\Application\Command\Command;
use TicTacToe\Application\Command\Game\CreateGame;
use TicTacToe\Application\Command\Game\CreateGameHandler;

final class CommandHandlerManager implements CommandHandlerManagerInterface
{
    private array $classesMap;

    public function __construct(
        private readonly ContainerInterface $container
    ) {
        $this->classesMap = [
            CreateGame::class => [CreateGameHandler::class],
        ];
    }

    public function handle(Command $command): void
    {
        if (isset($this->classesMap[get_class($command)])) {
            foreach ($this->classesMap[get_class($command)] as $handlerClass) {
                $handler = $this->container->get($handlerClass);
                if (is_callable($handler)) {
                    $handler($command);
                }
            }
        }
    }
}
