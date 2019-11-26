<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\functions;

use PHPUnit\Framework\TestCase;

final class SArrayValues extends TestCase
{
    public function testArrayValues(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int(...$array);

        $valuesCoreArray = \array_values($array);
        $valuesArray = \sarray_values($array);
        $valuesStrictArray = \sarray_values($strictArray);

        $count = \count($valuesCoreArray);
        $this->assertCount($count, $valuesArray);
        $this->assertCount($count, $valuesStrictArray);

        foreach ($valuesCoreArray as $key => $value) {
            $this->assertSame($value, $valuesArray[$key]);
            $this->assertSame($value, $valuesStrictArray[$key]);
        }
    }

    public function testTypeError(): void
    {
        $this->expectException(\TypeError::class);

        \sarray_values('string');
    }
}
