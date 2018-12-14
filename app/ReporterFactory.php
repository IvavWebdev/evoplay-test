<?php

namespace app;

class ReporterFactory
{
    public function createCsvReport(string $file_name, int $max_sum): CsvReporter
    {
        return new CsvReporter($file_name, $max_sum);
    }

    public function createSqlReport(string $table_name, int $max_sum): SqlReporter
    {
        return new SqlReporter($table_name, $max_sum);
    }
}