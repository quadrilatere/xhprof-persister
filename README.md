XhProf persister
================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/27110f23-d1eb-4916-8b81-f6b522801b66/mini.png)](https://insight.sensiolabs.com/projects/27110f23-d1eb-4916-8b81-f6b522801b66)
[![Build Status](https://travis-ci.org/csarrazi/xhprof-persister.png?branch=master)](https://travis-ci.org/csarrazi/xhprof-persister)

Installation
------------

    composer require csa/xhprof-persister:1.0.*@dev

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