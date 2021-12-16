<?php declare(strict_types=1);

require_once 'DoubleVisitPathFinder.php';
$pathFinder = new DoubleVisitPathFinder(file(__DIR__ . '/input.txt'));
$pathFinder->findPaths();

$count = count($pathFinder->paths);

echo "\nThere are $count paths.\n";
