<?php declare(strict_types=1);

final class Dirac
{
    public function __construct(private Dice $dice, private int $target) {}

    public function play(DiracPlayer ...$players): void
    {
        if (empty($players)) {
            throw new \InvalidArgumentException("Missing players");
        }

        while (true) {
            foreach ($players as $player) {
                $steps = $this->dice->roll(3);
                $player->move($steps);
                if ($player->score >= $this->target) {
                    break 2;
                }
            }
        }
    }
}
