<?php declare(strict_types=1);

require_once 'Position.php';
require_once 'Area.php';

final class ProbePositioner
{
    public Position $position;

    public function __construct(public int $vx, public int $vy)
    {
        $this->position = new Position(0,0);
    }

    public function hitsTargetArea(Area $area) : bool
    {
        while ($this->position->y >= $area->minY && $this->position->x <= $area->maxX) {
            // dump($this->position);
            if ($this->position->x >= $area->minX && $this->position->y <= $area->maxY) {
                return true;
            }

            $this->step();
        }

        return false;
    }

    public function step($t = 1): Position
    {
        for ($i=0; $i<$t; $i++) {
            $this->position->step($this->vx, $this->vy);
            $this->nextVx();
            $this->nextVy();
        }

        return $this->position;
    }

    private function nextVx(): int
    {
        if ($this->vx === 0) return 0;

        return $this->vx < 0 ? ++$this->vx : --$this->vx;
    }

    private function nextVy(): int
    {
        return --$this->vy;
    }
}
