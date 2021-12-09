<?php declare(strict_types=1);

$sum = str_split(str_repeat('0', 12));

$input = file(__DIR__ . '/input.txt');
foreach ($input as $line) {
    foreach (str_split($line) as $i => $bit) {
        $sum[$i] += (int) $bit;
    }
}
unset($sum[12]);

$gamma = $epsilon = '';

foreach ($sum as $nr) {
    if ($nr > count($input) / 2) {
        $gamma .= '1';
        $epsilon .= '0';
    } else {
        $gamma .= '0';
        $epsilon .= '1';
    }
}

var_dump($gamma, $epsilon, bindec($gamma), bindec($epsilon), bindec($gamma) * bindec($epsilon));
