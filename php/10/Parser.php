<?php declare(strict_types=1);

require_once 'CorruptedLine.php';

final class Parser
{
    private const PAIRS = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];

    /** @throws CorruptedLine */
    public function parse(string $line): string
    {
        $this->guardNotCorrupted($line);

        return $this->closeLine($line);
    }

    private function guardNotCorrupted(string $line): void
    {
        $opens = [];
        foreach (str_split($line) as $char) {
            if ($this->isOpen($char)) {
                $opens[] = $char;
            } else {
                $open = array_pop($opens);
                if ( ! $this->matches($open, $char)) {
                    throw CorruptedLine::for($line, self::PAIRS[$open], $char);
                }
            }
        }
    }

    private function closeLine(string $line): string
    {
        $opens = [];
        foreach (str_split($line) as $char) {
            if ($this->isOpen($char)) {
                $opens[] = $char;
            } else {
                array_pop($opens);
            }
        }

        return implode('', array_map(fn ($c) => self::PAIRS[$c], array_reverse($opens)));
    }

    private function isOpen(string $char): bool
    {
        return array_key_exists($char, self::PAIRS);
    }

    private function matches(string $open, string $char): bool
    {
        return self::PAIRS[$open] === $char;
    }
}
