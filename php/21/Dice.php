<?php declare(strict_types=1);

interface Dice
{
    public function roll(int $times = 1): int;

    public function rollCount(): int;
}
