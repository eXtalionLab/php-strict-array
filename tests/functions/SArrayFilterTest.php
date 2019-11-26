<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\functions;

use PHPUnit\Framework\TestCase;

final class SArrayFilterTest extends TestCase
{
    public function testArrayFilter(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $callback = function ($value) {
            return $value % 2;
        };

        $filterCoreArray = \array_filter($array, $callback);
        $filterArray = \sarray_filter($array, $callback);
        $filterStrictArray = \sarray_filter($strictArray, $callback);

        $count = \count($filterCoreArray);
        $this->assertCount($count, $filterArray);
        $this->assertCount($count, $filterStrictArray);

        foreach ($filterCoreArray as $key => $value) {
            $this->assertSame($value, $filterArray[$key]);
            $this->assertSame($value, $filterStrictArray[$key]);
        }
    }

    public function testArrayFilterByKey(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $callback = function ($key) {
            return $key % 2;
        };

        $filterCoreArray = \array_filter($array, $callback, \ARRAY_FILTER_USE_KEY);
        $filterArray = \sarray_filter($array, $callback, \ARRAY_FILTER_USE_KEY);
        $filterStrictArray = \sarray_filter($strictArray, $callback, \ARRAY_FILTER_USE_KEY);

        $count = \count($filterCoreArray);
        $this->assertCount($count, $filterArray);
        $this->assertCount($count, $filterStrictArray);

        foreach ($filterCoreArray as $key => $value) {
            $this->assertSame($value, $filterArray[$key]);
            $this->assertSame($value, $filterStrictArray[$key]);
        }
    }

    public function testArrayFilterByBoth(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $callback = function ($value, $key) {
            return $value === 2 || $key === 2;
        };

        $filterCoreArray = \array_filter($array, $callback, \ARRAY_FILTER_USE_BOTH);
        $filterArray = \sarray_filter($array, $callback, \ARRAY_FILTER_USE_BOTH);
        $filterStrictArray = \sarray_filter($strictArray, $callback, \ARRAY_FILTER_USE_BOTH);

        $count = \count($filterCoreArray);
        $this->assertCount($count, $filterArray);
        $this->assertCount($count, $filterStrictArray);

        foreach ($filterCoreArray as $key => $value) {
            $this->assertSame($value, $filterArray[$key]);
            $this->assertSame($value, $filterStrictArray[$key]);
        }
    }

    public function testTypeError(): void
    {
        $this->expectException(\TypeError::class);

        \sarray_filter('string');
    }
}
