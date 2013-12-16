<?php

namespace XhProf\Graph\Loader\LoadingStrategy;

use XhProf\Graph\Graph;
use XhProf\Graph\Vertex;
use XhProf\Trace;

class InclusiveLoadingStrategy implements LoadingStrategyInterface
{
    public function load(Trace $trace)
    {
        $graph = new Graph();

        foreach ($trace->getData() as $vertices => $weights) {
            $pos = strpos($vertices, '==>');

            if (!$pos) {
                $from = new Vertex(Graph::ROOT, $graph);
                $graph->addVertex($from);

                if (!$to = $graph->getVertex($vertices)) {
                    $to = new Vertex($vertices, $graph);
                    $graph->addVertex($to);
                }
            } else {
                $fromName = substr($vertices, 0, $pos);
                $toName = substr($vertices, $pos + 3);

                if (!$from = $graph->getVertex($fromName)) {
                    $from = new Vertex($fromName, $graph);
                    $graph->addVertex($from);
                }

                if (!$to = $graph->getVertex($toName)) {
                    $to = new Vertex($toName, $graph);
                    $graph->addVertex($to);
                }
            }

            $from->connect($to, $weights);
        }

        return $graph;
    }
}