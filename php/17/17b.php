<?php declare(strict_types=1);

require_once 'ProbePositioner.php';

function triangle(int $x): int
{
    return $x * ($x + 1) / 2;
}

$input = 'target area: x=192..251, y=-89..-59';
$area = new Area(192,251,-89,-59);

// I know the min and max vx and vy, so I only have to check the velocities between those values.
$maxVy = abs($area->minY) - 1;

$found = [];
for ($vx=0; $vx<= $area->maxX; $vx++) {
    for ($vy= $area->minY; $vy<=$maxVy; $vy++) {
        $positioner = new ProbePositioner($vx, $vy);
        if ($positioner->hitsTargetArea($area)) {
            $found[] = compact('vx', 'vy');
        }
    }
}

$count = count($found);

echo "\nFound $count firing velocities that will hit the target area.\n";
