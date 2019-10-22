<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 *
 * @method static ValueTypes int()
 * @method static ValueTypes float()
 * @method static ValueTypes string()
 * @method static ValueTypes bool()
 * @method static ValueTypes array()
 * @method static ValueTypes object()
 * @method static ValueTypes callable()
 * @method static ValueTypes iterable()
 */
final class ValueTypes extends \Enum
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
