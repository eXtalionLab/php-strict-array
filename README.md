# Prepare for future with php-strict-array

According to this [article](https://www.sitepoint.com/creating-strictly-typed-arrays-collections-php/)
which shows how to create strictly typed arrays and collections in Php7,
php-strict-array was born.

---

There is some [discusion](https://wiki.php.net/rfc/generic-arrays) about
generic in Php but who knows when it comes to us.

It is not exacly what you know from **Java** or **C++** where generic looks like
`array<bool>()` or `array<string, \Foo\User>()`.

Here strict arrays looks like `array_int_`, `array_bool_` and
`array_string_and_float_` so I hope when they come to nativ Php all what you
need to do will be:
1. Replace all `new array_User`, `new array_string_and_array_object__` to
`array<User>`, `array<string, array<object>>`.

Now you do not have to validate array from user inside your packages:

```php
function foo(array $users)
{
    foreach ($users as $user) {
        if (!$user instanceof User) {
            thorw new \InvalidArgumentException();
        }
    }

    ...
}
```

Your code can be much simpler:

```php
function foo(array_User_ $users)
{
    ...
}
```

## Install

```bash
composer require eXtalion/php-strict-array
```

## Base strict arrays

Some base arrays are generated:
- `array_array_`,
- `array_bool_`,
- `array_callable_`,
- `array_float_`,
- `array_int_`,
- `array_iterable_`,
- `array_object_`,
- `array_string_`,
- `array_string_and_array_`,
- `array_string_and_bool_`,
- `array_string_and_callable_`,
- `array_string_and_float_`,
- `array_string_and_int_`,
- `array_string_and_iterable_`,
- `array_string_and_object_`,
- `array_string_and_string_`.

## Create new strict array

Run:

```
vendor/bin/php-sa [path/to/arrays-dir]
```

and answer to fee questions. Without **path/to/arrays-dir** code will be display to
STDOUT.

## It's "normal" array

There are some array functions which works with strict arrays:
- `sarray_filter`,
- `sarray_key_exists`,
- `sarray_keys`,
- `sarray_search`,
- `sarray_values`.
