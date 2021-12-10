<?php declare(strict_types=1);

$fish = collect(explode(',', file_get_contents(__DIR__ . '/input.txt')))
    ->map(fn ($nr) => (int) $nr)
    ->countBy()
    ->all();

for ($i=0; $i<256; $i++) {
    $new = [];
    for ($f=1; $f<=8; $f++) {
        $new[$f-1] = $fish[$f] ?? 0;
    }
    $new[6] += $fish[0] ?? 0;
    $new[8] = $fish[0] ?? 0;

    $fish = $new;
}

dump($fish);

echo "\nTotal amount of fish: ".array_sum($fish)."\n";
