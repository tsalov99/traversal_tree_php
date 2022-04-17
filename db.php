<?php

class Database
{
    private $host;
    private $user;
    private $pass;
    private $name;
    public  $conn;

    function __construct($host, $user, $pass, $name)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->connect();
    }

    protected function connect() {
        try {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
            if ($conn->connect_error !== NULL) {
                throw new Exception('Connection failed');
            }
            $this->conn = $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}