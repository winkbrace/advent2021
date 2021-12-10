<?php declare(strict_types=1);

$points = [];
foreach (file(__DIR__ . '/input.txt') as $line) {
    [$start, $end] = explode(' -> ', $line);
    [$x1, $y1] = explode(',', $start);
    [$x2, $y2] = explode(',', $end);
    $x1 = (int) $x1;
    $x2 = (int) $x2;
    $y1 = (int) $y1;
    $y2 = (int) $y2; // also gets rid of trailing newline

    if ($x1 === $x2) {
        echo "Adding range [$x1 : $y1 -> $y2]\n";
        foreach (range($y1, $y2) as $y) {
            $points[$x1][$y] = ($points[$x1][$y] ?? 0) + 1;
        }
    } elseif ($y1 === $y2) {
        echo "Adding range [$x1 -> $x2 : $y1]\n";
        foreach (range($x1, $x2) as $x) {
            $points[$x][$y1] = ($points[$x][$y1] ?? 0) + 1;
        }
    }
}

$total = 0;
foreach ($points as $x => $row) {
    foreach ($row as $y => $count) {
        if ($count >= 2) {
            $total++;
        }
    }
}

echo "\nTotal amount of overlaps: $total\n";
