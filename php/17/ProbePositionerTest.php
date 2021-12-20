<?php declare(strict_types=1);

require_once 'ProbePositioner.php';

use PHPUnit\Framework\TestCase;

class ProbePositionerTest extends TestCase
{
    /** @test */
    public function it_should_calculate_next_position() : void
    {
        $positioner = new ProbePositioner(7,2);
        $positioner->step();

        self::assertSame(6, $positioner->vx);
        self::assertSame(1, $positioner->vy);
    }

    /** @test */
    public function x_should_move_to_zero() : void
    {
        $positioner = new ProbePositioner(-2,2);

        $positioner->step();
        self::assertSame(-1, $positioner->vx);

        $positioner->step(2);
        self::assertSame(0, $positioner->vx);

        $positioner = new ProbePositioner(2,2);
        $positioner->step(3);
        self::assertSame(0, $positioner->vx);
    }

    /** @test */
    public function y_should_always_increase_negatively() : void
    {
        $positioner = new ProbePositioner(2,2);

        $positioner->step();
        self::assertSame(1, $positioner->vy);

        $positioner->step(2);
        self::assertSame(-1, $positioner->vy);

        $positioner = new ProbePositioner(2,-2);
        $positioner->step();
        self::assertSame(-3, $positioner->vy);
    }

    /** @test */
    public function it_should_find_whether_probe_hits_area() : void
    {
        $positioner = new ProbePositioner(7,2);
        $area = new Area(20,30,-10,-5);

        self::assertTrue($positioner->hitsTargetArea($area));
        self::assertSame(28, $positioner->position->x);
        self::assertSame(-7, $positioner->position->y);
    }

    /** @test */
    public function it_should_find_whether_probe_hits_area2() : void
    {
        $positioner = new ProbePositioner(6,3);
        $area = new Area(20,30,-10,-5);

        self::assertTrue($positioner->hitsTargetArea($area));
        self::assertSame(21, $positioner->position->x);
        self::assertSame(-9, $positioner->position->y);
    }

    /** @test */
    public function it_should_find_whether_probe_hits_area3() : void
    {
        $positioner = new ProbePositioner(9,0);
        $area = new Area(20,30,-10,-5);

        self::assertTrue($positioner->hitsTargetArea($area));
        self::assertSame(30, $positioner->position->x);
        self::assertSame(-6, $positioner->position->y);
    }

    /** @test */
    public function it_should_find_whether_probe_hits_area4() : void
    {
        $positioner = new ProbePositioner(17,4);
        $area = new Area(20,30,-10,-5);

        self::assertFalse($positioner->hitsTargetArea($area));
        self::assertSame(33, $positioner->position->x);
    }
}
