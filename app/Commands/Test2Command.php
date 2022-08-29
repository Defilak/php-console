<?php

namespace App\Commands;

use Console\Command;
use Console\Parser\ArgumentParser;

class Test2Command extends Command
{
    public function __construct()
    {
        parent::__construct('test2');
        $this->setDescription('Описание тестовой команды 2.');
    }

    public function execute(ArgumentParser $args): int
    {
        print "я команда\n";

        return Command::FAILTURE;
    }
}
