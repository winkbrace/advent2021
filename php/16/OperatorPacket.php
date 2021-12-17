<?php declare(strict_types=1);

require_once 'PacketContainer.php';

final class OperatorPacket extends PacketContainer
{
    public function __construct(
        public int $version,
        public int $type
    ) {}
}
