<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/src/bootstrap-doctrine.php';

return ConsoleRunner::createHelperSet($em);
