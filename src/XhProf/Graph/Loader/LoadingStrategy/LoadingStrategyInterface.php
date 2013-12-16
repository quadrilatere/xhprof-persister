<?php

namespace XhProf\Graph\Loader\LoadingStrategy;

use XhProf\Trace;

interface LoadingStrategyInterface
{
    /**
     * @param StorageInterface $storage A storage method
     * @param Trace            $trace   A trace
     * @return Trace $trace
     */
    public function load(Trace $trace);
}