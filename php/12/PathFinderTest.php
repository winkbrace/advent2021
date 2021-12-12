<?php declare(strict_types=1);

require_once 'PathFinder.php';

use PHPUnit\Framework\TestCase;

class PathFinderTest extends TestCase
{
    private PathFinder $pathFinder;

    protected function setUp() : void
    {
        parent::setUp();

        $this->pathFinder = new PathFinder(file(__DIR__ . '/example1.txt'));
    }

    /** @test */
    public function it_should_find_all_caves() : void
    {
        self::assertCount(6, $this->pathFinder->caves);
    }

    /** @test */
    public function it_should_connect() : void
    {
        $connections = $this->pathFinder->caves['start']->connections;

        self::assertCount(2, $connections);
        self::assertSame('A', $connections[0]->id);
        self::assertSame('b', $connections[1]->id);
    }
}
