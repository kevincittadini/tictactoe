<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

class BoardResultChecker
{
    public function check(Board $board, Player $player): BoardResult
    {
        $winningMovesCounter = 0;
        $boardStatus = str_split($board->status);

        foreach ($boardStatus as $i => $cell) {
            if ($cell === Player::NONE->value) {
                $newStatus = $boardStatus;
                $newStatus[$i] = $player->value;
                $newStatus = implode($newStatus);

                if (Board::fromStatus($newStatus)->isInWinningCondition()) {
                    $winningMovesCounter++;
                }
            }
        }

        if ($winningMovesCounter === 1) {
            return BoardResult::ALMOST_WINNING;
        }

        if ($winningMovesCounter > 1) {
            return BoardResult::ALWAYS_WINNING;
        }

        return BoardResult::NO_WINNING;
    }
}