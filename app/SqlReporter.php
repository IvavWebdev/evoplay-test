<?php

namespace app;

use mysqli;

class SqlReporter implements Reporter
{
    private $file_name;
    private $max_sum;
    private $data = [];

    private $servername = "localhost";
    private $username = "root";
    private $password = "evoplay";
    private $dbname = "evoplay";
    private $port = "33905";

    public function __construct($file_name, $max_sum)
    {
        $this->file_name = str_replace(['-', '.csv'], ['_', ''], $file_name);
        $this->max_sum = $max_sum;
    }

    /**
     * This function get data from MySQL Table,
     * and write transactions to $data, group by user
     */
    public function getDataByUser()
    {
        $conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname,
            $this->port
        );
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT uid, date, sum
                FROM $this->file_name
                WHERE uid IN (
                  SELECT uid
                  FROM $this->file_name
                  GROUP BY uid 
                  HAVING SUM(sum) >= $this->max_sum
                  )
                ORDER BY uid,date";

        $handle = $conn->query($sql);

        $result = [];
        if ($handle->num_rows > 0) {
            while ($data = $handle->fetch_assoc()) {
                if (!isset($result[$data['uid']][$data['date']])) {
                    $result[$data['uid']][$data['date']] = floatval($data['sum']);
                } else {
                    $result[$data['uid']][$data['date']] = $result[$data['uid']][$data['date']] + $data['sum'];
                }
            }
        }
        $conn->close();

        $this->data = $result;
    }

    /**
     * This function processing array $data and will display to screen `uid` and `date`
     * which have total sum more than inputted
     */
    public function processingData()
    {
        foreach ($this->data as $uid => $date_array) {
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
