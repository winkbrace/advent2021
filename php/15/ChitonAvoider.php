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
    /** @var array Cell[] Only contains cells with score != infinity and cells are removed from that array when they're explored. */
    private array $scored = [];
    // highest possible index (square, so row and column the same)
    private int $max;

    public function __construct(array $lines)
    {
        foreach ($lines as $r => $line) {
            foreach (str_split(trim($line)) as $c => $value) {
                $this->grid[$r][$c] = new Cell($r, $c, (int) $value);
            }
        }
        $this->max = count($this->grid) - 1; // It's square
    }

    public function findOptimalPath(): Cell
    {
        $cell = $this->grid[0][0];
        $cell->score = 0;

        $counter = 0;
        while ($cell->r < $this->max || $cell->c < $this->max) {
            $this->explore($cell);
            $cell = $this->cellWithLowestScore();
            if (++$counter % 10000 === 0) {
                echo "$counter cells explored. Now at ($cell->r,$cell->c): $cell->score.\n";
            }
        }

        return $cell;
    }

    private function explore(Cell $cell): void
    {
        // calculate the score from current cell to the next 2
        foreach ($this->getNext($cell) as $next) {
            if ($next->explored) continue;

            $score = $cell->score + $next->value;
            if ($score < $next->score) {
                $next->score = $score;
                $next->prev = $cell;
            }
            $this->scored["$next->r,$next->c"] = $next;
        }

        // This cell is done
        $cell->explored = true;
        unset($this->scored["$cell->r,$cell->c"]);
    }

    /** @return Cell[] */
    private function getNext(Cell $cell): array
    {
        $next = [];
        if ($cell->r + 1 <= $this->max) {
            $next[] = $this->grid[$cell->r + 1][$cell->c];
        }
        if ($cell->c + 1 <= $this->max) {
            $next[] = $this->grid[$cell->r][$cell->c + 1];
        }
        return $next;
    }

    private function cellWithLowestScore(): Cell
    {
        $lowest = $this->grid[$this->max][$this->max];
        foreach ($this->scored as $cell) {
            if ($cell->score < $lowest->score) {
                $lowest = $cell;
            }
        }

        return $lowest;
    }
}
