<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests;

use PHPUnit\Framework\TestCase;

final class MapTest extends TestCase
{
    public function testEmptyConstruct(): void
    {
        $array = new \array_string_and_int;

        $this->assertInstanceOf(\StrictArray::class, $array);
        $this->assertFalse($array->valid());
    }

    public function testConstructWithWrongTypeInitValue(): void
    {
        $this->expectException(\TypeError::class);

        new \array_string_and_int(new \Pair('a', 1), ['b' => 2]);
    }

    public function testConstructWithWrongKeyTypeInitValue(): void
    {
        $this->expectException(\TypeError::class);

        new \array_string_and_int(new \Pair('a', 1), new \Pair(2, 2));
    }

    public function testConstructWithWrongValueTypeInitValue(): void
    {
        $this->expectException(\TypeError::class);

        new \array_string_and_int(new \Pair('a', 1), new \Pair('b', 'b'));
    }

    public function testConstructWithInitValue(): void
    {
        $array = new \array_string_and_int(new \Pair('a', 1), new \Pair('b', 2));

        $this->assertTrue($array->valid());
    }

    public function testOffsetExistsTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_string_and_int;

        isset($array[1]);
    }

    public function testOffsetExists(): void
    {
        $array = new \array_string_and_int(new \Pair('a', 1), new \Pair('b', 2));

        $this->assertFalse(isset($array['f']));
        $this->assertTrue(isset($array['b']));
    }

    public function testOffsetGetTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_string_and_int;

        $array[1];
    }

    public function testOffsetGetUndefinedOffset(): void
    {
        $this->expectNotice();

        $array = new \array_string_and_int;

        $array['e'];
    }

    public function testOffsetGet(): void
    {
        $array = new \array_string_and_int(new \Pair('a', 1), new \Pair('b', 2));

        $this->assertSame(2, $array['b']);
        $this->assertNull(@$array['e']);
    }

    public function testOffsetSetKeyTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_string_and_int;

        $array[1] = 1;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_string_and_int;

        $array['a'] = 'string';
    }

    public function testOffsetSetValueTypeErrorWithoutKey(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_string_and_int;

        $array[] = 1;
    }

    public function testOffsetSet(): void
    {
        $array = new \array_string_and_int;

        $array['f'] = 3;

        $this->assertSame(3, $array['f']);
    }

    public function testOffsetSetWithoutKey(): void
    {
        $array = new \array_string_and_int;

        $array[] = new \Pair('b', 3);

        $this->assertSame(3, $array['b']);
    }

    public function testCount(): void
    {
        $array = new \array_string_and_int;

        $this->assertCount(0, $array);

        $array[] = new \Pair('a', 1);
        $array['d'] = 4;

        $this->assertCount(2, $array);
    }

    public function testIterateThroughArray(): void
    {
        $values = ['a' => 1, 'b' => 2];
        $array = new \array_string_and_int(new \Pair('a', 1), new \Pair('b', 2));

        foreach ($array as $index => $element) {
            $this->assertSame(
                $values[$index],
                $element
            );
        }

        $this->assertNull($array->current());
        $this->assertNull($array->key());
        $this->assertFalse($array->valid());
    }
}
