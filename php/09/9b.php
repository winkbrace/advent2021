<?php declare(strict_types=1);

require_once __DIR__ . '/HeightMap.php';

$map = new HeightMap(__DIR__ . '/input.txt');

// draw
//$basins = $map->findBasins();
//for ($r=0; $r<100; $r++) {
//    for ($c=0; $c<80; $c++) {
//        echo str_pad((string) ($basins[$r][$c] ?? ' '), 4);
//    }
//    echo "\n";
//}

// count
$basins = $map->findBasins();
$counts = [];
for ($r=0; $r<100; $r++) {
    for ($c=0; $c<80; $c++) {
        if (isset($basins[$r][$c])) {
            $counts[$basins[$r][$c]] = ($counts[$basins[$r][$c]] ?? 0) + 1;
        }
    }
}
arsort($counts);

$product = array_product(array_slice($counts, 0, 3));

echo "\nThe product of the sizes of the 3 largest basins is: $product\n";
