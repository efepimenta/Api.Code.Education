<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/src/bootstrap-doctrine.php';

return ConsoleRunner::createHelperSet($em);
