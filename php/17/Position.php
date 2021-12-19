<?php declare(strict_types=1);

final class Position
{
    public function __construct(public int $x, public int $y) {}

    public function step(int $vx, int $vy): self
    {
        $this->x += $vx;
        $this->y += $vy;

        return $this;
    }
}
