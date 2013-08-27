<?php

namespace XhProf;

use XhProf\Storage\StorageInterface;

class Profiler
{
    private $storage;
    private $flags;
    private $options;
    private $running = false;

    public function __construct(StorageInterface $storage, $flags = null, array $options = array())
    {
        if (!extension_loaded('xhprof')) {
            throw new \LogicException('The XhProf extension is not available');
        }

        $this->storage = $storage;
        $this->flags   = $flags ?: (XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        $this->options = array_merge_recursive(
            array('ignored_functions' => array('CSA\\XhProf\\Profiler::stop', 'xhprof_disable')),
            $options
        );
    }

    public function start()
    {
        if (true === $this->running) {
            throw new \LogicException('The profiler has already been started');
        }

        xhprof_enable($this->flags, $this->options);
        $this->running = true;
    }

    public function stop()
    {
        if (false === $this->running) {
            throw new \LogicException('The profiler has not yet been started');
        }

        $this->running = false;

        $data = xhprof_disable();
        $token = sha1(uniqid().microtime());

        $trace = new Trace($token, $data);

        $this->storage->store($trace);

        return $trace;
    }

    public function isRunning()
    {
        return $this->running;
    }
}