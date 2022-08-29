<?php

namespace Console\Parser;

use Exception;

/**
 * Парсер командной строки для работы в винде.
 */
class WindowsArgumentParser extends ArgumentParser
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
}
