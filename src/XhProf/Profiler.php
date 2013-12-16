<?php

namespace XhProf;

use XhProf\Storage\StorageInterface;

class Profiler
{
    private $storage;
    private $flags;
    private $options;
    private $started = false;
    private $running = false;
    private $shutdownFunction;

    public function __construct(StorageInterface $storage, $flags = null, array $options = array())
    {
        if (!extension_loaded('xhprof')) {
            throw new \LogicException('The XhProf extension is not available');
        }

        $this->storage = $storage;
        $this->flags   = $flags ?: (XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        $this->options = array_merge_recursive(
            array('ignored_functions' => array('XhProf\\Profiler::stop', 'xhprof_disable', 'XhProf\Profiler::XhProf\{closure}')),
            $options
        );
        $this->shutdownFunction = array($this, 'stop');
    }

    public function start()
    {
        if (true === $this->running) {
            throw new \LogicException('The profiler has already been started');
        }

        xhprof_enable($this->flags, $this->options);
        $this->started = true;
        $this->running = true;

        $that = $this;
        register_shutdown_function(function() use ($that) {
            register_shutdown_function($that->shutdownFunction);
        });
    }

    public function stop()
    {
        if (false === $this->started) {
            throw new \LogicException('The profiler has not yet been started');
        }

        if (false === $this->running) {
            return;
        }

        $this->running = false;

        $data = xhprof_disable();

        if(function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        $token = sha1(uniqid().microtime());

        $trace = new Trace($token, $data);

        $this->storage->store($trace);

        return $trace;
    }

    public function setShutdownFunction($callback)
    {
        $this->shutdownFunction = $callback;
    }

    public function isRunning()
    {
        return $this->running;
    }
}
