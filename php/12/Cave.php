<?php declare(strict_types=1);

final class Cave
{
    public bool $isSmall;
    public array $connections;

    public function __construct(public string $id)
    {
        $this->isSmall = $id === strtolower($id);
    }

    public function connects(Cave $cave): void
    {
        // We can trust the input is clean, so no need to check if the connection exists
        $this->connections[] = $cave;
    }
}
