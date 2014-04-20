<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Context;

/**
 * A metadata bag implementation.
 */
class Bag implements \Serializable, \IteratorAggregate, \Countable
{
    private $values;

    public function __construct(array $values = array())
    {
        $this->values = $values;
    }

    public function get($name, $default = null)
    {
        if (!isset($this->values[$name])) {
            return $default;
        }

        return $this->values[$name];
    }

    public function set($name, $value)
    {
        $this->values[$name] = $value;
    }

    public function remove($name)
    {
        if (isset($this->values[$name])) {
            unset($this->values[$name]);
        }
    }

    public function keys()
    {
        return array_keys($this->values);
    }

    public function all()
    {
        return $this->values;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function count()
    {
        return count($this->values);
    }

    public function serialize()
    {
        return serialize($this->values);
    }

    public function unserialize($data)
    {
        $this->values = unserialize($data);
    }
}
