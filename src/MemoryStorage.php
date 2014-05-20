<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Storage;

use XhProf\Trace;

class MemoryStorage implements StorageInterface
{
    /** @var array|Trace[] */
    private $traces;

    public function __construct()
    {
        $this->traces = array();
    }

    public function store(Trace $trace)
    {
        $this->traces[$trace->getToken()] = $trace;
    }

    public function fetch($token)
    {
        if (!isset($this->traces[$token])) {
            throw new StorageException(sprintf('Cannot find trace with token %s', $token));
        }

        return $this->traces[$token];
    }

    public function getTokens()
    {
        return array_keys($this->traces);
    }
}
