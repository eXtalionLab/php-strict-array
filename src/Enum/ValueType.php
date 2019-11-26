<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 *
 * @method static ValueType int()
 * @method static ValueType float()
 * @method static ValueType string()
 * @method static ValueType bool()
 * @method static ValueType array()
 * @method static ValueType object()
 * @method static ValueType callable()
 * @method static ValueType iterable()
 */
final class ValueType extends \Enum
{
    const VALUES = [
        'int' => 'int',
        'float' => 'float',
        'string' => 'string',
        'bool' => 'bool',
        'array' => 'array',
        'object' => 'object',
        'callable' => 'callable',
        'iterable' => 'iterable'
    ];
}
