<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Console\App();

$app->add(new \App\Commands\TestCommand());
$app->add(new \App\Commands\Test2Command());

$app->run();