<?php declare(strict_types=1);

require_once 'Enhancer.php';

$enhancer = new Enhancer(file(__DIR__ . '/input.txt'));
$enhancer->enhance(50);
echo $enhancer->draw();

$count = $enhancer->countLitPixels();

// Less than 17924
echo "\nThere are $count lit pixels after 50 enhancements.\n";
