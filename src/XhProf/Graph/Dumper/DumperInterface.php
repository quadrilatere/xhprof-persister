<?php

namespace XhProf\Graph\Dumper;

use XhProf\Graph\Graph;

interface DumperInterface
{
    /**
     * @param Graph $graph
     *
     * @return mixed
     * @api
     */
    public function dump(Graph $graph);
}
