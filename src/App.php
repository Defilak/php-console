<?php

namespace Console;

use Console\Parser\ArgumentParser;
use Exception;

class App
{
    private array $commands = [];

    /**
     * Регистрация команды.
     * Бросает исключение если команда уже существует.
     */
    public function add(Command $cmd)
    {
        $name = $cmd->getName();
        if (isset($this->commands[$name])) {
            throw new Exception("Команда \"$name\" уже существует!");
        }

        $this->commands[$name] = $cmd;
    }

    /**
     * Вывести помощь в stdout.
     * Выводит полный список команд и описание к ним.
     */
    public function help()
    {
        print "Доступные команды:\n";
        foreach ($this->commands as $command) {
            print $command->getHelp() . "\n";
        }
    }

    public function getCommand($name)
    {
        return $this->commands[$name] ?? false;
    }

    public function run()
    {
        // Выписываю первый аргумент - имя скрипта - из массива.
        array_shift($_SERVER['argv']);
        if (count($_SERVER['argv']) == 0) {
            $this->help();
            return;
        }

        $name = array_shift($_SERVER['argv']);
        $command = $this->getCommand($name);
        if(!$command) {
            throw new Exception("Команда \"$name\" не найдена!");
        }

        $args = new ArgumentParser($_SERVER['argv']);
        if ($args->hasArgument('help')) {
            print $command->getHelp();
            return;
        }

        try {
            $code = $command->execute($args);
            exit($code);
        } catch (Exception $ex) {
            print "Ошибка запуска команды \"$name\"!";
            print $ex->getTraceAsString();
        }
    }
}
