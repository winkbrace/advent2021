<?php declare(strict_types=1);

final class CorruptedLine extends \Exception
{
    public string $found;

    public function __construct($message = "", string $found, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->found = $found;
    }

    public static function for(string $line, string $expected, string $found): self
    {
        return new self("$line - Expected $expected, but found $found instead.", $found);
    }
}
