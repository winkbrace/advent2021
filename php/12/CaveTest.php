<?php declare(strict_types=1);

require_once 'Cave.php';

use PHPUnit\Framework\TestCase;

class CaveTest extends TestCase
{
    public function test_is_big() : void
    {
        $cave = new Cave('xx');
        self::assertFalse($cave->isBig);

        $cave = new Cave('XX');
        self::assertTrue($cave->isBig);
    }
}
