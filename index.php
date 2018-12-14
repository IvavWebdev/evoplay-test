<?php

include(__DIR__ . "/vendor/autoload.php");

use app\ReporterFactory;

if (!isset($argv[1]) || !isset($argv[2])) die("Не заданы все аргументы");

$file_name = $argv[1];
if (!file_exists($file_name)) die("Файл $file_name не существует\n");

$max_sum = intval($argv[2]);
if ($max_sum <= 0 || !is_int($max_sum)) die("Вы ввели не верный формат у сумм покупок $max_sum\n");

try {
    $factory = new ReporterFactory();
    if (isset($argv[3]) && $argv[3] === 'sql') {
        $sql_report = $factory->createSqlReport($file_name, $max_sum);
        $sql_report->getDataByUser();
        $sql_report->processingData();
    } else {
        $csv_report = $factory->createCsvReport($file_name, $max_sum);
        $csv_report->getDataByUser();
        $csv_report->processingData();
    }
} catch (Exception $e) {
    echo "\n Error: " . $e->getMessage() . "\n";
}
