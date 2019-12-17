<?php
declare(strict_types=1);

/**
 * Doc...
 *
 * @param array|\StrictArray $array
 *
 * @return array|\StrictArray
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.foo.php
 */
function sfoo($array)
{
    if (\is_array($array)) {
        return \foo($array);
    }

    if ($array instanceof \StrictArray) {
        return $array;
    }

    \throw_type_error(__FUNCTION__, 2, $array);
}
