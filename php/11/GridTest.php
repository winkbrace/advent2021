<?php declare(strict_types=1);

require_once 'Grid.php';

use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    private Grid $grid;

    protected function setUp() : void
    {
        parent::setUp();

        $this->grid = new Grid(file(__DIR__ . '/example.txt'));
    }

    /** @test */
    public function it_should_populate_the_grid() : void
    {
        $this->assertSame(5, $this->grid->grid[0][0]->level);
        $this->assertSame(4, $this->grid->grid[0][1]->level);
        $this->assertSame(6, $this->grid->grid[9][9]->level);
    }

    /** @test */
    public function it_should_cast_to_string() : void
    {
        $this->assertStringEqualsFile(__DIR__ . '/example.txt', $this->grid->__toString());
    }

    /** @test */
    public function it_should_find_adjacent() : void
    {
        $adjacent = $this->grid->adjacent(0, 0);
        self::assertCount(3, $adjacent);

        $adjacent = $this->grid->adjacent(9, 9);
        self::assertCount(3, $adjacent);
    }

    public function test_run() : void
    {
        // step 1
        $this->grid->run();

        $expected = <<<TXT
            6594254334
            3856965822
            6375667284
            7252447257
            7468496589
            5278635756
            3287952832
            7993992245
            5957959665
            6394862637
            
            TXT;

        self::assertSame($expected, $this->grid->__toString());

        // step 2
        $this->grid->run();

        $expected = <<<TXT
            8807476555
            5089087054
            8597889608
            8485769600
            8700908800
            6600088989
            6800005943
            0000007456
            9000000876
            8700006848
            
            TXT;

        self::assertSame($expected, $this->grid->__toString());

        // step 3
        $this->grid->run();

        $expected = <<<TXT
            0050900866
            8500800575
            9900000039
            9700000041
            9935080063
            7712300000
            7911250009
            2211130000
            0421125000
            0021119000
            
            TXT;

        self::assertSame($expected, $this->grid->__toString());
    }

    /** @test */
    public function it_should_count_flashes() : void
    {
        for ($i=0; $i<100; $i++) {
            $this->grid->run();
        }

        self::assertSame(1656, $this->grid->flashCount);
    }

    /** @test */
    public function it_should_find_when_all_octopuses_flash() : void
    {
        for ($i=1; $i<200; $i++) {
            $this->grid->run();
            if ($this->grid->allFlashed()) {
                break;
            }
        }

        self::assertSame(195, $i);
    }
}
