<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Storage;

use XhProf\Trace;

class FileStorage implements StorageInterface
{
    private $baseDir;
    private $extension;
    private $fileMask;

    public function __construct($baseDir = null, $extension = 'trace')
    {
        $this->baseDir = $baseDir ?: (rtrim(sys_get_temp_dir(), '/') . '/xhprof');
        $this->extension = $extension;
        $this->fileMask = sprintf('%s/%%s.%s', $this->baseDir, $this->extension);
    }

    public function store(Trace $trace)
    {
        if (!file_exists($this->baseDir)) {
            mkdir($this->baseDir, 0777, true);
        }

        $filename = $this->getFilename($trace->getToken());

        if (!@file_put_contents($filename, serialize($trace))) {
            throw new \RuntimeException(sprintf('Could not write data in file %s', $filename));
        }
    }

    public function fetch($token)
    {
        $filename = $this->getFilename($token);

        if (!$data = @file_get_contents($filename)) {
            throw new \RuntimeException(sprintf('Could not read data from file %s', $filename));
        }

        $trace = unserialize($data);

        if ($trace instanceof Trace) {
            return $trace;
        }

        return new Trace($token, $trace);
    }

    public function getTokens()
    {
        $files = new \GlobIterator($this->getFilename('*'));

        $tokens = array();

        foreach ($files as $file) {
            $tokens[] = $file->getBasename(sprintf('.%s', $this->extension));
        }

        return $tokens;
    }

    private function getFilename($token)
    {
        return sprintf($this->fileMask, $token);
    }
}
