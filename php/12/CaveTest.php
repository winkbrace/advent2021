<?php declare(strict_types=1);

require_once 'Cave.php';

use PHPUnit\Framework\TestCase;

class CaveTest extends TestCase
{
    public function test_is_small() : void
    {
        $cave = new Cave('xx');
        self::assertTrue($cave->isSmall);

        $cave = new Cave('XX');
        self::assertFalse($cave->isSmall);
    }
}
