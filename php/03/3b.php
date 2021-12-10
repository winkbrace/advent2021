<?php declare(strict_types=1);

function common_bit(array $input, int $i): string
{
    $sum = 0;
    foreach ($input as $line) {
        $sum += (int) $line[$i];
    }

    return $sum >= count($input) / 2 ? '1' : '0';
}

function filter_bits(array $input, int $i, string $bit): array
{
    return array_filter($input, fn ($line) => $line[$i] === $bit);
}

$input = file(__DIR__ . '/input.txt');
for ($i=0; $i<12; $i++) {
    $bit = common_bit($input, $i);
    $input = filter_bits($input, $i, $bit);
}

$oxygen = reset($input);

$input = file(__DIR__ . '/input.txt');
for ($i=0; $i<12; $i++) {
    $bit = common_bit($input, $i) === '1' ? '0' : '1';
    $input = filter_bits($input, $i, $bit);
    if (count($input) === 1) {
        break;
    }
}

$scrubber = reset($input);

var_dump($oxygen, $scrubber, bindec($oxygen), bindec($scrubber), bindec($oxygen)*bindec($scrubber));
