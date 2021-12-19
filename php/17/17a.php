<?php declare(strict_types=1);

require_once 'ProbePositioner.php';

function triangle(int $x): int
{
    return $x * ($x + 1) / 2;
}

$input = 'target area: x=192..251, y=-89..-59';
$area = new Area(192,251,-89,-59);

// De y gaat altijd even snel omlaag als omhoog. Dus hij zal altijd weer op de 0 lijn komen bij het dalen.
// Dus we moeten vanaf die 0 nog net de onderkant van de area raken in de volgende stap.
// Dat is een stap van 89, dus de vy = 88.
$vy = abs($area->minY) - 1;

// vx is ook makkelijk. Teruglopend zijn de stappen +1+2+3...+n, dus de driehoeksformule weer.
$vx = 0;
while (triangle($vx) < $area->minX) {
    $vx++;
}

$positioner = new ProbePositioner($vx, $vy);
if ($positioner->hitsTargetArea($area)) {
    echo "\nJep, hij raakt 'em!\n";
} else {
    echo "\nOh-oh, denkfout!\n";
}

echo "Het hoogste punt is: " . triangle($vy) . "\n";
