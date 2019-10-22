<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 *
 * @method static KeyTypes int()
 * @method static KeyTypes string()
 * @method static KeyTypes bool()
 */
final class KeyTypes extends \Enum
{
    const VALUES = [
        'int' => 'int',
        'string' => 'string',
        'bool' => 'bool',
    ];
}
