<?php declare(strict_types=1);

require_once 'Polymer.php';

$polymer = new Polymer(file(__DIR__ . '/input.txt'));
$polymer->insert(10);

$count = $polymer->count();
$count->sort()->dump();
$score = $count->max() - $count->min();

echo "\nThe score of most occurring minus least occurring element is: $score.\n";
