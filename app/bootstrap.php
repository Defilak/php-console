<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Console\App();

$app->add(new \App\Commands\TestCommand());
$app->add(new \App\Commands\Test2Command());


try {
    $app->run();
} catch (Exception $ex) {
    print "\e[31m" . $ex->getMessage() . "\n\e[0m";
}
