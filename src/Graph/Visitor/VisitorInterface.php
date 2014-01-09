<?php

namespace XhProf\Graph\Visitor;

use XhProf\Graph\Edge;
use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;

interface VisitorInterface
{
    /**
     * @param Graph $graph
     *
     * @return mixed
     */
    public function visitGraph(Graph $graph);

    /**
     * @param Edge $edge
     *
     * @return mixed
     */
    public function visitEdge(Edge $edge);

    /**
     * @param Vertex $vertex
     *
     * @return mixed
     */
    public function visitVertex(Vertex $vertex);
}
