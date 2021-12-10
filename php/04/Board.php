<?php declare(strict_types=1);

require_once 'Cell.php';

final class Board
{
    public array $grid = [];

    public function __construct(array $lines)
    {
        foreach ($lines as $r => $line) {
            foreach (str_split($line, 3) as $c => $nr) {
                $this->grid[$r][$c] = new Cell($r, $c, (int) $nr);
            }
        }
    }

    public function mark(int $draw): void
    {
        foreach ($this->grid as $row) {
            foreach ($row as $cell) {
                if ($cell->nr === $draw) {
                    $cell->marked = true;
                }
            }
        }
    }

    public function hasBingo(): bool
    {
        foreach ($this->grid as $row) {
            if ($this->lineHasBingo($row)) {
                return true;
            }
        }
        foreach ($this->cols() as $col) {
            if ($this->lineHasBingo($col)) {
                return true;
            }
        }

        return false;
    }

    public function score(): int
    {
        $score = 0;
        foreach ($this->grid as $row) {
            foreach ($row as $cell) {
                if ( ! $cell->marked) {
                    $score += $cell->nr;
                }
            }
        }

        return $score;
    }

    /** @param Cell[] $line */
    private function lineHasBingo(array $line): bool
    {
        foreach ($line as $cell) {
            if ( ! $cell->marked) {
                return false;
            }
        }

        return true;
    }

    private function cols(): array
    {
        $cols = [];
        foreach ($this->grid as $r => $row) {
            foreach ($row as $c => $cell) {
                $cols[$c][$r] = $cell;
            }
        }

        return $cols;
    }
}
