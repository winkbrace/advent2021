<?php declare(strict_types=1);

require_once 'Pair.php';

use PHPUnit\Framework\TestCase;

class PairTest extends TestCase
{
    private Pair $pair;

    protected function setUp() : void
    {
        parent::setUp();

        $this->pair = new Pair(1,1);
    }

    /** @test */
    public function it_should_add_a_pair() : void
    {
        $this->pair->add(new Pair(2,2));

        self::assertSame('[[1,1],[2,2]]', (string) $this->pair);
    }

    /** @test */
    public function it_should_add_an_int() : void
    {
        $this->pair->add(2);

        self::assertSame('[[1,1],2]', (string) $this->pair);
    }

    /** @test */
    public function it_should_add_four_pairs() : void
    {
        $this->pair
            ->add(new Pair(2,2))
            ->add(new Pair(3,3))
            ->add(new Pair(4,4));

        self::assertSame('[[[[1,1],[2,2]],[3,3]],[4,4]]', (string) $this->pair);
    }

    /** @test */
    public function it_should_create_from_string() : void
    {
        $pair = Pair::fromString('[[[[3,0],[5,3]],[4,4]],[5,5]]');

        self::assertSame(3, $pair->a->a->a->a);
        self::assertSame(0, $pair->a->a->a->b);
        self::assertSame(5, $pair->a->a->b->a);
        self::assertSame(3, $pair->a->a->b->b);
    }

    /** @test */
    public function it_should_explode() : void
    {
        $pair = Pair::fromString('[[[[[9,8],1],2],3],4]');
        $pair->reduce();

        self::assertSame('[[[[0,9],2],3],4]', (string) $pair);
    }

    /** @test */
    public function it_should_explode2() : void
    {
        $pair = Pair::fromString('[7,[6,[5,[4,[3,2]]]]]');
        $pair->reduce();

        self::assertSame('[7,[6,[5,[7,0]]]]', (string) $pair);
    }

    /** @test */
    public function it_should_explode3() : void
    {
        $pair = Pair::fromString('[[6,[5,[4,[3,2]]]],1]');
        $pair->reduce();

        self::assertSame('[[6,[5,[7,0]]],3]', (string) $pair);
    }

    /** @test */
    public function it_should_explode4() : void
    {
        $pair = Pair::fromString('[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]');
        $pair->reduce();

        // after 2 explode steps
        self::assertSame('[[3,[2,[8,0]]],[9,[5,[7,0]]]]', (string) $pair);
    }

    /** @test */
    public function it_should_reduce_automatically() : void
    {
        $this->pair
            ->add(new Pair(2,2))
            ->add(new Pair(3,3))
            ->add(new Pair(4,4))
            ->add(new Pair(5,5));

        self::assertSame('[[[[3,0],[5,3]],[4,4]],[5,5]]', (string) $this->pair);
    }

    /** @test */
    public function it_should_split() : void
    {
        $pair = Pair::fromString('[13,3]');
        $pair->reduce();

        self::assertSame('[[6,7],3]', (string) $pair);
    }

    /** @test */
    public function it_should_reduce_example1() : void
    {
        $pair = Pair::fromString('[[[[4,3],4],4],[7,[[8,4],9]]]');
        $pair->add(new Pair(1,1));

        self::assertSame('[[[[0,7],4],[[7,8],[6,0]]],[8,1]]', (string) $pair);
    }

    /** @test */
    public function it_should_add_example_part1() : void
    {
        $pair = Pair::fromString('[[[0,[4,5]],[0,0]],[[[4,5],[2,6]],[9,5]]]');
        $pair->add(Pair::fromString('[7,[[[3,7],[4,3]],[[6,3],[8,8]]]]'));

        self::assertSame('[[[[4,0],[5,4]],[[7,7],[6,0]]],[[8,[7,7]],[[7,9],[5,0]]]]', (string) $pair);
    }

    /** @test */
    public function it_should_parse_input_file() : void
    {
        $input = file(__DIR__ . '/example1.txt');
        $pair = Pair::fromString(trim(array_shift($input)));
        foreach ($input as $line) {
            $pair->add(Pair::fromString(trim($line)));
        }

        self::assertSame('[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]', (string) $pair);
    }

    /** @test */
    public function it_should_calculate_magnitude() : void
    {
        self::assertSame(143, Pair::fromString('[[1,2],[[3,4],5]]')->magnitude());
        self::assertSame(1384, Pair::fromString('[[[[0,7],4],[[7,8],[6,0]]],[8,1]]')->magnitude());
        self::assertSame(445, Pair::fromString('[[[[1,1],[2,2]],[3,3]],[4,4]]')->magnitude());
        self::assertSame(791, Pair::fromString('[[[[3,0],[5,3]],[4,4]],[5,5]]')->magnitude());
        self::assertSame(1137, Pair::fromString('[[[[5,0],[7,4]],[5,5]],[6,6]]')->magnitude());
        self::assertSame(3488, Pair::fromString('[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]')->magnitude());
    }

    /** @test */
    public function it_should_calculate_magnitude_of_example2() : void
    {
        $input = file(__DIR__ . '/example2.txt');
        $pair = Pair::fromString(trim(array_shift($input)));
        foreach ($input as $line) {
            $pair->add(Pair::fromString(trim($line)));
        }

        self::assertSame('[[[[6,6],[7,6]],[[7,7],[7,0]]],[[[7,7],[7,7]],[[7,8],[9,9]]]]', (string) $pair);
        self::assertSame(4140, $pair->magnitude());
    }
}
