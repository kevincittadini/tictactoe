<?php

declare(strict_types=1);

namespace TicTacToe\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Game
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 10)]
    private string $status;

    #[ORM\Column(length: 9)]
    private string $board;

    #[ORM\Column(length: 1)]
    private string $nextPlayer;

    #[ORM\Column(length: 1)]
    private string $winner;

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBoard(): string
    {
        return $this->board;
    }

    public function setBoard(string $board): self
    {
        $this->board = $board;

        return $this;
    }

    public function getNextPlayer(): string
    {
        return $this->nextPlayer;
    }

    public function setNextPlayer(string $nextPlayer): self
    {
        $this->nextPlayer = $nextPlayer;

        return $this;
    }

    public function getWinner(): string
    {
        return $this->winner;
    }

    public function setWinner(string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
