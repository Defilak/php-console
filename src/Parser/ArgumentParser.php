<?php

namespace Console\Parser;

use Exception;

/**
 * Класс для парсинга и доступа к параметрам и аргументом в установленном формате.
 * todo: сделать без str_starts_with.
 */
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

    public function __construct(array $commandLine)
    {
        foreach ($commandLine as $str) {
            if (str_starts_with($str, '{')) {
                $arg = $this->parseArg($str);
                $this->arguments = array_merge($this->arguments, $arg);
            } else if (str_starts_with($str, '[')) {
                $opt = $this->parseOption($str);
                $this->options = array_merge($this->options, $opt);
            } else {
                throw new Exception("Неправильный формат аргументов! $str");
            }
        }
    }

    private function parseArg($str)
    {
        preg_match_all(static::ARGS_REGEX, $str, $matches);
        return $matches[0];
    }

    private function parseOption($str)
    {
        preg_match(static::OPTIONS_REGEX, $str, $matches);
        $key = $matches[1];
        $value = $matches[2];
        if (str_starts_with($value, '{')) {
            $value = $this->parseArg($value);
        }

        return [$key => $value];
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
        $print= "Arguments:\n";
        foreach($this->getArguments() as $arg) {
            $print.= "  - $arg\n";
        }
        
        $print.= "\nOptions:\n";
        foreach($this->getOptions() as $key => $value) {
            $print.= "  - $key\n";
            if(is_array($value)) {
                foreach($value as $value1) {
                    $print.= "    - $value1\n";
                }
            } else {
                $print.= "    - $value\n";
            }
        }
        return $print;
    }
}
