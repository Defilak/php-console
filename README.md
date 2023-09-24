# Мое консольное приложение
Умеет парсить аргументы и параметры в заданном формате.
Работает как в windows, так и в linux.

В директории app находится тестовое приложение. В src - сама библиотека.
Написано используя PHP 8.1.9.

Команда test выводит список всех переданных ей аргументов.

## Использование:
```
bin/php-console test {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}
```

## Запуск
```
$app = new Console\App();

$app->add(new \App\Commands\TestCommand());
$app->add(new \App\Commands\Test2Command());


try {
    $app->run();
} catch (Exception $ex) {
    print "\e[31m" . $ex->getMessage() . "\n\e[0m";
}

```