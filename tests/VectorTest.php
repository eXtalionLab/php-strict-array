<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests;

use PHPUnit\Framework\TestCase;

final class VectorTest extends TestCase
{
    public function testEmptyConstruct(): void
    {
        $array = new \array_int_;

        $this->assertInstanceOf(\StrictArray::class, $array);
        $this->assertFalse($array->valid());
    }

    public function testConstructWithWrongTypeInitValue(): void
    {
        $this->expectException(\TypeError::class);

        new \array_int_(1, 'a');
    }

    public function testConstructWithInitValue(): void
    {
        $array = new \array_int_(1, 2);

        $this->assertTrue($array->valid());
    }

    public function testOffsetExistsTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_int_;

        isset($array['b']);
    }

    public function testOffsetExists(): void
    {
        $array = new \array_int_(1, 2);

        $this->assertFalse(isset($array[5]));
        $this->assertTrue(isset($array[1]));
    }

    public function testOffsetGetTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_int_;

        $array['b'];
    }

    public function testOffsetGetUndefinedOffset(): void
    {
        $this->expectNotice();

        $array = new \array_int_;

        $array[4];
    }

    public function testOffsetGet(): void
    {
        $array = new \array_int_(1, 2);

        $this->assertSame(2, $array[1]);
        $this->assertNull(@$array[4]);
    }

    public function testOffsetSetKeyTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_int_;

        $array['b'] = 1;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_int_;

        $array[0] = 'string';
    }

    public function testOffsetSetValueTypeErrorWithoutKey(): void
    {
        $this->expectException(\TypeError::class);

        $array = new \array_int_;

        $array[] = 'string';
    }

    public function testOffsetSet(): void
    {
        $array = new \array_int_;

        $array[5] = 3;

        $this->assertSame(3, $array[5]);
    }

    public function testOffsetSetWithoutKey(): void
    {
        $array = new \array_int_(2);

        $array[] = 3;

        $this->assertSame(3, $array[1]);
    }

    public function testCount(): void
    {
        $array = new \array_int_;

        $this->assertCount(0, $array);

        $array[] = 1;
        $array[3] = 4;

        $this->assertCount(2, $array);
    }

    public function testIterateThroughArray(): void
    {
        $values = [1, 2];
        $array = new \array_int_(...$values);

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
