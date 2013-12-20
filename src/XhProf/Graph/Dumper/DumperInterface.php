<?php

namespace XhProf\Graph\Dumper;

use XhProf\Graph\Graph;

interface DumperInterface
{
    public function dump(Graph $graph);
}
