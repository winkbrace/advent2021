<?php declare(strict_types=1);

// Example: (18 boven 9) => 18! / (9! * 9!) = 48.620 paths
// Input: (198 boven 99) => 198! / (99! * 99!) = 2,275e58 paths.... Let's not walk all paths.
// The 10x10 was pretty fast, let's search per 10x10. Or per 11 steps (11*18=198)
// Okay, even searching per 22 steps doesn't provide the correct answer and is too slow. Time to research Dijkstra.
// https://www.youtube.com/watch?v=EFg3u_E6eHU

require_once 'ChitonAvoider.php';

$pathFinder = new ChitonAvoider(file(__DIR__ . '/input.txt'));
$path = $pathFinder->findOptimalPath();
dump($path);
$score = $pathFinder->score($path);

// Less than 371
echo "\nThe total risk of the optimal path is: $score.\n";
