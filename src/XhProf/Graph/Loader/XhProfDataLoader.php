<?php

namespace XhProf\Graph\Loader;

use XhProf\Graph\Graph;
use XhProf\Graph\Loader\LoadingStrategy\InclusiveLoadingStrategy;
use XhProf\Graph\Vertex;
use XhProf\Storage\StorageInterface;
use XhProf\Trace;

class XhProfDataLoader
{
    private $strategy;

    public function __construct(StrategyInterface $strategy = null)
    {
        $this->strategy = $strategy ?: new InclusiveLoadingStrategy();
    }

    public function load(StorageInterface $storage, $token)
    {
        $trace = $storage->fetch($token);

        return $this->strategy->load($trace);
    }
}
