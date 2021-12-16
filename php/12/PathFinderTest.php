<?php declare(strict_types=1);

require_once 'SingleVisitPathFinder.php';
require_once 'DoubleVisitPathFinder.php';

use PHPUnit\Framework\TestCase;

class PathFinderTest extends TestCase
{
    private PathFinder $pathFinder;

    protected function setUp() : void
    {
        parent::setUp();

        $this->pathFinder = new SingleVisitPathFinder(file(__DIR__ . '/example1.txt'));
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

    public function test_it_finds_paths_of_example1(): void
    {
        $paths = $this->pathFinder->findPaths();
        // echo $this->pathFinder->pathsToString();

        self::assertCount(10, $paths);
    }

    public function test_it_finds_paths_of_example2(): void
    {
        $pathFinder = new SingleVisitPathFinder(file(__DIR__ . '/example2.txt'));
        $paths = $pathFinder->findPaths();

        self::assertCount(19, $paths);
    }

    public function test_it_finds_paths_of_example3(): void
    {
        $pathFinder = new SingleVisitPathFinder(file(__DIR__ . '/example3.txt'));
        $paths = $pathFinder->findPaths();

        self::assertCount(226, $paths);
    }

    public function test_it_finds_double_visit_paths_of_example1(): void
    {
        $pathFinder = new DoubleVisitPathFinder(file(__DIR__ . '/example1.txt'));
        $paths = $pathFinder->findPaths();

        self::assertCount(36, $paths);
    }

// Slow tests
//    public function test_it_finds_double_visit_paths_of_example2(): void
//    {
//        $pathFinder = new DoubleVisitPathFinder(file(__DIR__ . '/example2.txt'));
//        $paths = $pathFinder->findPaths();
//
//        self::assertCount(103, $paths);
//    }
//
//    public function test_it_finds_double_visit_paths_of_example3(): void
//    {
//        $pathFinder = new DoubleVisitPathFinder(file(__DIR__ . '/example3.txt'));
//        $paths = $pathFinder->findPaths();
//
//        self::assertCount(3509, $paths);
//    }
}
