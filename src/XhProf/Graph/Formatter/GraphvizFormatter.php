<?php

namespace XhProf\Graph\Formatter;

use XhProf\Graph\Edge;
use XhProf\Graph\Vertex;

class GraphvizFormatter
{
    public function __construct()
    {
        $this->metricsFormatter = new MetricsFormatter();
    }

    public function formatVertex(Vertex $vertex, Edge $edge)
    {
        $output = <<<EOT
"%s" [shape=none, label=<
    <table border="0" cellspacing="0" cellborder="1" cellpadding="5">
        <tr>
            <td colspan="2" align="left">%s</td>
        </tr>
        <tr>
            <td align="left">ct</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">wt</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">cpu</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">mu</td>
            <td align="left">%s</td>
        </tr>
        <tr>
            <td align="left">pmu</td>
            <td align="left">%s</td>
        </tr>
    </table>
>];
EOT;

        return sprintf(
            $output,
            $vertex->getName(),
            $vertex->getName(),
            $edge->getWeight(Edge::CALL_COUNT),
            $this->metricsFormatter->formatTime($edge->getWeight(Edge::EXECUTION_TIME)),
            $this->metricsFormatter->formatTime($edge->getWeight(Edge::CPU_USAGE)),
            $this->metricsFormatter->formatBytes($edge->getWeight(Edge::MEMORY_USAGE)),
            $this->metricsFormatter->formatBytes($edge->getWeight(Edge::PEAK_MEMORY_USAGE))
        );
    }

    public function formatEdge(Edge $edge)
    {
        return sprintf(
            '"%s" -> "%s" [color=grey, label="%s"];',
            $edge->getFrom()->getName(),
            $edge->getTo()->getName(),
            $edge->getWeight(Edge::EXECUTION_TIME)
        );
    }
}
