<?php /** @noinspection SpellCheckingInspection */
declare(strict_types=1);

$digits = [
    0 => 'ABCEFG',  // 6   ABC EFG  <- de enige zonder d na de unieke lengtes
    1 => 'CF',      // 2     C  F   <- unieke lengte
    2 => 'ACDEG',   // 5   A CDE G  <- de enige zonder f
    3 => 'ACDFG',   // 5   A CD FG
    4 => 'BCDF',    // 4    BCD F   <- unieke lengte
    5 => 'ABDFG',   // 5   AB D FG  <- de 5 length waar geen c in zit
    6 => 'ABDEFG',  // 6   AB DEFG  <- de 6 length waar geen c in zit
    7 => 'ACF',     // 3   A C  F   <- unieke lengte
    8 => 'ABCDEFG', // 7   ABCDEFG  <- unieke lengte
    9 => 'ABCDFG',  // 6   ABCD FG  <- op het eind, bevat alle delen die ook in 4 zitten
];

function sort_chars(string $s): string
{
    $a = str_split($s);
    sort($a);
    return implode($a);
}

function str_contains_all(string $haystack, string $needles): bool
{
    foreach (str_split($needles) as $needle) {
        if ( ! str_contains($haystack, $needle)) {
            return false;
        }
    }
    return true;
}

$sum = 0;
foreach (file(__DIR__ . '/input.txt') as $line) {
    [$numbers, $output] = explode(' | ', trim($line));

    // Start is easy: find the numbers with unique length
    $numbers = collect(explode(' ', $numbers))
        ->map(fn ($s) => sort_chars($s))
        ->mapWithKeys(function ($s) {
            return match (strlen($s)) {
                2 => [1 => $s],
                4 => [4 => $s],
                3 => [7 => $s],
                7 => [8 => $s],
                default => [$s => $s]
            };
        });

    // Then we look for the numbers that are missing letters of the 1
    foreach (str_split($numbers[1]) as $letter) {
        $without = $numbers->filter(fn ($s) => ! str_contains($s, $letter));
        if ($without->count() === 1) {
            $numbers[2] = $without->first();
        } elseif ($without->count() === 2) {
            $numbers[5] = $without->filter(fn ($s) => strlen($s) === 5)->first();
            $numbers[6] = $without->filter(fn ($s) => strlen($s) === 6)->first();
        }
    }
    unset($numbers[$numbers[2]], $numbers[$numbers[5]], $numbers[$numbers[6]]);

    // Determine the last 3
    $numbers = $numbers->mapWithKeys(function($s, $i) use ($numbers) {
        if (is_int($i)) return [$i => $s];
        if (strlen($s) === 5) return [3 => $s];
        if (str_contains_all($s, $numbers[4])) return [9 => $s];
        return [0 => $s];
    })->flip();

    // Now fill in the output signal numbers and add the result to the total
    $sum += (int) collect(explode(' ', $output))
        ->map(fn ($s) => sort_chars($s))
        ->map(fn ($s) => $numbers[$s])
        ->implode('');
}

echo "\nThe sum of the outputs is: $sum \n";
