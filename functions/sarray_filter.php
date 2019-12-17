<?php
declare(strict_types=1);

/**
 * Filters elements of an (strict) array using a callback function
 *
 * @param array|\StrictArray $array
 * @param callable|null $callback
 * @param int $flag
 *
 * @return array|\StrictArray
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.array-filter.php
 */
function sarray_filter($array, callable $callback = null, int $flag = 0)
{
    if (\is_array($array)) {
        return \array_filter($array, $callback, $flag);
    }

    if ($array instanceof \StrictArray) {
        if ($callback === null) {
            $callback = function ($value) {
                return $value !== false;
            };
        }

        $arrayClass = \get_class($array);
        $filterArray = new $arrayClass;

        foreach ($array as $key => $value) {
            if ($flag === \ARRAY_FILTER_USE_KEY) {
                $isOk = $callback($key);
            } elseif ($flag === \ARRAY_FILTER_USE_BOTH) {
                $isOk = $callback($value, $key);
            } else {
                $isOk = $callback($value);
            }

            if ($isOk) {
                $filterArray[$key] = $value;
            }
        }

        return $filterArray;
    }

    \throw_type_error(__FUNCTION__, 1, $array);
}
