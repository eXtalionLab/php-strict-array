<?php
declare(strict_types=1);

/**
 * Return all the keys or a subset of the keys of an array
 *
 * Parameter $strict is always true.
 *
 * @param array|\StrictArray $array
 * @param miexd $search_value
 *
 * @return array|\StrictArray
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.array-keys.php
 */
function sarray_keys($array, $search_value = null): array
{
    if (\is_array($array)) {
        return \func_num_args() === 1
            ? \array_keys($array)
            : \array_keys($array, $search_value, true);
    }

    if ($array instanceof \StrictArray) {
        $keys = [];

        if ($search_value !== null) {
            foreach ($array as $key => $value) {
                if ($value === $search_value) {
                    $keys[] = $key;
                }
            }
        } else {
            foreach ($array as $key => $value) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    throw new \TypeError(
        \sprintf(
            '%s() expects parameter 2 to be (strict) array, %s given',
            __FUNCTION__,
            \gettype($array)
        )
    );
}
