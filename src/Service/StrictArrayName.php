<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Service;

use eXtalion\PhpStrictArray\DTO\ArrayDefinition;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class StrictArrayName
{
    /**
     * Get name understud by human
     *
     * Example:
     *   array<type>
     *   array<key, type>
     *
     * @param \eXtalion\PhpStrictArray\DTO\ArrayDefinition $arrayDefinition
     *
     * @return string
     */
    public function forHuman(ArrayDefinition $arrayDefinition): string
    {
        $key = $arrayDefinition->isMap()
            ? "{$arrayDefinition->getKey()}, "
            : '';
        $type = $arrayDefinition->isObject()
            ? "\\{$arrayDefinition->getObjectDefinition()->getName()}"
            : $arrayDefinition->getValue();

        return \sprintf('array<%s%s>', $key, $type);
    }

    /**
     * Get name understud by computer
     *
     * Example:
     *   array_type_
     *   array_key_and_type_
     *
     * @param \eXtalion\PhpStrictArray\DTO\ArrayDefinition $arrayDefinition
     *
     * @return string
     */
    public function forComputer(ArrayDefinition $arrayDefinition): string
    {
        $key = $arrayDefinition->isMap()
            ? "{$arrayDefinition->getKey()}_and_"
            : '';
        $type = $arrayDefinition->isObject()
            ? $arrayDefinition->getObjectDefinition()->getAlias()
            : $arrayDefinition->getValue();

        return \sprintf('array_%s%s_', $key, $type);
    }
}
