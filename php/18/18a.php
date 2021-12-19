<?php declare(strict_types=1);

require_once 'Pair.php';

$input = file(__DIR__ . '/input.txt');
$pair = Pair::fromString(trim(array_shift($input)));
foreach ($input as $line) {
    $pair->add(Pair::fromString(trim($line)));
}

echo "\nThe magnitude of the final sum is: {$pair->magnitude()}\n";
