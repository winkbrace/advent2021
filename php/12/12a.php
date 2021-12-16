<?php declare(strict_types=1);

require_once 'SingleVisitPathFinder.php';
$pathFinder = new SingleVisitPathFinder(file(__DIR__ . '/input.txt'));
$pathFinder->findPaths();

$count = count($pathFinder->paths);

echo "\nThere are $count paths.\n";
