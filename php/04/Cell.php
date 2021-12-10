<?php declare(strict_types=1);

final class Cell
{
    public function __construct(public int $r, public int $c, public int $nr, public bool $marked = false)
    {}
}
