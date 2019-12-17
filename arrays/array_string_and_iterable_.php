<?php
declare(strict_types=1);

/**
 * What are you doing here !?!?

 * This file is for php engine not for humans!

 * Goto templates/strict_array.php.twig
 */


    
final class array_string_and_iterable_ implements \StrictArray
{
    private $data;

            public function __construct(\Pair ...$data)
        {
            $keys = [];
            $values = [];
            $uniqueData = [];

            foreach ($data as $pair) {
                $key = $this->hash($pair->first());

                $uniqueData[$key] = $pair;
                $keys[$key] = $pair->first();
                $values[$key] = $pair->second();
            }

            
            try {
                (function (string ...$v){})(...\array_values($keys));
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        
            
            try {
                (function (iterable ...$v){})(...\array_values($values));
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Value',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

            $this->data = $uniqueData;
        }
    
    public function offsetExists($offset): bool
    {
        
            try {
                (function (string ...$v){})($offset);
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

                    return isset($this->data[$this->hash($offset)]);
            }

    public function offsetGet($offset): ?iterable
    {
        
            try {
                (function (string ...$v){})($offset);
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

                    $key = $this->hash($offset);

            if ($this->data[$key]) {
                return $this->data[$key]->second();
            }

            return null;
            }

    public function offsetSet($offset, $value): void
    {
                    if ($offset === null) {
                if ($value instanceof \Pair) {
                    
            try {
                (function (string ...$v){})($value->first());
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        
                    
            try {
                (function (iterable ...$v){})($value->second());
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Value',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

                    $this->data[$this->hash($value->first())] = $value;

                    return;
                }

                throw new \TypeError(\sprintf(
                    'Argument 2 passed to %s must be an instance of %s, %s given',
                    __METHOD__,
                    \Paid::class,
                    \gettype($value)
                ));
            } else {
                
            try {
                (function (string ...$v){})($offset);
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        
                
            try {
                (function (iterable ...$v){})($value);
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Value',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

                $this->data[$this->hash($offset)] = new \Pair($offset, $value);
            }
            }

    public function offsetUnset($offset): void
    {
        
            try {
                (function (string ...$v){})($offset);
            } catch (\TypeError $ex) {
                $message = \preg_replace(
                    '/Argument/',
                    'Key',
                    $ex->getMessage(),
                    1
                );
                $message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    $message
                );

                throw new \TypeError($message);
            }
        

                    unset($this->data[$this->hash($offset)]);
            }

    public function count(): int
    {
        return \count($this->data);
    }

    public function current(): ?iterable
    {
                    return $this->valid() ? \current($this->data)->second() : null;
            }

    public function key(): ?string
    {
                    return $this->valid() ? \current($this->data)->first() : null;
            }

    public function next(): void
    {
        \next($this->data);
    }

    public function rewind(): void
    {
        \reset($this->data);
    }

    public function valid(): bool
    {
        return \key($this->data) !== null;
    }

    public function jsonSerialize(): array
    {
                    return \array_values($this->data);
            }

    public function __debugInfo(): array
    {
                    return \array_values($this->data);
            }

            private function hash($key): string
        {
            return \md5(\var_export($key, true));
        }
    }
