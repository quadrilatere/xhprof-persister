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

use XhProf\Context\ContextFactory;

final class Profiler
{
    private $flags;
    private $options;
    private $started = false;
    private $running = false;
    private $shutdownFunction;

    /**
     * @param StorageInterface $storage
     * @param null $flags
     * @param array $options
     */
    public function __construct($flags = null, array $options = array())
    {
        $this->flags   = $flags ?: (XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        $this->options = array_merge_recursive(
            array('ignored_functions' => array(
                'XhProf\\Profiler::stop',
                'xhprof_disable',
                'XhProf\Profiler::XhProf\{closure}',
                'XhProf\Profiler::executeShutdown',
            )),
            $options
        );
    }

    /**
     * @throws \LogicException
     */
    public function start()
    {
        if (true === $this->running) {
            throw new \LogicException('The profiler has already been started');
        }

        $this->started = true;
        $this->running = true;

        $that = $this;

        register_shutdown_function(function() use ($that) {
            register_shutdown_function(array($that, 'executeShutdown'));
        });

        xhprof_enable($this->flags, $this->options);
    }

    /**
     * @return Trace
     * @throws \LogicException
     */
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

        $context = ContextFactory::create();

        return new Trace($token, $data, $context);
    }

    public function executeShutdown()
    {
        if ($trace = $this->stop()) {
            call_user_func_array($this->shutdownFunction, array($trace));
        }
    }

    /**
     * @param callable $callback
     *
     * @throws \InvalidArgumentException
     */
    public function setShutdownFunction($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('The shutdown function should be a callable');
        }

        $this->shutdownFunction = $callback;
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return $this->running;
    }
}
