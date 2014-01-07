XhProf persister
================

[![SensioLabs Insight](https://insight.sensiolabs.com/projects/5acc0d66-b224-4471-9dc2-e69e6d040fae/mini.png)](https://insight.sensiolabs.com/projects/5acc0d66-b224-4471-9dc2-e69e6d040fae "SensioLabs Insight")
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/badges/quality-score.png?s=4cc1f926cfc0f4c39596a0f6fa6dcd3b4f71a2ff)](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/ "Scrutinizer Quality Score")
[![Build Status](https://travis-ci.org/csarrazi/xhprof-persister.png?branch=master)](https://travis-ci.org/csarrazi/xhprof-persister "Build status")
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/csarrazi/xhprof-persister/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

Installation
------------

    composer require csa/xhprof-persister:dev-master

Usage
-----

Create any type of PHP web or console application, then use the following in your code

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Storage\FileStorage;
use XhProf\Profiler;

$storage = new FileStorage();
$profiler = new Profiler($storage);

$profiler->start();

// Your code

// You may either use $profiler->stop() at the end of the code you wish to test,
// or let the xhprof-persister manage it, as it registers a shutdown function automatically.
$trace = $profiler->stop();
```

Todo
----

* Add support for graphing (in progress)
* Add a prepend script for Apache
* Many more things

License
-------

This library is under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source
code.

