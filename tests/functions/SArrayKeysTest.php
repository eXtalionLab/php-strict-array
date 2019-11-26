<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\functions;

use PHPUnit\Framework\TestCase;

final class SArrayKeys extends TestCase
{
    public function testArrayKeys(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $keysCoreArray = \array_keys($array);
        $keysArray = \sarray_keys($array);
        $keysStrictArray = \sarray_keys($strictArray);

        $count = \count($keysCoreArray);
        $this->assertCount($count, $keysArray);
        $this->assertCount($count, $keysStrictArray);

        foreach ($keysCoreArray as $key => $value) {
            $this->assertSame($value, $keysArray[$key]);
            $this->assertSame($value, $keysStrictArray[$key]);
        }
    }

    public function testArrayKeysWithSearchValues(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $keysCoreArray = \array_keys($array, 5);
        $keysArray = \sarray_keys($array, 5);
        $keysStrictArray = \sarray_keys($strictArray, 5);

        $count = \count($keysCoreArray);
        $this->assertCount($count, $keysArray);
        $this->assertCount($count, $keysStrictArray);

        foreach ($keysCoreArray as $key => $value) {
            $this->assertSame($value, $keysArray[$key]);
            $this->assertSame($value, $keysStrictArray[$key]);
        }
    }

    public function testArrayKeysWithStrict(): void
    {
        $array = [1, 2, 5, 10];

        $keysCoreArray = \array_keys($array, '5');
        $keysArray = \sarray_keys($array, '5');

        $this->assertSame([2], $keysCoreArray);
        $this->assertSame([], $keysArray);
    }

    public function testTypeError(): void
    {
        $this->expectException(\TypeError::class);

        \sarray_keys('string');
    }
}
