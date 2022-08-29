<?php

namespace Console\Parser;

/**
 * Класс для парсинга и доступа к параметрам и аргументом в установленном формате.
 */
abstract class ArgumentParser
{
    protected array $arguments = [];
    protected array $options = [];

    protected function addArgument($arg)
    {
        $this->arguments[] = $arg;
    }

    /**
     * Если параметр один, он добавляется как значение. Иначе как массив значений.
     */
    protected function addOption(string $key, mixed $value)
    {
        if (isset($this->options[$key]) && !is_array($this->options[$key])) {
            $this->options[$key] = [$this->options[$key]];
        } else {
            $this->options[$key][] = $value;
        }
    }

    /**
     * Возвращает true если данный аргумент был передан.
     */
    public function hasArgument($name): bool
    {
        return in_array($name, $this->arguments);
    }

    /**
     * Возвращает данные опции если она была передана. Иначе false.
     */
    public function getOption($name): mixed
    {
        return $this->options[$name] ?? false;
    }

    /**
     * Возвращает массив со всеми переданными аргументами.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Возвращает массив со всеми переданными опцями и их параметры.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function __toString()
    {
        $print = "Arguments:\n";
        foreach ($this->getArguments() as $arg) {
            $print .= "  - $arg\n";
        }

        $print .= "\nOptions:\n";
        foreach ($this->getOptions() as $key => $value) {
            $print .= "  - $key\n";
            if (is_array($value)) {
                foreach ($value as $value1) {
                    $print .= "    - $value1\n";
                }
            } else {
                $print .= "    - $value\n";
            }
        }
        return $print;
    }
}
