<?php declare(strict_types=1);

$input = file(__DIR__ . '/input.txt');
$count = count($input);

$changes = [
    'increased' => 0,
    'decreased' => 0,
];

for ($i = 1; $i<$count-2; $i++) {
    $prev = $input[$i-1] + $input[$i] + $input[$i+1];
    $curr = $input[$i] + $input[$i+1] + $input[$i+2];
    if ($curr > $prev) {
        $changes['increased']++;
    } else {
        $changes['decreased']++;
    }
}

var_dump($changes);
