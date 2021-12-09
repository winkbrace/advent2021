<?php declare(strict_types=1);

use Advent\Bingo\Board;

$input = array_filter(file(__DIR__ . '/input.txt'), fn ($line) => trim($line) !== '');
$draws = explode(',', trim(array_shift($input)));
$boards = array_map(
    fn ($lines) => new Board($lines),
    array_chunk($input, 5)
);

foreach ($draws as $draw) {
    foreach ($boards as $i => $board) {
        $board->mark((int) $draw);
        if ($board->hasBingo()) {
            unset($boards[$i]);
        }
    }
    if (count($boards) === 0) {
        break; // we have to break immediately to keep the correct $draw
    }
    echo $draw . ': ' . count($boards) . PHP_EOL;
}

var_dump($draw, $board->score(), $draw * $board->score());
