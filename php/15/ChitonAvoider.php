<?php declare(strict_types=1);

require_once 'ChitonCell.php';

use ChitonCell as Cell;

/**
 * Cutting the task in smaller pieces of about 15 steps per calculation didn't result in the optimal path.
 * Now we have to implement Dijkstra's algorithm.
 */
final class ChitonAvoider
{
    public array $grid = [];
    private int $size;
    private int $minScore = 999999;
    private array $optimal = [];

    public function __construct(array $lines)
    {
        foreach ($lines as $r => $line) {
            foreach (str_split(trim($line)) as $c => $value) {
                $this->grid[$r][$c] = new Cell($r, $c, (int) $value);
            }
        }
        $this->size = count($this->grid); // it's square
    }

    public function findOptimalPath() : array
    {
        $path = [];
        $start = $this->grid[0][0];

        while ($start->r < $this->size - 1 || $start->c < $this->size - 1) {
            $this->optimal = [];
            $this->minScore = 999999;

            $this->walk($start);

            for ($i=1; $i<count($this->optimal); $i++) {
                $path[] = $this->optimal[$i];
            }
            $start = end($path);
        }

        return $path;
    }

    private function walk(Cell $cell, array $path = []): void
    {
        $path[] = $cell;

        // let's optimize every 15 steps (or when done)
        if (count($path) === 22
            || ($cell->r === $this->size - 1 && $cell->c === $this->size - 1)
        ) {
            $score = $this->score($path);
            if ($score < $this->minScore) {
                $this->optimal = $path;
                $this->minScore = $score;
            }
        } else {
            foreach ($this->getNext($cell) as $next) {
                $this->walk($next, $path);
            }
        }
    }

    private function getNext(Cell $cell): array
    {
        $next = [];
        if ($cell->r + 1 < $this->size) {
            $next[] = $this->grid[$cell->r + 1][$cell->c];
        }
        if ($cell->c + 1 < $this->size) {
            $next[] = $this->grid[$cell->r][$cell->c + 1];
        }
        return $next;
    }

    public function score(array $path) : mixed
    {
        array_shift($path); // remove start for score

        return collect($path)->pluck('value')->sum();
    }
}
