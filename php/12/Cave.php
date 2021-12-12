<?php declare(strict_types=1);

final class Cave
{
    public bool $isBig;
    public bool $isVisited = false;
    public array $connections;

    public function __construct(public string $id)
    {
        $this->isBig = $id === strtoupper($id);
    }

    public function connects(Cave $cave): void
    {
        // We can trust the input is clean, so no need to check if the connection exists
        $this->connections[] = $cave;
    }
}
