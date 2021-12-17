<?php declare(strict_types=1);

require_once 'Polymer.php';

use PHPUnit\Framework\TestCase;

class PolymerTest extends TestCase
{
    private Polymer $polymer;

    protected function setUp() : void
    {
        parent::setUp();

        $this->polymer = new Polymer(file(__DIR__ . '/example.txt'));
    }

    /** @test */
    public function it_should_parse_input() : void
    {
        self::assertSame('NNCB', $this->polymer->template);
        self::assertSame(['NN' => 1, 'NC' => 1, 'CB' => 1], $this->polymer->pairs);
        self::assertSame('B', $this->polymer->rules['CH']);
        self::assertSame('C', $this->polymer->rules['CN']);
    }

    /** @test */
    public function it_should_insert_elements() : void
    {
        $this->polymer->insert(1);
        self::assertEquals(['NC' => 1, 'CN' => 1, 'NB' => 1, 'BC' => 1, 'CH' => 1, 'HB' => 1], $this->polymer->pairs);

        // old way
        //self::assertSame('NBCCNBBBCBHCB', $this->polymer->insert(1));
        //self::assertSame('NBBBCNCCNBBNBNBBCHBHHBCHB', $this->polymer->insert(1));
        //self::assertSame('NBBNBNBBCCNBCNCCNBBNBBNBBBNBBNBBCBHCBHHNHCBBCBHCB', $this->polymer->insert(1));
    }

    /** @test */
    public function it_should_count_elements() : void
    {
        $this->polymer->insert(10);

        self::assertEquals(['B' => 1749, 'C' => 298, 'H' => 161, 'N' => 865], $this->polymer->count()->all());
    }
}
