<?php

namespace XhProf;

class Sampler
{
    public function start()
    {
        xhprof_sample_enable();
    }

    public function stop()
    {
        return xhprof_sample_disable();
    }
}