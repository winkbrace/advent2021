<?php declare(strict_types=1);

require_once 'Paper.php';

$paper = new Paper(file(__DIR__ . '/input.txt'));
$paper->fold(0);

$count = $paper->countDots();

echo "\nAfter the first fold we have $count dots left.\n";
