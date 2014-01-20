XhProf persister
================

[![Latest Stable Version](https://poser.pugx.org/csa/xhprof-persister/v/stable.png)](https://packagist.org/packages/csa/xhprof-persister "Latest Stable Version")
[![Latest Unstable Version](https://poser.pugx.org/csa/xhprof-persister/v/unstable.png)](https://packagist.org/packages/csa/xhprof-persister "Latest Unstable Version")
[![SensioLabs Insight](https://insight.sensiolabs.com/projects/5acc0d66-b224-4471-9dc2-e69e6d040fae/mini.png)](https://insight.sensiolabs.com/projects/5acc0d66-b224-4471-9dc2-e69e6d040fae "SensioLabs Insight")
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/badges/quality-score.png?s=4cc1f926cfc0f4c39596a0f6fa6dcd3b4f71a2ff)](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/ "Scrutinizer Quality Score")
[![Code Coverage](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/badges/coverage.png?s=4692c069ebf55516ee21c31ea1e69ae1112e0e98)](https://scrutinizer-ci.com/g/csarrazi/xhprof-persister/ "Code Coverage")
[![Build Status](https://travis-ci.org/csarrazi/xhprof-persister.png?branch=master)](https://travis-ci.org/csarrazi/xhprof-persister "Build status")

Installation
------------

    composer require csa/xhprof-persister:dev-master

Usage
-----

Create any type of PHP web or console application, then use the following in your code:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Profiler;

$profiler = new Profiler();

$profiler->start();

// Your code

// You may either use $profiler->stop() at the end of the code you wish to do something with the trace,
// or let xhprof-persister manage it, as it registers a shutdown function automatically.
$trace = $profiler->stop();
```

You can easily store a trace using any storage class implementing ```StorageInterface```:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Profiler;
use XhProf\Storage\MemoryStorage;

$profiler = new Profiler();
$profiler->start();
$trace = $profiler->stop();
$storage = new MemoryStorage();
$storage->store($trace);

```

You may also override the profiler's shutdown function:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Storage\FileStorage;
use XhProf\Profiler;
use XhProf\Trace;

$profiler = new Profiler();

$callback = function (Trace $trace) {
    $storage = new FileStorage();
    $storage->store($trace);

    // Do whatever you want with the trace
};

$profiler->setShutdownFunction($callback);
$profiler->start();
```

If you are using the file storage implementation, you may fetch a trace simply by using the fetch method. You may also
fetch the list of available tokens:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use XhProf\Storage\FileStorage;

$storage = new FileStorage();
echo implode(PHP_EOL, $storage->getTokens());
```

Todo
----

* Improve the prepend script.
* Persist context (for both Cli or request contexts).

License
-------

This library is under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source
code.

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/csarrazi/xhprof-persister/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
