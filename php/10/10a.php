<?php declare(strict_types=1);

require_once 'Parser.php';
$parser = new Parser();

$corrupt = [];
foreach (file(__DIR__ . '/input.txt') as $line) {
    try {
        $parser->parse(trim($line));
    } catch (CorruptedLine $e) {
        $corrupt[] = $e->found;
    }
}

// dump($corrupt);

$scores = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$total = array_sum(array_map(fn ($c) => $scores[$c], $corrupt));

echo "\nThe total syntax error score is: $total\n";
