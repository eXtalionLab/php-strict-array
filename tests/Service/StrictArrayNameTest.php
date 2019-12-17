<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\Service;

use eXtalion\PhpStrictArray\DTO\ArrayDefinition;
use eXtalion\PhpStrictArray\DTO\ObjectDefinition;
use eXtalion\PhpStrictArray\Enum\KeyType;
use eXtalion\PhpStrictArray\Enum\ValueType;
use eXtalion\PhpStrictArray\Service\StrictArrayName;
use PHPUnit\Framework\TestCase;

/**
 * @covers \eXtalion\PhpStrictArray\Service\StrictArrayName
 */
final class StrictArrayNameTest extends TestCase
{
    protected function setUp(): void
    {
        $this->service = new StrictArrayName();
    }

    /**
     * @dataProvider arrayDefinitionForHumanName
     */
    public function testNameForHuman(
        ArrayDefinition $arrayDefinition,
        string $name
    ): void {
        $this->assertSame(
            $name,
            $this->service->forHuman($arrayDefinition)
        );
    }

    public function arrayDefinitionForHumanName(): array
    {
        $arrayDefinition = [];

        foreach (KeyType::VALUES as $key) {
            foreach (ValueType::VALUES as $type) {
                $index = KeyType::$key() === KeyType::int()
                    ? "vector {$type}"
                    : "map {$key} and {$type}";
                $expectName = KeyType::$key() === KeyType::int()
                    ? "array<{$type}>"
                    : "array<{$key}, {$type}>";

                $arrayDefinition[$index] = [
                    (new ArrayDefinition)
                        ->setKey(KeyType::$key())
                        ->setValue(ValueType::$type()),
                    $expectName
                ];
            }
        }

        $objectDefinition = (new ObjectDefinition)
            ->setName('Foo\\Bar');

        $arrayDefinition['vector user\'s object'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<Foo\Bar>'
        ];
        $arrayDefinition['map string and user\'s object'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<string, Foo\Bar>'
        ];

        $objectDefinition = (new ObjectDefinition)
            ->setName('array_int_');

        $arrayDefinition['vector vector'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<array<int>>'
        ];
        $arrayDefinition['map string and vector'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<string, array<int>>'
        ];

        $objectDefinition = (new ObjectDefinition)
            ->setName('array_string_and_object_');

        $arrayDefinition['vector map'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<array<string, object>>'
        ];
        $arrayDefinition['map string and map'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array<string, array<string, object>>'
        ];

        return $arrayDefinition;
    }

    /**
     * @dataProvider arrayDefinitionForComputerName
     */
    public function testNameForComputer(
        ArrayDefinition $arrayDefinition,
        string $name
    ): void {
        $this->assertSame(
            $name,
            $this->service->forComputer($arrayDefinition)
        );
    }

    public function arrayDefinitionForComputerName(): array
    {
        $arrayDefinition = [];

        foreach (KeyType::VALUES as $key) {
            foreach (ValueType::VALUES as $type) {
                $index = KeyType::$key() === KeyType::int()
                    ? "vector {$type}"
                    : "map {$key} and {$type}";
                $expectName = KeyType::$key() === KeyType::int()
                    ? "array_{$type}_"
                    : "array_{$key}_and_{$type}_";

                $arrayDefinition[$index] = [
                    (new ArrayDefinition)
                        ->setKey(KeyType::$key())
                        ->setValue(ValueType::$type()),
                    $expectName
                ];
            }
        }

        $objectDefinition = (new ObjectDefinition)
            ->setAlias('Bar');

        $arrayDefinition['vector user\'s object'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_Bar_'
        ];
        $arrayDefinition['map string and user\'s object'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_string_and_Bar_'
        ];

        $objectDefinition = (new ObjectDefinition)
            ->setAlias('array_int_');

        $arrayDefinition['vector vector'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_array_int__'
        ];
        $arrayDefinition['map string and vector'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_string_and_array_int__'
        ];

        $objectDefinition = (new ObjectDefinition)
            ->setAlias('array_string_and_object_');

        $arrayDefinition['vector map'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::int())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_array_string_and_object__'
        ];
        $arrayDefinition['map string and map'] = [
            (new ArrayDefinition)
                ->setKey(KeyType::string())
                ->setValue(ValueType::object())
                ->setObjectDefinition($objectDefinition),
            'array_string_and_array_string_and_object__'
        ];

        return $arrayDefinition;
    }
}
