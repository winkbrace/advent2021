<?php declare(strict_types=1);

final class DiracPlayer
{
    public function __construct(public int $position, public int $score = 0) {}

    public function move(int $steps): void
    {
        $this->position = ($this->position + $steps) % 10;
        if ($this->position === 0) {
            $this->position = 10;
        }

        $this->score += $this->position;
    }
}
