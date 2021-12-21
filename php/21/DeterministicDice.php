<?php declare(strict_types=1);

require_once 'Dice.php';

final class DeterministicDice implements Dice
{
    private int $prev = 0;
    private int $count = 0;

    public function roll(int $times = 1): int
    {
        $sum = 0;

        for ($i=0; $i<$times; $i++) {
            if (++$this->prev > 100) {
                $this->prev -= 100;
            }
            $sum += $this->prev;
            $this->count++;
        }

        return $sum;
    }

    public function rollCount(): int
    {
        return $this->count;
    }
}
