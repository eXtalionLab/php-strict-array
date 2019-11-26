<?php
declare(strict_types=1);

/**
 * Return all the values of an (strict) array
 *
 * @param array|\StrictArray $array
 *
 * @return array
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.array-values.php
 */
function sarray_values($array): array
{
    if (\is_array($array)) {
        return $array;
    }

    if ($array instanceof \StrictArray) {
        $values = [];

        foreach ($array as $value) {
            $values[] = $value;
        }

        return $values;
    }

    throw new \TypeError(
        \sprintf(
            '%s() expects parameter 1 to be (strict) array, %s given',
            __FUNCTION__,
            \gettype($array)
        )
    );
}
