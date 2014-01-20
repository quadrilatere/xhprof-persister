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

interface StorageInterface
{
    /**
     * @param Trace $trace
     */
    public function store(Trace $trace);

    /**
     * @param string $token
     *
     * @return Trace
     */
    public function fetch($token);

    /**
     * @return string[]
     */
    public function getTokens();
} 
