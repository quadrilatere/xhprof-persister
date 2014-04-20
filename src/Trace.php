<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf;

use XhProf\Context\Context;

class Trace implements \Serializable
{
    private $token;
    private $data;
    private $context;

    public function __construct($token, array $data, Context $context = null)
    {
        $this->token = $token;
        $this->data = $data;
        $this->context = $context;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function serialize()
    {
        return serialize(array($this->token, $this->data, $this->context));
    }

    public function unserialize($value)
    {
        list($this->token, $this->data, $this->context) = unserialize($value);
    }
}