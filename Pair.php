<?php
declare(strict_types=1);

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
final class Pair
{
    /**
     * @var mixed
     */
    private $_first;

    /**
     * @var mixed
     */
    private $_second;

    /**
     * @param mixed $first
     * @param mixed $second
     */
    public function __construct($first, $second)
    {
        $this->_first = $first;
        $this->_second = $second;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->_first;
    }

    /**
     * @return mixed
     */
    public function second()
    {
        return $this->_second;
    }
}
