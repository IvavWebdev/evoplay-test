<?php

namespace app;


class CsvReporter implements Reporter
{
    private $file_name;
    private $max_sum;
    private $data = [];

    public function __construct($file_name, $max_sum)
    {
        $this->file_name = $file_name;
        $this->max_sum = $max_sum;
    }

    /**
     *
     */
    public function getDataByUser()
    {
        $result = [];
        if (($handle = fopen($this->file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
                if (!isset($result[$data[0]][$data[1]])) {
                    $result[$data[0]][$data[1]] = floatval($data[2]);
                } else {
                    $result[$data[0]][$data[1]] = $result[$data[0]][$data[1]] + $data[2];
                }
            }
            fclose($handle);
            ksort($result);
            $this->data = $result;
        }
    }

    /**
     *
     */
    public function processingData()
    {
        foreach ($this->data as $uid => $date_array) {
            ksort($date_array);
            $total_sum = 0.00;
            foreach ($date_array as $last_day => $sum) {
                $total_sum = $total_sum + $sum;
                if ($total_sum >= $this->max_sum) {
                    echo $uid . ',' . $last_day . "\n";
                    break;
                }
            }
        }
    }
}