<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/debug.php';
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../config/config.php';

use App\Model\Util;

$util = new Util();
$util->clearLog();

require_once __DIR__ . '/../src/routing.php';
