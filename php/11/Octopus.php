<?php declare(strict_types=1);

final class Octopus
{
    public bool $hasFlashed = false;

    public function __construct(
        public int $r,
        public int $c,
        public int $level,
    ) {}

    public function flash() : void
    {
        $this->hasFlashed = true;
        $this->level = 0;
    }

    public function increment() : void
    {
        if (! $this->hasFlashed) {
            $this->level++;
        }
    }

    public function reset() : void
    {
        $this->hasFlashed = false;
    }
}
