<?php

class aDatabase
{
    public $connection;

    function __construct($host, $user, $pass, $name) {
        
        $this->connect($host, $user, $pass, $name);
    }

    private function connect($host, $user, $pass, $name) {
        try {
            mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
            $this->connection = new mysqli($host, $user, $pass, $name);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


}