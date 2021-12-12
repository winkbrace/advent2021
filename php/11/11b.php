<?php declare(strict_types=1);

require_once 'Grid.php';
$grid = new Grid(file(__DIR__ . '/input.txt'));

for ($i=1; $i<1000; $i++) {
    $grid->run();
    if ($grid->allFlashed()) {
        break;
    }
}

echo "\nAfter $i runs all octopuses flash.\n";
