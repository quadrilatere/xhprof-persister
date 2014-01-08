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
     * @param $name
     * @param Graph $graph
     */
    public function __construct($name, Graph $graph)
    {
        $this->name = $name;
        $this->graph = $graph;
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

    /**
     * {@inheritDoc}
     */
    public function accept(VisitorInterface $visitor)
    {
        foreach ($this->getEdges() as $edge) {
            if ($edge->getFrom() === $this) {
                $visitor->visitEdge($edge);
            }
        }
    }
}
