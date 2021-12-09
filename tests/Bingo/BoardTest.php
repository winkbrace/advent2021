<?php declare(strict_types=1);

use Advent\Bingo\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private Board $board;

    protected function setUp(): void
    {
        parent::setUp();

        $this->board = new Board([
            "38 52 84 75 91\n",
            "77  5 49 71 31\n",
            "45  1 60  0 10\n",
            "68 29 98 36 34\n",
            "61 90 93 14 12\n",
        ]);
    }

    public function test_it_parses_zeroes(): void
    {
        self::assertSame(0, $this->board->grid[2][3]->nr);
    }
}
