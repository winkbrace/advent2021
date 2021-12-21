<?php declare(strict_types=1);

require_once 'Dirac.php';

$input = 'Player 1 starting position: 3
Player 2 starting position: 7';

// Een beetje jammer dat ik mijn code niet echt kan hergebruiken.

// use arrays, because objects retain their value
$p1 = ['pos' => 3, 'score' => 0];
$p2 = ['pos' => 7, 'score' => 0];

$universes = [];

$wins = ['p1' => 0, 'p2' => 0];
function play_turn($p1, $p2)
{
    global $wins;

    // player 1
    $outcomes1 = [];
    foreach (range(1, 3) as $d1) {
        foreach (range(1, 3) as $d2) {
            foreach (range(1, 3) as $d3) {
                $outcomes1[] = $d1 + $d2 + $d3;
            }
        }
    }

    foreach ($outcomes1 as $i => $outcome) {
        $p1 = move_player($p1, $outcome);
        if ($p1['score'] >= 21) {
            $wins['p1']++;
            unset($outcomes1[$i]);
        }
    }

    foreach ($outcomes1 as $_) {

    }
                // player 2
                foreach (range(1, 3) as $d4) {
                    foreach (range(1, 3) as $d5) {
                        foreach (range(1, 3) as $d6) {
                            $p2 = move_player($p2, $d4 + $d5 + $d6);
                            if ($p2['score'] >= 21) {
                                $wins['p2']++;
                                continue;
                            }
                        }
                    }
                }



}

function move_player(array $player, int $steps): array
{
    $player['pos'] = ($player['pos'] + $steps) % 10;
    if ($player['pos'] === 0) {
        $player['pos'] = 10;
    }

    $player['score'] += $player['pos'];

    return $player;
}
