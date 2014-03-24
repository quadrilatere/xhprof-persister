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

require_once __DIR__.'/../src/Profiler.php';
require_once __DIR__.'/../src/Trace.php';
require_once __DIR__.'/../src/Storage/FileStorage.php';
require_once __DIR__.'/../src/Storage/StorageInterface.php';
require_once __DIR__.'/../src/Storage/StorageException.php';

use XhProf\Storage\FileStorage;

$profiler = new Profiler();
$profiler->setShutdownFunction(function (Trace $trace) {
    $storage = new FileStorage();
    $storage->store($trace);
});
$profiler->start();