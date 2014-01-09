<?php

namespace XhProf\Graph\Formatter;

class MetricsFormatter
{
    public function formatBytes($size, $precision = 2)
    {
        if($size == 0) {
            return 0;
        }

        $base = log(abs($size)) / log(1024);
        $suffixes = array('b', 'k', 'M', 'G', 'T');

        $number = round(pow(1024, $base - floor($base)), $precision);
        $suffix = $suffixes[floor($base)];

        return sprintf('%s %s', $number, $suffix);
    }

    public function formatTime($time)
    {
        $time = (int) $time;

        $pad = false;
        $suffix = 'µs';

        if (abs($time) >= 1000) {
            $time = $time / 1000;
            $suffix = 'ms';

            if (abs($time) >= 1000) {
                $pad = true;

                $time = $time / 1000;
                $suffix = 's';

                if (abs($time) >= 60) {
                    $time = $time / 60;
                    $suffix = 'm';
                }
            }
        }

        if($pad) {
            $time = sprintf('%.4f', $time);
        }

        return sprintf('%s %s', $time, $suffix);
    }
}
