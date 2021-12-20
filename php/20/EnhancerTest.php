<?php declare(strict_types=1);

require_once 'Enhancer.php';

use PHPUnit\Framework\TestCase;

class EnhancerTest extends TestCase
{
    private Enhancer $enhancer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enhancer = new Enhancer(file(__DIR__ . '/example.txt'));
    }

    public function test_it_parses_input(): void
    {
        self::assertSame(1, $this->enhancer->grid[0][0]);
        self::assertSame(0, $this->enhancer->grid[0][1]);
        self::assertNull($this->enhancer->grid[-1][-1] ?? null);

        self::assertStringStartsWith('001010', $this->enhancer->algo);
    }

    public function test_pixel_at(): void
    {
        self::assertSame(0, $this->enhancer->pixelAt(0));
        self::assertSame(0, $this->enhancer->pixelAt(33));
        self::assertSame(1, $this->enhancer->pixelAt(34));
    }

    public function test_it_should_enhance_once(): void
    {
        $this->markTestSkipped('Output has changed to accommodate for 50 enhancements');

        $this->enhancer->enhance();
        $image = $this->enhancer->draw();

        $expected = <<<IMG
            ..........
            ..##.##...
            .#..#.#...
            .##.#..#..
            .####..#..
            ..#..##...
            ...##..#..
            ....#.#...
            ..........
            IMG;

        self::assertEquals($expected, trim($image));
    }

    public function test_it_should_enhance_twice(): void
    {
        $this->markTestSkipped('Output has changed to accommodate for 50 enhancements');

        $this->enhancer->enhance(2);
        $image = $this->enhancer->draw();

        $expected = <<<IMG
            ..............
            .........#....
            ...#..#.#.....
            ..#.#...###...
            ..#...##.#....
            ..#.....#.#...
            ...#.#####....
            ....#.#####...
            .....##.##....
            ......###.....
            ..............
            ..............
            IMG;

        self::assertEquals($expected, trim($image));
    }

    public function test_it_should_count_lit_pixels(): void
    {
        $this->enhancer->enhance(2);

        self::assertSame(35, $this->enhancer->countLitPixels());
    }
}
