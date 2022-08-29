<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Console\Parser\ArgumentParser;

array_shift($argv);
$parser = new ArgumentParser($argv);

print_r($parser->getArguments());
print_r($parser->getOptions());


exit;
$part = "[methods={create,update,delete}]";
preg_match('/\[([^\]]\w+)=(.+)\]/', $part, $matches);
print_r($matches);

exit;
array_shift($argv);

$array = [];
foreach ($argv as $part) {
    if (str_starts_with($part, '{')) {
        preg_match_all('/[^\,\s{][^\,]\w[^\,\s}]*/', $part, $matches);
        //var_dump($matches);
        $array = array_merge($array, $matches[0]);
    }
}
print_r($array);

exit;