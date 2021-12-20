<?php declare(strict_types=1);

final class Enhancer
{
    public array $grid = [];
    public string $algo;

    public function __construct(array $lines)
    {
        $this->algo = str_replace(['#','.'], ['1','0'], trim(array_shift($lines)));

        array_shift($lines); // skip empty line

        foreach ($lines as $r => $line) {
            foreach (str_split($line) as $c => $value) {
                $this->grid[$r][$c] = $value === '#' ? 1 : 0;
            }
        }
    }

    public function enhance(int $steps = 1, bool $debug = false): void
    {
        // new grid
        $image = [];
        $margin = max(($steps * 2), 10);
        $start = $this->findStart() - $margin;
        $end = $this->findEnd() + $margin;

        for ($i=0; $i<$steps; $i++) {
            for ($r = $start; $r <= $end; $r++) {
                for ($c = $start; $c <= $end; $c++) {
                    $image[$r][$c] = $this->lookup($r, $c);
                }
            }

            // cut off the edges on the even intervals. This should keep it slightly cleaner
            if ($i % 2 === 1) {
                for ($j=0; $j<2; $j++) {
                    unset ($image[$start+$j], $image[$end-$j]);
                    foreach ($image as &$row) {
                        unset ($row[$start+$j], $row[$end-$j]);
                    }
                }
                unset ($image[$end-2]);
            }

            $this->grid = $image;

            if ($debug) echo $this->draw();
        }
    }

    private function findStart(): int
    {
        return min(array_keys($this->grid));
    }

    private function findEnd(): int
    {
        return max(array_keys($this->grid));
    }

    private function lookup(int $rc, int $cc): int
    {
        $bin = '';
        for ($r = $rc-1; $r<=$rc+1; $r++) {
            for ($c = $cc-1; $c<=$cc+1; $c++) {
                $bin .= $this->grid[$r][$c] ?? 0;
            }
        }

        return $this->pixelAt(bindec($bin));
    }

    public function pixelAt(int $pos): int
    {
        return (int) $this->algo[$pos];
    }

    public function draw(): string
    {
        $str = "\n";
        $start = $this->findStart();
        $end = $this->findEnd();
        for ($r = $start; $r <= $end; $r++) {
            for ($c = $start; $c <= $end; $c++) {
                $str .= ($this->grid[$r][$c] ?? 0) === 1 ? '#' : '.';
            }
            $str .= "\n";
        }

        return $str;
    }

    public function countLitPixels(): int
    {
        return collect($this->grid)->map(fn ($cols) => array_sum($cols))->sum();
    }
}
