<?php

namespace XhProf\Storage;

use XhProf\Trace;

class FileStorage implements StorageInterface
{
    private $baseDir;

    public function __construct($baseDir = null)
    {
        $this->baseDir = $baseDir ?: (sys_get_temp_dir() . '/xhprof');
    }

    public function store(Trace $trace)
    {
        if (!file_exists($this->baseDir)) {
            mkdir($this->baseDir, 0777, true);
        }

        $filename = $this->getFilename($trace->getToken());

        if (!@file_put_contents($filename, serialize($trace->getData()))) {
            throw new \RuntimeException(sprintf('Could not write data in file %s', $filename));
        }
    }

    public function fetch($token)
    {
        $filename = $this->getFilename($token);

        if (!$data = @file_get_contents($filename)) {
            throw new \RuntimeException(sprintf('Could not read data from file %s', $filename));
        }

        return new Trace($token, unserialize($data));
    }

    private function getFilename($token)
    {
        return sprintf('%s/%s.trace', $this->baseDir, $token);
    }
}
