<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\functions;

use PHPUnit\Framework\TestCase;

final class SArrayKeyExistsTest extends TestCase
{
    public function testArrayKeyExists(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int_(...$array);

        $this->assertTrue(\array_key_exists(2, $array));
        $this->assertTrue(\sarray_key_exists(2, $array));
        $this->assertTrue(\sarray_key_exists(2, $strictArray));
    }

    public function testArrayKeyNotExists(): void
    {
        $array = [1, 2, 5, 10];
        $strictArray = new \array_int_(...$array);

        $this->assertFalse(\array_key_exists(8, $array));
        $this->assertFalse(\sarray_key_exists(8, $array));
        $this->assertFalse(\sarray_key_exists(8, $strictArray));
    }

    public function testTypeError(): void
    {
        $this->expectException(\TypeError::class);

        \sarray_key_exists(2, 'string');
    }
}
