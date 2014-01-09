<?php

namespace XhProf\Graph\Loader\LoadingStrategy;

use XhProf\Trace;

interface LoadingStrategyInterface
{
    /**
     * @param Trace $trace A trace
     *
     * @return Trace $trace
     */
    public function load(Trace $trace);
}
