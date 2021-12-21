<?php declare(strict_types=1);

require_once 'DeterministicDice.php';

use PHPUnit\Framework\TestCase;

class DeterministicDiceTest extends TestCase
{
    public function test_roll(): void
    {
        $dice = new DeterministicDice();

        for ($i=1; $i<=100; $i++) {
            self::assertSame($i, $dice->roll());
        }

        // 101st should wrap to 1
        self::assertSame(1, $dice->roll());
    }

    public function test_it_should_roll_three_times(): void
    {
        $dice = new DeterministicDice();

        self::assertSame(6, $dice->roll(3));
    }

    public function test_it_should_count_rolls(): void
    {
        $dice = new DeterministicDice();
        $dice->roll(15);
        $dice->roll(2);

        self::assertSame(17, $dice->rollCount());
    }
}
