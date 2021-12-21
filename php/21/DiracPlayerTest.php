<?php declare(strict_types=1);

require_once 'DiracPlayer.php';

use PHPUnit\Framework\TestCase;

class DiracPlayerTest extends TestCase
{
    public function test_it_should_move(): void
    {
        $player = new DiracPlayer(3);
        $player->move(14);

        self::assertSame(7, $player->position);
        self::assertSame(7, $player->score);

        $player->move(8);
        self::assertSame(5, $player->position);
        self::assertSame(12, $player->score);
    }

    public function test_it_has_position_10_not_0(): void
    {
        $player = new DiracPlayer(3);
        $player->move(7);

        self::assertSame(10, $player->position);
    }
}
