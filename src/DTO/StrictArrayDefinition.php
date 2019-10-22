<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\DTO;

use eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class StrictArrayDefinition
{
    /**
     * @var \eXtalion\PhpStrictArray\Enum\ArrayTypes
     */
    private $_arrayType;

    /**
     * @var \eXtalion\PhpStrictArray\Enum\KeyTypes|null
     */
    private $_keyType;

    /**
     * @var \eXtalion\PhpStrictArray\Enum\ValueTypes
     */
    private $_valueType;

    /**
     * @var \eXtalion\PhpStrictArray\DTO\ObjectDefinition|null
     */
    private $_objectDefinition;

    /**
     * Check if array definition is map
     *
     * @return bool
     */
    public function isMap(): bool
    {
        return $this->getArrayType() === Enum\ArrayTypes::map();
    }

    /**
     * Check if array value is object
     *
     * @return bool
     */
    public function isObject(): bool
    {
        return $this->getValueType() === Enum\ValueTypes::object();
    }

    public function __toString(): string
    {
        return \sprintf(
            'array<%s%s>',
            $this->isMap()
                ? "{$this->getKeyType()}, "
                : '',
            $this->getObjectDefinition()
                ? $this->getObjectDefinition()->getAlias()
                : $this->getValueType()
        );
    }

    /**
     * @return \eXtalion\PhpStrictArray\Enum\ArrayTypes
     */
    public function getArrayType(): Enum\ArrayTypes
    {
        return $this->_arrayType;
    }

    /**
     * @param \eXtalion\PhpStrictArray\Enum\ArrayType $arrayType
     *
     * @return \eXtalion\PhpStrictArray\DTO\StrictArrayDefinition
     */
    public function setArrayType(
        Enum\ArrayTypes $arrayType
    ): StrictArrayDefinition {
        $this->_arrayType = $arrayType;

        return $this;
    }

    /**
     * @return \eXtalion\PhpStrictArray\Enum\KeyTypes|null
     */
    public function getKeyType(): ?Enum\KeyTypes
    {
        return $this->_keyType;
    }

    /**
     * @param \eXtalion\PhpStrictArray\Enum\KeyTypes|null $keyType
     *
     * @return \eXtalion\PhpStrictArray\DTO\StrictArrayDefinition
     */
    public function setKeyType(
        ?Enum\KeyTypes $keyType
    ): StrictArrayDefinition {
        $this->_keyType = $keyType;

        return $this;
    }

    /**
     * @return \eXtalion\PhpStrictArray\Enum\ValueTypes
     */
    public function getValueType(): Enum\ValueTypes
    {
        return $this->_valueType;
    }

    /**
     * @param \eXtalion\PhpStrictArray\Enum\ValueTypes $valueType
     *
     * @return \eXtalion\PhpStrictArray\DTO\StrictArrayDefinition
     */
    public function setValueType(
        Enum\ValueTypes $valueType
    ): StrictArrayDefinition {
        $this->_valueType = $valueType;

        return $this;
    }

    /**
     * @return \eXtalion\PhpStrictArray\DTO\ObjectDefinition|null
     */
    public function getObjectDefinition(): ?ObjectDefinition
    {
        return $this->_objectDefinition;
    }

    /**
     * @param \eXtalion\PhpStrictArray\DTO\ObjectDefinition|null $objectDefinition
     *
     * @return \eXtalion\PhpStrictArray\DTO\StrictArrayDefinition
     */
    public function setObjectDefinition(
        ?ObjectDefinition $objectDefinition
    ): StrictArrayDefinition {
        $this->_objectDefinition = $objectDefinition;

        return $this;
    }
}
