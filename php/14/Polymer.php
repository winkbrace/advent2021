<?php declare(strict_types=1);

use Illuminate\Support\Collection;

final class Polymer
{
    public string $template;
    public Collection $rules;
    public array $pairs = [];

    public function __construct(array $input)
    {
        $this->template = trim(array_shift($input));

        $length = strlen($this->template) - 1;
        for ($i=0; $i<$length; $i++) {
            $key = substr($this->template, $i, 2);
            $this->pairs[$key] = ($this->pairs[$key] ?? 0) + 1;
        }

        array_shift($input); // remove empty line

        $this->rules = collect($input)
            ->mapWithKeys(function ($line) {
                [$pair, $element] = explode(' -> ', trim($line));
                return [$pair => $element];
            })->sortKeys();
    }

    public function insert(int $steps): void
    {
        for ($s=0; $s<$steps; $s++) {
            $pairs = [];
            foreach ($this->pairs as $pair => $count) {
                $key1 = $pair[0] . $this->rules[$pair];
                $pairs[$key1] = ($pairs[$key1] ?? 0) + $count;

                $key2 = $this->rules[$pair] . $pair[1];
                $pairs[$key2] = ($pairs[$key2] ?? 0) + $count;
            }
            $this->pairs = $pairs;
        }
    }

    public function count() : Collection
    {
        $letters = [];
        foreach ($this->pairs as $pair => $count) {
            // let's first count everything twice
            foreach (str_split($pair) as $letter) {
                $letters[$letter] = ($letters[$letter] ?? 0) + $count;
            }
        }

        // correct for first and last character
        $letters[$this->template[0]]++;
        $letters[substr($this->template, -1)]++;

        // divide everything by 2
        return collect($letters)->map(fn ($l) => $l / 2);
    }
}
