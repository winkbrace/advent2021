<?php declare(strict_types=1);

require_once 'Cave.php';

final class PathFinder
{
    public array $caves;

    public function __construct(array $lines)
    {
        foreach ($lines as $line) {
            $this->addCaves(explode('-', trim($line)));
        }
    }

    public function findPaths() : array
    {
        $paths = [];
        $path = [0 => $this->caves['start']];
        foreach ($this->caves['start']->connections as $cave) {

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
}
