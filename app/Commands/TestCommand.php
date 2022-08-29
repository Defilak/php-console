<?php

namespace App\Commands;

use Console\Command;
use Console\Parser\ArgumentParser;

class TestCommand extends Command
{
    public function __construct()
    {
        parent::__construct('test');
        $this->setDescription('Описание тестовой команды.');
    }

    public function execute(ArgumentParser $args): int
    {
        print "Called command: {$this->getName()}\n\n";

        print $args;

        return Command::SUCCESS;
    }
}
