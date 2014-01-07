<?php

namespace XhProf\Storage;

use XhProf\Trace;

interface StorageInterface
{
    /**
     * @param Trace $trace
     */
    public function store(Trace $trace);

    /**
     * @param string $token
     *
     * @return Trace
     */
    public function fetch($token);
} 
