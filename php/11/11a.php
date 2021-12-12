<?php declare(strict_types=1);

require_once 'Grid.php';
$grid = new Grid(file(__DIR__ . '/input.txt'));

for ($i=0; $i<100; $i++) {
    $grid->run();
}

echo "\nAfter 100 runs there were $grid->flashCount flashes.\n";
