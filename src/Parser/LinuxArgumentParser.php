<?php

namespace Console\Parser;

use Exception;

/**
 * Парсер командной строки для работы в линухе.
 */
class LinuxArgumentParser extends ArgumentParser
{
    /**
     * Парсит строку с или без фигурных скобок.
     */
    const ARG_REGEX = '/([^\{]\w+[^\}])/';

    /**
     * Парсит строку вида ключ=значение, 
     * но только если она в квадратных скобках.
     */
    const OPTION_REGEX = '/\[(\w+)=(.+)\]/';

    public function __construct($commandLine)
    {
        foreach($commandLine as $str) {
            // Порядок условий здесь важен!
            if(preg_match(static::OPTION_REGEX, $str, $matches)) {
                [, $key, $value] = $matches;
                $this->addOption($key, $value);
            } else if (preg_match(static::ARG_REGEX, $str, $matches)) {
                [, $arg] = $matches;
                $this->addArgument($arg);
            } else {
                throw new Exception("Неправильный формат аргументов! $str");
            }
        }
    }
}
