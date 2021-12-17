<?php declare(strict_types=1);

final class ChitonCell
{
    public function __construct(
        public int $r,
        public int $c,
        public int $value,
        public int $score = 99999,
        public ?self $prev = null,
        public bool $explored = false
    ) {}
}
