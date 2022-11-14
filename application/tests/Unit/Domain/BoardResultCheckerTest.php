<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\BoardResult;
use TicTacToe\Domain\Player;
use TicTacToe\Domain\BoardResultChecker;

class BoardResultCheckerTest extends TestCase
{
    private BoardResultChecker $boardResultChecker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->boardResultChecker = new BoardResultChecker();
    }

    /** @dataProvider almostWinningSituationDataProvider */
    public function test_for_one_move_winning_situation(string $boardStatus, Player $nextPlayer, BoardResult $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->boardResultChecker->check(Board::fromStatus($boardStatus), $nextPlayer));
    }

    public function almostWinningSituationDataProvider(): array
    {
        return [
            ['000000000', Player::ONE, BoardResult::NO_WINNING],
            ['110000000', Player::ONE, BoardResult::ALMOST_WINNING],
            ['110000011', Player::ONE, BoardResult::ALWAYS_WINNING],
            ['110000011', Player::ONE, BoardResult::ALWAYS_WINNING],
            ['110122002', Player::ONE, BoardResult::ALWAYS_WINNING],
            ['110122002', Player::TWO, BoardResult::ALMOST_WINNING],
            ['112211212', Player::ONE, BoardResult::NO_WINNING],
            ['112211212', Player::TWO, BoardResult::NO_WINNING],
        ];
    }
}