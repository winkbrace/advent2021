<?php declare(strict_types=1);

require_once 'PathFinder.php';

final class DoubleVisitPathFinder extends PathFinder
{
    protected function guardCanVisitCave(array $path, Cave $cave): void
    {
        if ($cave->id === 'start' && count($path) > 0) {
            throw CannotVisitAgain::for($cave);
        }
        if ($cave->isSmall && $this->caveIsVisited($path, $cave) && $this->alreadyDoubleVisited($path)) {
            throw CannotVisitAgain::for($cave);
        }
    }

    private function caveIsVisited(array $path, Cave $cave): bool
    {
        return collect($path)->contains(fn(Cave $c) => $c->id === $cave->id);
    }

    private function alreadyDoubleVisited(array $path): bool
    {
        return collect($path)
            ->filter(fn($cave) => $cave->isSmall)
            ->countBy(fn($cave) => $cave->id)
            ->contains(2);
    }
}
