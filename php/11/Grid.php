<?php declare(strict_types=1);

require_once 'Octopus.php';

final class Grid implements Stringable
{
    public array $grid;
    public int $flashCount = 0;

    public function __construct(array $grid)
    {
        foreach ($grid as $r => $line) {
            $levels = array_map('intval', str_split(trim($line)));
            foreach ($levels as $c => $level) {
                $this->grid[$r][$c] = new Octopus($r, $c, $level);
            }
        }
    }

    public function run() : void
    {
        $this->increment();

        foreach ($this->grid as $r => $row) {
            foreach ($row as $c => $octopus) {
                $this->flash($r, $c);
            }
        }
    }

    public function allFlashed() : bool
    {
        foreach ($this->grid as $row) {
            foreach ($row as $octopus) {
                if ( ! $octopus->hasFlashed) {
                    return false;
                }
            }
        }

        return true;
    }

    private function increment(): void
    {
        foreach ($this->grid as $row) {
            foreach ($row as $octopus) {
                $octopus->reset();
                $octopus->increment();
            }
        }
    }

    private function flash(int $r, int $c): void
    {
        /** @var Octopus $octopus */
        $octopus = $this->grid[$r][$c];
        if ($octopus->level > 9) {
            $octopus->flash();
            $this->flashCount++;
            $this->flashAdjacent($r, $c);
        }
    }

    public function __toString() : string
    {
        $str = '';
        foreach ($this->grid as $row) {
            foreach ($row as $octopus) {
                $str .= $octopus->level;
            }
            $str .= PHP_EOL;
        }

        return $str;
    }

    private function flashAdjacent(int $r, int $c): void
    {
        foreach ($this->adjacent($r, $c) as $octopus) {
            $octopus->increment();
            if ($octopus->level > 9) {
                $this->flash($octopus->r, $octopus->c);
            }
        }
    }

    public function adjacent(int $row, int $col): array
    {
        $adjacent = [];
        for ($r = $row-1; $r<=$row+1; $r++) {
            for ($c = $col-1; $c<=$col+1; $c++) {
                if ($r >= 0 && $r <= 9
                    && $c >= 0 && $c <= 9
                    && ! ($r === $row && $c === $col)
                ) {
                    $adjacent[] = $this->grid[$r][$c];
                }
            }
        }

        return $adjacent;
    }
}
