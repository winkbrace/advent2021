<?php declare(strict_types=1);

require_once 'Cave.php';
require_once 'CannotVisitAgain.php';

abstract class PathFinder
{
    /** @var array Cave[] */
    public array $caves;
    /** @var array Path[] */
    public array $paths = [];

    public function __construct(array $lines)
    {
        foreach ($lines as $line) {
            $this->addCaves(explode('-', trim($line)));
        }
    }

    private function addCaves(array $caves): void
    {
        foreach ($caves as $cave) {
            if (empty($this->caves[$cave])) {
                $this->caves[$cave] = new Cave($cave);
            }
        }

        $this->caves[$caves[0]]->connects($this->caves[$caves[1]]);
        $this->caves[$caves[1]]->connects($this->caves[$caves[0]]);
    }

    public function findPaths() : array
    {
        $this->visitCaves($this->caves['start']);

        return $this->paths;
    }

    private function visitCaves(Cave $cave, array $path = []): void
    {
        try {
            $path = $this->addCave($path, $cave);
            //echo $this->pathToString($path);
            if ($cave->id === 'end') {
                $this->paths[] = $path;
            } else {
                foreach ($cave->connections as $next) {
                    $this->visitCaves($next, $path);
                }
            }
        } catch (CannotVisitAgain $e) {
            //echo $e->getMessage() . PHP_EOL;
        }
    }

    private function addCave(array $path, Cave $cave): array
    {
        $this->guardCanVisitCave($path, $cave);

        $path[] = $cave;

        return $path;
    }

    public function pathToString(array $path): string
    {
        return collect($path)->pluck('id')->implode(',') . PHP_EOL;
    }

    public function pathsToString(): string
    {
        return collect($this->paths)->map(fn ($path) => $this->pathToString($path))->implode(PHP_EOL);
    }

    abstract protected function guardCanVisitCave(array $path, Cave $cave): void;
}
