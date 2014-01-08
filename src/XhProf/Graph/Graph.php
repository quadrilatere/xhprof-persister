<?php

namespace XhProf\Graph;

use XhProf\Graph\Visitor\VisitableInterface;
use XhProf\Graph\Visitor\VisitorInterface;

class Graph implements VisitableInterface
{
    const ROOT = '__root__';

    /**
     * @var Vertex[]
     */
    private $vertices;

    /**
     * @var Edge[]
     */
    private $edges;

    /**
     * @return Vertex[]
     */
    public function getVertices()
    {
        return $this->vertices;
    }

    /**
     * @param string $name
     * @return Vertex|null
     */
    public function getVertex($name)
    {
        return isset($this->vertices[$name]) ? $this->vertices[$name] : null;
    }

    /**
     * @param Vertex $vertex
     * @throws \LogicException
     */
    public function addVertex(Vertex $vertex)
    {
        if (isset($this->vertices[$vertex->getName()])) {
            throw new \LogicException(sprintf('Vertex %s already exists', $vertex->getName()));
        }

        $this->vertices[$vertex->getName()] = $vertex;
    }

    /**
     * @return Edge[]
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @param Edge $edge
     */
    public function addEdge(Edge $edge)
    {
        $this->edges[] = $edge;
    }

    /**
     * {@inheritDoc}
     */
    public function accept(VisitorInterface $visitor)
    {
        if (!$vertex = $this->getVertex('main()')) {
            throw new \LogicException('The graph should at least have a main() node.');
        }

        $visitor->visitVertex($vertex);
    }
}
