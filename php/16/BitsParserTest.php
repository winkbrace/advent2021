<?php declare(strict_types=1);

require_once 'BitsParser.php';

use PHPUnit\Framework\TestCase;

class BitsParserTest extends TestCase
{
    public function test_it_should_convert_hex_to_bin(): void
    {
        $parser = new BitsParser('D2FE28');
        self::assertSame("110100101111111000101000", $parser->bits);
    }

    public function test_it_should_find_literal_packet(): void
    {
        $parser = new BitsParser('D2FE28');
        $packet = $parser->packets[0];

        self::assertSame('011111100101', $packet->literal);
        self::assertSame(2021, bindec($packet->literal));
    }

    public function test_it_should_decode_operator_packet(): void
    {
        $parser = new BitsParser('38006F45291200');
        $packet = $parser->packets[0];

        self::assertSame('00111000000000000110111101000101001010010001001000000000', $parser->bits);
        self::assertSame(1, $packet->version);
        self::assertSame(6, $packet->type);
        self::assertCount(2, $packet->packets);
        self::assertSame('1010', $packet->packets[0]->literal);
        self::assertSame('00010100', $packet->packets[1]->literal);
    }

    public function test_it_should_decode_operator_packet_with_length_type_1(): void
    {
        $parser = new BitsParser('EE00D40C823060');
        $packet = $parser->packets[0];

        self::assertSame('11101110000000001101010000001100100000100011000001100000', $parser->bits);
        self::assertSame(7, $packet->version);
        self::assertSame(3, $packet->type);
        self::assertCount(3, $packet->packets);
        self::assertSame('0001', $packet->packets[0]->literal);
        self::assertSame('0010', $packet->packets[1]->literal);
        self::assertSame('0011', $packet->packets[2]->literal);
    }

    public function test_more(): void
    {
        $parser = new BitsParser('8A004A801A8002F478');

        self::assertSame(4, $parser->packets[0]->version);
        self::assertSame(1, $parser->packets[0]->packets[0]->version);
        self::assertSame(5, $parser->packets[0]->packets[0]->packets[0]->version);
        self::assertSame(6, $parser->packets[0]->packets[0]->packets[0]->packets[0]->version);
    }

    public function test_version_sum(): void
    {
        $parser = new BitsParser('8A004A801A8002F478');
        self::assertSame(16, $parser->versionSum());
    }

    public function test_example2(): void
    {
        $parser = new BitsParser('620080001611562C8802118E34');
        self::assertSame(12, $parser->versionSum());
    }

    public function test_example3(): void
    {
        $parser = new BitsParser('C0015000016115A2E0802F182340');
        self::assertSame(23, $parser->versionSum());
    }

    public function test_example4(): void
    {
        $parser = new BitsParser('A0016C880162017C3686B18A3D4780');
        self::assertSame(31, $parser->versionSum());
    }
}
