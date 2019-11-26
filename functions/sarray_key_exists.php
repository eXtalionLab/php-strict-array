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

    throw new \TypeError(
        \sprintf(
            '%s() expects parameter 2 to be (strict) array, %s given',
            __FUNCTION__,
            \gettype($array)
        )
    );
}
