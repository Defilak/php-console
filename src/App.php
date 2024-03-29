<?php

namespace Console;

use Console\Parser\WindowsArgumentParser;
use Console\Parser\LinuxArgumentParser;
use Exception;

class App
{
    private string $name;
    private string $version;

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
        print "$this->name v$this->version.\n";
        print "Доступные команды:\n";
        foreach ($this->commands as $command) {
            print '    ' . $command->getHelp();
        }
    }

    public function getCommand($name)
    {
        return $this->commands[$name] ?? false;
    }

    public function run($arguments = false)
    {
        if ($arguments == false) {
            // Выписываю первый аргумент - имя скрипта - из массива.
            array_shift($_SERVER['argv']);
            $arguments = $_SERVER['argv'];
        }

        if (count($arguments) == 0) {
            $this->help();
            return;
        }

        $name = array_shift($arguments);
        $command = $this->getCommand($name);
        if (!$command) {
            throw new Exception("Команда \"$name\" не найдена!");
        }

        /**
         * Выбираю парсер. Я не знал что на линухе такой формат частично работает из коробки.
         * Потому вот.
         */
        $parser = null;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $parser = new WindowsArgumentParser($arguments);
        } else {
            $parser = new LinuxArgumentParser($arguments);
        }

        if ($parser->hasArgument('help')) {
            print $command->getHelp();
            return;
        }

        try {
            $code = $command->execute($parser);
            exit($code);
        } catch (Exception $ex) {
            print "Ошибка запуска команды \"$name\"!";
            print $ex->getTraceAsString();
        }
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set the value of version
     *
     * @param string $version
     *
     * @return self
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
