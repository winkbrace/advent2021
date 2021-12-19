<?php declare(strict_types=1);

require_once 'Pair.php';

$mags = [];
$input = file(__DIR__ . '/input.txt');
foreach ($input as $line1) {
    foreach ($input as $line2) {
        $mags[] = Pair::fromString(trim($line1))
                   ->add(Pair::fromString(trim($line2)))
                   ->magnitude();
    }
}

$max = max($mags);

echo "\nThe max magnitude of the sum of 2 inputs is: $max\n";
