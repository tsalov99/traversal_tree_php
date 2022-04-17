<?php

class Tree
{
    /**
     * @var object
     * Holds the passed database connection
     */
    private $connection;

    /**
     * @var string
     * Holds the name of a current set table. Firstly the value is set by the constructor, * but it can be changed with @method setTableName(@var string)
     */
    private $tableName;

    /**
    * Holds fetched data from the last query
    */
    private $data;

    /**
     * @var string
     * Holds the message with selected table and query parameters info
     */
    private $infoMessage = [];

    function __construct($connection, $passedName)
    {
        $this->connection = $connection;
        $this->setTableName($passedName);

    }

    /**
     * Checks whether the given table exists in the passed database
     */
    public function setTableName($passedName) {

        $tableCheckQuery = "SHOW TABLES LIKE '{$passedName}'";
        $result = mysqli_query($this->connection, $tableCheckQuery);

        try {
            if ($result->num_rows === 0) {
                throw new Exception("<h1>Table does not exist</h1>");
            }
            $this->tableName = $passedName;
            $this->infoMessage['selected_table'] = $this->tableName;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAllTreeNodes() {
        $getAllTreeNodesQuery = "SELECT * FROM `{$this->tableName}` WHERE `lft` BETWEEN 2 AND 11 ORDER BY `lft` ASC";
        return mysqli_query($this->connection, $getAllTreeNodesQuery);
    }

    /**
     * @var data is mysqli_result object
     * Creates html table from passed data;
     * For now it works in format: "|parent|title|lft|rgt|" so da data should be structured that way, but it can be modified
     */
    public function createTable($data) {
        $heads = $this->getTableHeads($data);

        echo "<table>";

        // First create table heads with received field names
        echo "<tr>";
        foreach ($heads as $head) {
            echo "<td>$head</td>";
        }
        echo "</tr>";
        // Then create the table body with the rest of data
        while ($row = $data->fetch_row()) {
            echo "<tr>";
            foreach ($row as $field => $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        
    }


    /**
     * Extracts all table field names and returns them in array for the creating table
     */
    private function getTableHeads($data) {
        $heads = [];

        try {
            if (!$data) {
                throw new Error('<h1>Enter a valid data</h1>');
            }
            foreach ($data->fetch_fields() as $field) {
                array_push($heads, $field->name);
            }
            return $heads;
        } catch (Error $e) {
            echo $e->getMessage();
        }
        
    }
}