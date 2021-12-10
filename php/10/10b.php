<?php declare(strict_types=1);

require_once 'Parser.php';
$parser = new Parser();

$completions = [];
foreach (file(__DIR__ . '/input.txt') as $line) {
    try {
        $completions[] = $parser->parse(trim($line));
    } catch (CorruptedLine $e) {
        // ignore
    }
}

$points = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
$scores = [];
foreach ($completions as $i => $completion) {
    $scores[$i] = 0;
    foreach (str_split($completion) as $c) {
        $scores[$i] *= 5;
        $scores[$i] += $points[$c];
    }
}

sort($scores);
$middle = $scores[(count($scores) - 1) / 2];
// dump($scores, $middle);

echo "\nThe middle score is: $middle \n";
