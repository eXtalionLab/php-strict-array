<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\DTO;

use eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class ArrayDefinition
{
    /**
     * @var \eXtalion\PhpStrictArray\Enum\KeyType
     */
    private $_key;

    /**
     * @var \eXtalion\PhpStrictArray\Enum\ValueType
     */
    private $_value;

    /**
     * @var \eXtalion\PhpStrictArray\DTO\ObjectDefinition|null
     */
    private $_objectDefinition;

    /**
     * Check if array definition is a map
     *
     * @return bool
     */
    public function isMap(): bool
    {
        return $this->getKey() !== Enum\KeyType::int();
    }

    /**
     * Check if array value is user's object
     *
     * @return bool
     */
    public function isObject(): bool
    {
        return $this->getValue() === Enum\ValueType::object()
            && $this->getObjectDefinition();
    }

    /**
     * @return \eXtalion\PhpStrictArray\Enum\KeyType
     */
    public function getKey(): Enum\KeyType
    {
        return $this->_key;
    }

    /**
     * @param \eXtalion\PhpStrictArray\Enum\KeyType $key
     *
     * @return \eXtalion\PhpStrictArray\DTO\ArrayDefinition
     */
    public function setKey(Enum\KeyType $key): ArrayDefinition
    {
        $this->_key = $key;

        return $this;
    }

    /**
     * @return \eXtalion\PhpStrictArray\Enum\ValueType
     */
    public function getValue(): Enum\ValueType
    {
        return $this->_value;
    }

    /**
     * @param \eXtalion\PhpStrictArray\Enum\ValueType $value
     *
     * @return \eXtalion\PhpStrictArray\DTO\ArrayDefinition
     */
    public function setValue(Enum\ValueType $value): ArrayDefinition
    {
        $this->_value = $value;

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
     * @return \eXtalion\PhpStrictArray\DTO\ArrayDefinition
     */
    public function setObjectDefinition(
        ?ObjectDefinition $objectDefinition
    ): ArrayDefinition {
        $this->_objectDefinition = $objectDefinition;

        return $this;
    }
}
