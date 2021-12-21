<?php declare(strict_types=1);

require_once 'DeterministicDice.php';
require_once 'Dirac.php';
require_once 'DiracPlayer.php';

$input = 'Player 1 starting position: 3
Player 2 starting position: 7';

$dice = new DeterministicDice();
$dirac = new Dirac($dice, 1000);

$p1 = new DiracPlayer(3);
$p2 = new DiracPlayer(7);

$dirac->play($p1, $p2);

dump($p1->score, $p2->score, $dice->rollCount());

$result = min($p1->score, $p2->score) * $dice->rollCount();

echo "\nThe outcome is: $result.\n";
