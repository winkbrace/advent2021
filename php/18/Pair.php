<?php declare(strict_types=1);

final class Pair implements Stringable
{
    public function __construct(public self|int $a, public self|int $b) {}

    public static function fromString(string $str) : self|int
    {
        if (is_numeric($str)) {
            return (int) $str;
        }

        $level = 0;
        for ($i=0, $len=strlen($str); $i<$len; $i++) {
            if ($str[$i] === '[') $level++;
            elseif ($str[$i] === ']') $level--;

            if ($level === 1 && $str[$i] === ',') {
                $a = substr($str, 1, $i-1);
                $b = substr($str, $i+1, -1);
                break;
            }
        }

        return new self(self::fromString($a), self::fromString($b));
    }

    public function add(self|int $number) : self
    {
        $this->a = new self($this->a, $this->b);
        $this->b = $number;

        $this->reduce();

        return $this;
    }

    public function magnitude(): int
    {
        $a = $this->a instanceof self ? $this->a->magnitude() : $this->a;
        $b = $this->b instanceof self ? $this->b->magnitude() : $this->b;

        return (3 * $a) + (2 * $b);
    }

    public function reduce() : void
    {
        while ($pair = ($this->explode() ?? $this->split())) {
            $this->a = $pair->a;
            $this->b = $pair->b;
        }
    }

    private function explode(): ?self
    {
        $level = 0;
        $str = (string) $this;
        for ($i=0, $len=strlen($str); $i<$len; $i++) {
            if ($str[$i] === '[') $level++;
            elseif ($str[$i] === ']') $level--;

            if ($level > 4) {
                // It's safe to assume we never have more than 4 levels deep data
                preg_match_all('/\d+/', substr($str, $i-1), $matches);
                [$a, $b] = $matches[0];
                $before = substr($str, 0, $i); // everything before the '[' of the current pair
                $after = substr($str, strpos($str, ']', $i) + 1); // everything after the ']' of the current pair

                // add a to first number to the left
                preg_match_all('/\d+/', $before, $matches);
                if ( ! empty($matches[0])) {
                    $nr = end($matches[0]);
                    $before = substr_replace($before, (string) ($nr + $a), strrpos($before, $nr), strlen($nr)); // strrpos to get last occurrence
                }
                // add b to first number to the right
                preg_match('/\d+/', $after, $matches);
                if ( ! empty($matches)) {
                    $nr = reset($matches);
                    $after = substr_replace($after, (string) ($nr + $b), strpos($after, $nr), strlen($nr));
                }

                //echo "explode: {$before}0{$after}\n";
                return self::fromString($before . '0' . $after);
            }
        }

        return null;
    }

    public function __toString() : string
    {
        // This will automatically be recursive because of the implicit string casting
        return "[$this->a,$this->b]";
    }

    private function split(): ?self
    {
        $str = (string) $this;
        if ( ! preg_match('/\d{2}+/', $str, $matches)) {
            return null;
        }

        $nr = $matches[0];
        $a = floor($nr / 2);
        $b = ceil($nr / 2);
        $pair = substr_replace($str, "[$a,$b]", strpos($str, $nr), strlen($nr));

        //echo "split:   " . $pair . "\n";
        return self::fromString($pair);
    }
}
