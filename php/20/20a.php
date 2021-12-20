<?php declare(strict_types=1);

require_once 'Enhancer.php';

$enhancer = new Enhancer(file(__DIR__ . '/input.txt'));
$enhancer->enhance(2);

$count = $enhancer->countLitPixels();

echo "\nThere are $count lit pixels after 2 enhancements.\n";
