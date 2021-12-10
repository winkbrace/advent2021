<?php declare(strict_types=1);

// Taken from my euler 12 solution :)
function triangle(int $x): int
{
    return $x * ($x + 1) / 2;
}

$crabs = collect(explode(',', file_get_contents(__DIR__ . '/input.txt')))
    ->map(fn ($nr) => (int) $nr);

// The naive approach is to just calculate the fuel cost for each horizontal position.
$max = $crabs->max();
$minFuel = 1e10; // something high
$minPosition = 0;
for ($i=0; $i<$max; $i++) {
    $fuel = $crabs->map(fn ($nr) => triangle(abs($nr - $i)))->sum();
    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $minPosition = $i;
    }
}

// As expected this is very close to the average crab position 476.
echo "\nThe minimum amount of fuel is: $minFuel at position $minPosition.\n";
