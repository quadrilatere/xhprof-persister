<?php

namespace XhProf\Graph;

class Edge
{
    const CALL_COUNT        = 'ct';  // number of calls to bar() from foo()
    const EXECUTION_TIME    = 'wt';  // time in bar() when called from foo()
    const CPU_USAGE         = 'cpu'; // cpu time in bar() when called from foo()
    const MEMORY_USAGE      = 'mu';  // change in PHP memory usage in bar() when called from foo()
    const PEAK_MEMORY_USAGE = 'pmu'; // change in PHP peak memory usage in bar() when called from foo()

    private $from;
    private $to;
    private $weights = array(
        self::CALL_COUNT        => 0,
        self::EXECUTION_TIME    => 0,
        self::CPU_USAGE         => 0,
        self::MEMORY_USAGE      => 0,
        self::PEAK_MEMORY_USAGE => 0,
    );

    public function __construct(Vertex $from, Vertex $to, array $weights = array())
    {
        $this->from    = $from;
        $this->to      = $to;

        $this->weights = array_merge($this->weights, array_intersect_key($weights, $this->weights));
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getWeights()
    {
        return $this->weights;
    }

    public function getWeight($type)
    {
        if (isset($this->weights[$type])) {
            return $this->weights[$type];
        }

        return null;
    }

    public function isLoop()
    {
        return $this->from === $this->to;
    }

    public function getName()
    {
        return sprintf('%s - %s', $this->from->getName(), $this->to->getName());
    }
}
