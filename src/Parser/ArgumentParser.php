<?php

namespace Console\Parser;

use Exception;

class ArgumentParser
{
    /**
     * Находит все что текст через запятую, в фигурных скобках. 
     * Пробелы не поддерживает. Кавычки тоже.
     */
    const ARGS_REGEX = '/[^\,\s{][^\,]\w[^\,\s}]*/';

    /**
     * Находит key=value в квадратных скобках.
     */
    const OPTIONS_REGEX = '/\[([^\]]\w+)=(.+)\]/';

    private array $arguments = [];
    private array $options = [];

    public function __construct($commandLine)
    {
        $arguments = [];
        $options = [];
        foreach ($commandLine as $part) {
            if (str_starts_with($part, '{')) {
                $arg = $this->parseArg($part)[0];
                $arguments = array_merge($arguments, $arg);

            } else if (str_starts_with($part, '[')) {
                $option = $this->parseOption($part);
                $options = array_merge($options, $option);

            } else {
                throw new Exception("Неправильный формат аргументов! $part");
            }
        }

        $this->arguments = $arguments;
        $this->options = $options;
    }

    private function parseArg($str)
    {
        preg_match_all(static::ARGS_REGEX, $str, $matches);
        return $matches;
    }

    private function parseOption($str)
    {
        preg_match(static::OPTIONS_REGEX, $str, $matches);
        $key = $matches[1];
        $value = $matches[2];
        if(str_starts_with($value, '{')) {
            $value = $this->parseArg($value);
        }

        return [$key => $value];
    }

    public function getArgument($name)
    {
        return $this->arguments[$name] ?? false;
    }

    public function getOption($name)
    {
        return $this->arguments[$name] ?? false;
    }

    /**
     * Get the value of arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get the value of options
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function __toString()
    {
        //todo
    }
}
