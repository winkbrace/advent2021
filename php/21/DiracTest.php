<?php declare(strict_types=1);

require_once 'DeterministicDice.php';
require_once 'Dirac.php';
require_once 'DiracPlayer.php';

use PHPUnit\Framework\TestCase;

class DiracTest extends TestCase
{
    private DeterministicDice $dice;
    private Dirac $dirac;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dice = new DeterministicDice();
        $this->dirac = new Dirac($this->dice, 1000);
    }

    public function test_play(): void
    {
        $p1 = new DiracPlayer(4);
        $p2 = new DiracPlayer(8);
        $this->dirac->play($p1, $p2);

        self::assertSame(1000, $p1->score);
        self::assertSame(745, $p2->score);
        self::assertSame(993, $this->dice->rollCount());
    }
}
