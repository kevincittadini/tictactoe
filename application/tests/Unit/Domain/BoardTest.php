<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Board;

class BoardTest extends TestCase
{
    /** @dataProvider validBoardStatusesDataProvider */
    public function test_it_can_be_init_with_valid_status(string $boardStatus): void
    {
        $this->assertSame($boardStatus, Board::fromStatus($boardStatus)->status);
    }

    /** @dataProvider notValidBoardStatusesDataProvider */
    public function test_it_throws_exception_if_not_valid_board_status(string $boardStatus): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Invalid board status.");

        Board::fromStatus($boardStatus);
    }

    public function validBoardStatusesDataProvider(): array
    {
        return [
            ['000000000'],
            ['102012000'],
            ['121212121'],
        ];
    }

    public function notValidBoardStatusesDataProvider(): array
    {
        return [
            ['00000000'],
            ['000000123'],
            ['ciao']
        ];
    }
}