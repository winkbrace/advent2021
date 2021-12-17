<?php declare(strict_types=1);

require_once 'ChitonAvoider.php';

$tmp = [];
foreach (file(__DIR__ . '/input.txt') as $line) {
    $newLine = trim($line);
    for ($i=1; $i<5; $i++) {
        $newLine .= implode('', array_map(
            fn ($n) => $n + $i > 9 ? $n + $i - 9 : $n + $i,
            str_split(trim($line))
        ));
    }
    $tmp[] = $newLine;
}

$input = $tmp;
for ($i=1; $i<5; $i++) {
    foreach ($tmp as $line) {
        $input[] = implode('', array_map(
            fn ($n) => $n + $i > 9 ? $n + $i - 9 : $n + $i,
            str_split($line)
        ));
    }
}

$pathFinder = new ChitonAvoider($input);
$end = $pathFinder->findOptimalPath();

// Less than 2837
// Very frustrating. 15a and the example has the correct result. The $input is correct.
echo "\nThe total risk of the optimal path is: $end->score.\n";
