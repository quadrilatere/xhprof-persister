<?php

namespace XhProf\Storage;

use XhProf\Trace;

interface StorageInterface
{
    public function store(Trace $trace);

    public function fetch($token);
} 