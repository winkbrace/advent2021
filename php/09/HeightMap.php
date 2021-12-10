<?php declare(strict_types=1);

final class HeightMap
{
    public array $grid = [];

    public function __construct(string $path)
    {
        foreach (file($path) as $r => $line) {
            $this->grid[$r] = array_map('intval', str_split(trim($line)));
        }
    }

    public function findBasins(): array
    {
        $basins = [];
        $group = 0;
        foreach ($this->grid as $r => $row) {
            foreach ($row as $c => $height) {
                if ($height === 9) {
                    $group++;
                    continue;
                }
                // if the north or west group nr is lower than the other, update all higher fields to be the lower.
                if (isset($basins[$r-1][$c], $basins[$r][$c-1]) && $basins[$r-1][$c] !== $basins[$r][$c-1]) {
                    $max = max($basins[$r - 1][$c], $basins[$r][$c - 1]);
                    $min = min($basins[$r - 1][$c], $basins[$r][$c - 1]);
                    $basins = $this->updateGroup($basins, $max, $min);
                    $basins[$r][$c] = $min;
                // copy the group nr of the north cell
                } elseif (($basins[$r-1][$c] ?? null) !== null) {
                    $basins[$r][$c] = $basins[$r-1][$c];
                // copy the group nr of the west cell
                } elseif (($basins[$r][$c-1] ?? null) !== null) {
                    $basins[$r][$c] = $basins[$r][$c-1];
                } else {
                    $basins[$r][$c] = $group;
                }
            }
        }

        return $basins;
    }

    private function updateGroup(array $basins, int $old, int $new): array
    {
        foreach ($basins as $r => $row) {
            foreach ($row as $c => $group) {
                if ($group === $old) {
                    $basins[$r][$c] = $new;
                }
            }
        }
        return $basins;
    }

    public function findLowPoints(): array
    {
        $found = [];
        foreach ($this->grid as $r => $row) {
            foreach ($row as $c => $height) {
                if ($this->isLowPoint($r, $c)) {
                    $found["$r,$c"] = $this->grid[$r][$c];
                }
            }
        }

        return $found;
    }

    public function isLowPoint(int $r, int $c): bool
    {
        foreach ($this->adjacent($r, $c) as $adjacent) {
            if ($adjacent <= $this->grid[$r][$c]) {
                return false;
            }
        }

        return true;
    }

    public function adjacent(int $r, int $c) {
        return array_filter([
            $this->grid[$r-1][$c] ?? null, // N
            $this->grid[$r][$c+1] ?? null, // E
            $this->grid[$r+1][$c] ?? null, // S
            $this->grid[$r][$c-1] ?? null, // W
        ], fn ($n) => $n !== null);
    }
}
