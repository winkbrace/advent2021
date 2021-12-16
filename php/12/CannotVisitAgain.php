<?php declare(strict_types=1);

require_once 'Cave.php';

final class CannotVisitAgain extends Exception
{
    public static function for(Cave $cave): self
    {
        return new self("Cave {$cave->id} can only be visited once.");
    }
}
