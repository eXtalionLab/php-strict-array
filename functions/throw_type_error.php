<?php
declare(strict_types=1);

/**
 * Throws \TypeError
 *
 * @param string $function
 * @param int $parameter
 * @param mixed $var
 *
 * @throws \TypeError
 */
function throw_type_error(string $function, int $parameter, $var): void
{
    throw new \TypeError(
        \sprintf(
            '%s() expects parameter %d to be (strict) array, %s given',
            $function,
            $parameter,
            \gettype($var)
        )
    );
}
