<?php declare(strict_types=1);

require_once 'PacketContainer.php';
require_once 'LiteralPacket.php';
require_once 'OperatorPacket.php';

final class BitsParser extends PacketContainer
{
    // Only here for TDD
    public string $bits = '';

    public function __construct(string $input)
    {
        foreach (str_split(trim($input)) as $hex) {
            $this->bits .= str_pad(decbin(hexdec($hex)), 4, '0', STR_PAD_LEFT);
        }

        $this->parse($this->bits, $this);
    }

    private function parse(string $bits, PacketContainer $container): string
    {
        try {
            $version = bindec(substr($bits, 0, 3));
            $type = bindec(substr($bits, 3, 3));
            $bits = substr($bits, 6);

            if ($type === 4) {
                $literal = $this->getLiteral($bits);
                $container->packets[] = new LiteralPacket($version, $literal);
                return substr($bits, strlen($literal) * 5 / 4);
            }

            // operator type contains 2 packets
            $lengthTypeId = $bits[0];
            $bits = substr($bits, 1);

            $container->packets[] = $packet = new OperatorPacket($version, $type);

            if ($lengthTypeId === '0') {
                $bitLength = bindec(substr($bits, 0, 15));
                $subBits = substr($bits, 15, $bitLength);
                while ((int) $subBits) {
                    $subBits = $this->parse($subBits, $packet);
                }
                $subBits = substr($bits, 15 + $bitLength); // the part after the bitLength bits must be returned
            } else {
                $subPacketCount = bindec(substr($bits, 0, 11));
                $subBits = substr($bits, 11);
                for ($i = 0; $i < $subPacketCount; $i++) {
                    $subBits = $this->parse($subBits, $packet);
                }
            }

            return $subBits;
        } catch (\Throwable $e) {
            dd($this->packets, $container->packets, $bits, $e->getMessage());
        }
    }

    private function getLiteral(string $bits): string
    {
        $literal = '';
        foreach (str_split($bits, 5) as $part) {
            $literal .= substr($part, -4);
            if ($part[0] === '0') {
                break;
            }
        }

        return $literal;
    }

    public function versionSum(array $packets = null): int
    {
        $packets ??= $this->packets;
        $sum = 0;
        foreach ($packets as $packet) {
            $sum += $packet->version;
            if ($packet instanceof PacketContainer) {
                $sum += $this->versionSum($packet->packets);
            }
        }

        return $sum;
    }
}
