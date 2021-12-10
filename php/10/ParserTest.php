<?php declare(strict_types=1);

require_once 'Parser.php';

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new Parser();
    }

    public function test_it_should_find_corrupted_pair(): void
    {
        $this->expectException(CorruptedLine::class);
        $this->expectExceptionMessage("(] - Expected ), but found ] instead.");

        $this->parser->parse('(]');
    }

    public function test_it_should_find_corrupted_line_with_children(): void
    {
        $this->expectException(CorruptedLine::class);
        $this->expectExceptionMessage("{()()()> - Expected }, but found > instead.");

        $this->parser->parse('{()()()>');
    }

    public function test_it_should_find_corrupted_line_with_nested(): void
    {
        $this->expectException(CorruptedLine::class);
        $this->expectExceptionMessage("(((()))} - Expected ), but found } instead.");

        $this->parser->parse('(((()))}');
    }

    public function test_it_should_find_corrupted_line_with_mix(): void
    {
        $this->expectException(CorruptedLine::class);
        $this->expectExceptionMessage("<([]){()}[{}]) - Expected >, but found ) instead.");

        $this->parser->parse('<([]){()}[{}])');
    }

    public function test_it_should_finish_incomplete_lines(): void
    {
        self::assertSame('}}]])})]', $this->parser->parse('[({(<(())[]>[[{[]{<()<>>'));
        self::assertSame(')}>]})', $this->parser->parse('[(()[<>])]({[<{<<[]>>('));
        self::assertSame('}}>}>))))', $this->parser->parse('(((({<>}<{<{<>}{[]{[]{}'));
    }
}
