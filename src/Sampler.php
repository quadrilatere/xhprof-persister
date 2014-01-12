<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

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