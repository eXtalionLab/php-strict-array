<?php
declare(strict_types=1);

/**
 * Checks if the given key or index exists in the (strict) array
 *
 * @param mixed $key
 * @param array|\StrictArray $array
 *
 * @return array|\StrictArray
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.array-key-exists.php
 */
function sarray_key_exists($key, $array)
{
    if (\is_array($array)) {
        return \array_key_exists($key, $array);
    }

    if ($array instanceof \StrictArray) {
        return isset($array[$key]);
    }

    \throw_type_error(__FUNCTION__, 2, $array);
}
