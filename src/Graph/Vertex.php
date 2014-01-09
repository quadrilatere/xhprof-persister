<?php

namespace XhProf\Graph;

use XhProf\Graph\Visitor\VisitableInterface;
use XhProf\Graph\Visitor\VisitorInterface;

class Vertex implements VisitableInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Graph
     */
    private $graph;

    /**
     * @var Edge[]
     */
    private $edges;

    /**
     * @var bool
     */
    private $visited;

    /**
     * @param $name
     * @param Graph $graph
     */
    public function __construct($name, Graph $graph)
    {
        $this->name = $name;
        $this->graph = $graph;
        $this->edges = array();
        $this->visited = false;
    }

    /**
     * @return Edge[]
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Vertex $vertex
     * @param $weights
     *
     * @return Edge
     * @throws \InvalidArgumentException
     */
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

    public function computeWeight($type)
    {
        $that = $this;
        $edges = array_filter($this->getEdges(), function (Edge $edge) use ($that) {
            return $edge->getTo() === $that;
        });

        $sum = 0;
        foreach ($edges as $edge) {
            $sum += $edge->getWeight($type);
        }

        return $sum;
    }

    /**
     * {@inheritDoc}
     */
    public function accept(VisitorInterface $visitor)
    {
        if ($this->visited) {
            return;
        }

        $this->visited = true;

        foreach ($this->edges as $edge) {
            if ($edge->getFrom() === $this) {
                $visitor->visitEdge($edge);
            }
        }
    }
}
