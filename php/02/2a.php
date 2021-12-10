<?php declare(strict_types=1);

$x = $y = 0;

foreach (file(__DIR__ . '/input.txt') as $line) {
    $value = (int) substr($line, strpos($line, ' ') + 1);
    if (str_starts_with($line, 'forward')) {
        $x += $value;
    } elseif (str_starts_with($line, 'down')) {
        $y += $value;
    } elseif (str_starts_with($line, 'up')) {
        $y -= $value;
    }
}

var_dump($x, $y, $x*$y);
