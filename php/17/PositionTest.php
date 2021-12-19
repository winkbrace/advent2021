<?php declare(strict_types=1);

require_once 'Position.php';

use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /** @test */
    public function it_should_move() : void
    {
        $p = new Position(0,0);
        $p->step(3,5);

        self::assertSame(3, $p->x);
        self::assertSame(5, $p->y);

        $p->step(2,4);

        self::assertSame(5, $p->x);
        self::assertSame(9, $p->y);
    }
}
