<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Enum;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 *
 * @method static ArrayTypes map()
 * @method static ArrayTypes vector()
 */
final class ArrayTypes extends \Enum
{
    const VALUES = [
        'map' => 'map',
        'vector' => 'vector'
    ];
}
