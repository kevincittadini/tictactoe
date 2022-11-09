<?php

declare(strict_types=1);

namespace TicTacToe\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\BoardCell;

class BoardCellTest extends TestCase
{
    public function test_it_can_hold_cell_coordinate(): void
    {
        $this->assertSame(1, BoardCell::withCoordinate(1)->cellCoordinate);
        $this->assertSame(9, BoardCell::withCoordinate(9)->cellCoordinate);
    }

    /** @dataProvider notValidCoordinatesDataProvider */
    public function test_it_throws_exception_if_coordinate_is_not_valid(int $invalidCoordinate): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Invalid board cell.");

        BoardCell::withCoordinate($invalidCoordinate);
    }

    public function notValidCoordinatesDataProvider(): array
    {
        return [
            [0],
            [10],
            [1000],
        ];
    }
}