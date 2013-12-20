<?php

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
            throw new StorageException('Cannot find trace with token %s', $token);
        }

        return $this->traces[$token];
    }
}
