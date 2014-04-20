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
 * A set of metadata bags containing the execution environment's information.
 */
class Context implements \Serializable
{
    private $bags;

    public function getBag($name)
    {
        if (!isset($this->bags[strtolower($name)])) {
            throw new \OutOfBoundsException(sprintf('Could not load bag "%s".', $name));
        }

        return $this->bags[strtolower($name)];
    }

    public function setBag($name, Bag $bag)
    {
        $this->bags[strtolower($name)] = $bag;
    }

    public function remove($name)
    {
        if (isset($this->bags[strtolower($name)])) {
            unset($this->bags[strtolower($name)]);
        }
    }

    public function keys()
    {
        return array_keys($this->bags);
    }

    public function all()
    {
        return $this->bags;
    }

    public function serialize()
    {
        return serialize($this->bags);
    }

    public function unserialize($data)
    {
        $this->bags = unserialize($data);
    }
}
