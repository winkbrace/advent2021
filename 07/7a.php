<?php declare(strict_types=1);

$crabs = collect(explode(',', file_get_contents(__DIR__ . '/input.txt')))
    ->map(fn ($nr) => (int) $nr);

// The average position is around 476

// The naive approach is to just calculate the fuel cost for each horizontal position.
$max = $crabs->max();
$minFuel = 1e10; // something high
$minPosition = 0;
for ($i=0; $i<$max; $i++) {
    $fuel = $crabs->map(fn ($nr) => abs($nr - $i))->sum();
    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $minPosition = $i;
    }
}

echo "\nThe minimum amount of fuel is: $minFuel at position $minPosition.\n";
