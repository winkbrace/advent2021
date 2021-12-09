<?php declare(strict_types=1);

use Advent\Bingo\Board;

$input = array_filter(file(__DIR__ . '/input.txt'), fn ($line) => trim($line) !== '');
$draws = explode(',', trim(array_shift($input)));
$boards = array_map(
    fn ($lines) => new Board($lines),
    array_chunk($input, 5)
);

foreach ($draws as $draw) {
    foreach ($boards as $board) {
        $board->mark((int) $draw);
        if ($board->hasBingo()) {
            break 2;
        }
    }
}

var_dump($draw, $board->score(), $draw * $board->score());
