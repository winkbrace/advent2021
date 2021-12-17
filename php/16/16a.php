<?php declare(strict_types=1);

require_once 'BitsParser.php';

$parser = new BitsParser(file_get_contents(__DIR__ . '/input.txt'));
dump($parser->packets);
$sum = $parser->versionSum();

// More than 835
echo "\nThe sum of all the package versions is: $sum.\n";
