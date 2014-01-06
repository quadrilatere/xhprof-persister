<?php

namespace XhProf\Graph\Visitor;

use XhProf\Graph\Edge;
use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;

interface VisitorInterface
{
    public function visit(Graph $graph);
    public function visitEdge(Edge $edge);
    public function visitVertex(Vertex $vertex);
}
