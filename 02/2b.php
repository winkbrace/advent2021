<?php declare(strict_types=1);

$x = $depth = $aim = 0;

foreach (file(__DIR__ . '/input.txt') as $line) {
    [$direction, $value] = explode(' ', $line);
    $value = (int) $value;

    switch ($direction) {
        case 'up': $aim -= $value; break;
        case 'down': $aim += $value; break;
        case 'forward':
            $x += $value;
            $depth += $value * $aim;
    }
}

var_dump($x, $depth, $x*$depth);
