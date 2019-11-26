<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 *
 * @method static KeyType int()
 * @method static KeyType string()
 */
final class KeyType extends \Enum
{
    const VALUES = [
        'int' => 'int',
        'string' => 'string'
    ];
}
