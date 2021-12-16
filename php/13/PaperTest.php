<?php declare(strict_types=1);

require_once 'Paper.php';

use PHPUnit\Framework\TestCase;

class PaperTest extends TestCase
{
    private Paper $paper;

    protected function setUp() : void
    {
        parent::setUp();

        $this->paper = new Paper(file(__DIR__ . '/example.txt'));
    }

    public function test_it_parses_input(): void
    {
        self::assertCount(11, $this->paper->grid);
        self::assertCount(15, $this->paper->grid[0]);
        self::assertSame(0, $this->paper->grid[0][0]);
        self::assertSame(1, $this->paper->grid[6][10]);

        self::assertEquals([['y', 7],['x', 5]], $this->paper->folds);
    }

    public function test_it_should_fold(): void
    {
        $grid = $this->paper->fold();

        $expected = [
            [1,1,1,1,1,0,0],
            [1,0,0,0,1,0,0],
            [1,0,0,0,1,0,0],
            [1,0,0,0,1,0,0],
            [1,1,1,1,1,0,0],
        ];

        self::assertEquals($expected, $grid);
        self::assertSame(16, $this->paper->countDots());
    }

    public function test_it_should_count_dots(): void
    {
        $this->paper->fold(0);
        self::assertSame(17, $this->paper->countDots());
    }

    public function test_draw(): void
    {
        $this->paper->fold();
        ob_start();
        $this->paper->draw();
        $output = ob_get_clean();

        $expected = <<<DRAW
            #####
            #...#
            #...#
            #...#
            #####
            .....
            .....
            
            DRAW;
        self::assertSame($expected, $output);
    }
}
