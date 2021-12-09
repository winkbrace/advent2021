<?php declare(strict_types=1);

$digits = [
    0 => 'abcefg',  // 6 length
    1 => 'cf',      // 2
    2 => 'acdeg',   // 5
    3 => 'acdfg',   // 5
    4 => 'bcdf',    // 4
    5 => 'abdfg',   // 5
    6 => 'abdefg',  // 6
    7 => 'acf',     // 3
    8 => 'abcdefg', // 7
    9 => 'abcdfg',  // 6
];

$total = 0;
foreach (file(__DIR__ . '/input.txt') as $line) {
    [$numbers, $output] = explode(' | ', trim($line));
    $total += collect(explode(' ', $output))
        ->filter(fn ($n) => in_array(strlen($n), [2, 3, 4, 7]))
        ->count();
}

echo "\nThe 1,4,7 or 8 appeared $total times.\n";
