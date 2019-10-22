<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\DTO;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class ObjectDefinition
{
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_alias;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     *
     * @return \eXtalion\PhpStrictArray\DTO\ObjectDefinition
     */
    public function setName(string $name): ObjectDefinition
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * @param string $alias
     *
     * @return \eXtalion\PhpStrictArray\DTO\ObjectDefinition
     */
    public function setAlias(string $alias): ObjectDefinition
    {
        $this->_alias = $alias;

        return $this;
    }
}
