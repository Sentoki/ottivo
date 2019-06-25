<?php

require_once __DIR__ . '/vendor/autoload.php';

use application\command\CreateAndFillDatabaseCommand;
use application\command\VacationDaysCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new VacationDaysCommand());
$application->add(new CreateAndFillDatabaseCommand());

$application->run();
