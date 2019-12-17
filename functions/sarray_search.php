<?php
declare(strict_types=1);

/**
 * Searches the (strict) array for a given value and returns the first corresponding key if successful
 *
 * @param mixed $needle
 * @param array|\StrictArray $haystack
 *
 * @return mixed
 * @throws \TypeError
 *
 * @see https://www.php.net/manual/en/function.array-search.php
 */
function sarray_search($needle, $haystack)
{
    if (\is_array($haystack)) {
        return \array_search($needle, $haystack, true);
    }

    if ($haystack instanceof \StrictArray) {
        foreach ($haystack as $key => $value) {
            if ($needle === $value) {
                return $key;
            }
        }
    }

    \throw_type_error(__FUNCTION__, 2, $haystack);
}
