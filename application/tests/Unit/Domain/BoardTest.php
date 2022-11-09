<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Board;
use TicTacToe\Domain\BoardCell;

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

    /** @dataProvider cellsDataProvider */
    public function test_that_a_move_can_be_performed_on_empty_cells(int $coordinate): void
    {
        $board = Board::default();
        $boardCell = BoardCell::withCoordinate($coordinate);
        $this->assertTrue($board->moveCanBeDoneInCell($boardCell));
    }

    /** @dataProvider cellsDataProvider */
    public function test_that_a_move_can_not_be_performed_on_filled_cells(int $coordinate): void
    {
        $board = Board::fromStatus('100020001');
        $boardCell = BoardCell::withCoordinate($coordinate);
        $this->assertFalse($board->moveCanBeDoneInCell($boardCell));
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

    public function cellsDataProvider(): array
    {
        return [
            [1],
            [5],
            [9],
        ];
    }
}