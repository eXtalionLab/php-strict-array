<?php
declare(strict_types=1);

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
interface StrictArray extends
    \ArrayAccess,
    \Countable,
    \Iterator,
    \JsonSerializable
{
}
