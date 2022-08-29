<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $exec = 'php ' . __DIR__ . '/../bin/php-console';
} else {
    $exec = __DIR__ . '/../bin/php-console';
}

print `$exec`;
print `$exec badcmd`;
print `$exec test`;
print `$exec test2`;
print `$exec test2 {help}`;
print `$exec test {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}`;
