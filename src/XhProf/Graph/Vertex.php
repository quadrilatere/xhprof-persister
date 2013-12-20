<?php

namespace XhProf\Graph;

class Vertex
{
    /** @var string */
    private $name;

    /** @var Graph */
    private $graph;

    /** @var array|Edge[] */
    private $edges;

    public function __construct($name, Graph $graph)
    {
        $this->name = $name;
        $this->graph = $graph;
    }

    public function getEdges()
    {
        return $this->edges;
    }

    public function getName()
    {
        return $this->name;
    }

    public function connect(Vertex $vertex, $weights)
    {
        if ($vertex->graph !== $this->graph) {
            throw new \InvalidArgumentException('Target vertex needs to be in the same graph');
        }

        $edge = new Edge($this, $vertex, $weights);
        $this->edges[] = $edge;
        $vertex->edges[] = $edge;
        $this->graph->addEdge($edge);

        return $edge;
    }
}
