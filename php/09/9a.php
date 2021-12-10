<?php declare(strict_types=1);

require_once __DIR__ . '/HeightMap.php';

$map = new HeightMap(__DIR__ . '/input.txt');
$points = $map->findLowPoints();
$riskLevelSum = array_sum(array_map(fn ($x) => $x+1, $points));

echo "\nThe sum of the risk levels of all low points on the map is: $riskLevelSum\n";
