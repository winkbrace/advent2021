<?php declare(strict_types=1);

final class Paper
{
    public array $grid = [];
    public array $folds = [];
    private array $size = ['x' => 0, 'y' => 0];

    public function __construct(array $lines)
    {
        $folds = false;
        $dots = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                $folds = true;
                continue;
            }
            if ($folds) {
                preg_match('/fold along ([x|y])=(\d+)/', $line, $matches);
                $this->folds[] = [$matches[1], (int) $matches[2]];
            } else {
                [$x, $y] = explode(',', $line);
                $dots[$x][$y] = 1;
                $this->size['x'] = max($this->size['x'], $x);
                $this->size['y'] = max($this->size['y'], $y);
            }
        }

        for ($x=0; $x<=$this->size['x']; $x++) {
            for ($y=0; $y<=$this->size['y']; $y++) {
                $this->grid[$x][$y] = $dots[$x][$y] ?? 0;
            }
        }
    }

    public function fold(?int $stopAt = null): array
    {
        foreach ($this->folds as $i => $fold) {
            [$dimension, $value] = $fold;
            if ($dimension === 'x') {
                $this->foldOverX($value);
            } else {
                $this->foldOverY($value);
            }

            if ($stopAt === $i) {
                break;
            }
        }

        return $this->grid;
    }

    private function foldOverX(int $value): void
    {
        // copy dots
        for ($x = $value + 1; $x <= $this->size['x']; $x++) {
            $xt = $value - ($x - $value);
            foreach ($this->grid[$x] as $y => $dot) {
                $this->grid[$xt][$y] = max($this->grid[$xt][$y], $dot);
            }
            unset($this->grid[$x]);
        }
        // remove fold line
        unset($this->grid[$value]);
        // adjust grid size
        $this->size['x'] = $value - 1;
    }

    private function foldOverY(int $value): void
    {
        // copy dots
        for ($y = $value + 1; $y <= $this->size['y']; $y++) {
            $yt = $value - ($y - $value);
            foreach ($this->grid as &$row) {
                $row[$yt] = max($row[$yt], $row[$y]);
                unset($row[$y]);
            }
        }
        // remove fold line
        foreach ($this->grid as &$row) {
            unset($row[$value]);
        }
        // adjust grid size
        $this->size['y'] = $value - 1;
    }

    public function countDots(): int
    {
        $sum = 0;
        foreach ($this->grid as $row) {
            $sum += array_sum($row);
        }

        return $sum;
    }

    public function draw(): void
    {
        for ($y=0; $y<=$this->size['y']; $y++) {
            for ($x=0; $x<=$this->size['x']; $x++) {
                echo $this->grid[$x][$y] ? '#' : '.';
            }
            echo PHP_EOL;
        }
    }
}
