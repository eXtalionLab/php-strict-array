<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\functions;

use PHPUnit\Framework\TestCase;

final class SArraySearchTest extends TestCase
{
    public function testArraySearch(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int_(...$array);

        $searchCore = \array_search(5, $array);
        $search = \sarray_search(5, $array);
        $searchStrict = \sarray_search(5, $strictArray);

        $this->assertSame($searchCore, $search);
        $this->assertSame($searchCore, $searchStrict);
    }

    public function testArrayKeysWithStrict(): void
    {
        $array = [1, 2, 5, 10];

        $searchCoreArray = \array_search('5', $array);
        $searchArray = \sarray_search('5', $array);

        $this->assertSame(2, $searchCoreArray);
        $this->assertFalse($searchArray);
    }

    public function testTypeError(): void
    {
        $this->expectException(\TypeError::class);

        \sarray_search('string');
    }
}
