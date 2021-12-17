<?php declare(strict_types=1);

final class LiteralPacket
{
    public function __construct(
        public int $version,
        public string $literal,
    ) {}
}
