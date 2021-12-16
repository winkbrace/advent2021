<?php declare(strict_types=1);

require_once 'Paper.php';

$paper = new Paper(file(__DIR__ . '/input.txt'));
$paper->fold();
$paper->draw();
