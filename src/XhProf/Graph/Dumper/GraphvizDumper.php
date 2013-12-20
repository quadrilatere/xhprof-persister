<?php

namespace XhProf\Graph\Dumper;

use XhProf\Graph\Edge;
use XhProf\Graph\Graph;

class GraphvizDumper implements DumperInterface
{
    private $format;

    public function __construct($format = 'png')
    {
        $this->format = $format;
    }
    
    public function dump(Graph $graph)
    {
        $output = 'digraph G {' . PHP_EOL;

        foreach ($graph->getVertex(Graph::ROOT)->getEdges() as $edge) {
            $output .= $this->visitVertex($graph, $edge);
        }

        $output .= '}';

        return $this->executeDotScript($output);
    }

    private function visitVertex(Graph $graph, Edge $vertex)
    {
        if (!$vertex->getTo()) {
            return '';
        }

        $output = sprintf(
            '"%s" [label="\r\N\n%s"];%s',
            $vertex->getTo()->getName(),
            $vertex->getWeight(Edge::EXECUTION_TIME),
            PHP_EOL
        );

        foreach ($vertex->getTo()->getEdges() as $edge) {
            $output .= sprintf(
                '"%s" -> "%s" [label="%s"];%s',
                $vertex->getTo()->getName(),
                $edge->getName(),
                $edge->getWeight(Edge::EXECUTION_TIME),
                PHP_EOL
            );
        }

        return $output;
    }

    private function executeDotScript($dotScript)
    {
        $descriptors = array(
            array('pipe', 'r'),
            array('pipe', 'w'),
            array('pipe', 'w'),
        );

        $process = proc_open(sprintf('dot -T%s', $this->format), $descriptors, $pipes);

        if (false === $process) {
            throw new DumperException('Failed to initiate DOT process.');
        }

        fwrite($pipes[0], $dotScript);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        proc_close($process);

        if (!empty($error)) {
            throw new DumperException('DOT produced an error.');
        }

        if (empty($output)) {
            throw new DumperException('DOT did not output anything.');
        }

        return $output;
    }
}
