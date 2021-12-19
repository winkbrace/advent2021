<?php declare(strict_types=1);

final class Area
{
    public function __construct(public int $minX, public int $maxX, public int $minY, public int $maxY) {
        if ($this->minX > $this->maxX || $this->minY > $this->maxY) {
            throw new InvalidArgumentException('Wrong order of inputs');
        }
    }
}
