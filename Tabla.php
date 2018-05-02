<?php

class Tabla
{

    private $servername = "localhost";
    private $username = "daniel";
    private $password = "1234";
    private $dataBaseName = "dbtest";
    private $arrayOfColumns;
    private $tableName;

    function __construct($tableName, $arrayOfColumnsAndSize, $lookForTable)
    {
        if ($lookForTable) {
            $this->arrayOfColumns = $this->getTableByName($tableName);
        } else {
            $this->createTable($tableName, $arrayOfColumnsAndSize);
        }
    }

    private function createTable($tableName, $arrayOfColumnsAndSize)
    {
        $sql = "CREATE TABLE $tableName (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";

        foreach ($arrayOfColumnsAndSize as $col_name => $col_size) {
            $sql .= "$col_name VARCHAR($col_size),";
        }
        $sql .= "reg_date TIMESTAMP)";
        if ($this->makeQuery($sql, true) != -1) {
            $this->arrayOfColumns = array("id");
            $arr = array_keys($arrayOfColumnsAndSize);
            foreach ($arr as $i) {
                array_push($this->arrayOfColumns, $i);
            }
            array_push($this->arrayOfColumns, "reg_date");
            $this->tableName = $tableName;
        } else {
//            echo "Algo salio mal\n";
        }
    }

    private function makeQuery($sql, $needsTheReturnedData)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dataBaseName", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (!$needsTheReturnedData) {

                $r = $conn->exec($sql);
            } else {
                $r = $conn->query($sql);
            }
            $conn = null;
            return $r;
        } catch (PDOException $e) {
            if ($e->getCode() == "42S01") {
                return -2;
            }
            return -1;
        }

    }

    function addData($data)
    {
        $sql = "INSERT INTO $this->tableName(";
        foreach ($data as $col_name => $col_value) {
            $sql .= "$col_name,";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= ") VALUES (";
        foreach ($data as $col_name => $col_value) {
            $sql .= "'$col_value',";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= ")";
        if ($this->makeQuery($sql, false) != -1) {
//            echo "Tabla $this->tableName actualizada correctamente\n";
        } else {
//            echo "No se pudo actualizar la tabla $this->tableName correctamente\n";
        }
    }

    function getContactByName($columnName, $value)
    {
        $sql = "SELECT * FROM $this->tableName WHERE $columnName = '$value'";
        $pdoObject = $this->makeQuery($sql, true);
        foreach ($pdoObject as $i) {
            foreach ($this->arrayOfColumns as $column) {
                echo $i[$column] . "\t";
            }
            echo "\n";
        }
    }

    function getAllContacts()
    {
        $sql = "SELECT * FROM $this->tableName";
        $strReturn = "";
        $pdoObject = $this->makeQuery($sql, true);
        foreach ($pdoObject as $i) {
            $strReturn .= "<tr>";
            foreach ($this->arrayOfColumns as $column) {
                $strReturn .= "<td>" . $i[$column] . "</td>";
            }
            $strReturn .= "</tr>";
        }
        return $strReturn;
    }

    function changeContactInfo($arrOfColAndVal, $arrOfColAndValToChange)
    {
        $sql = "UPDATE $this->tableName SET";
        foreach ($arrOfColAndValToChange as $col_name => $col_value) {
            $sql .= " $col_name ='$col_value',";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= " WHERE";
        foreach ($arrOfColAndVal as $col_name => $col_value) {
            $sql .= " $col_name ='$col_value' AND";
        }
        $sql = substr($sql, 0, strlen($sql) - 3);
        $this->makeQuery($sql, false);
    }

    function deleteContactByFullName($arrOfColAndVal)
    {
        $sql = "DELETE FROM $this->tableName WHERE";
        foreach ($arrOfColAndVal as $col_name => $col_value) {
            $sql .= " $col_name ='$col_value' AND";
        }
        $sql = substr($sql, 0, strlen($sql) - 3);
        $this->makeQuery($sql, false);
    }

    function deleteAllContacts()
    {
        $slq = "TRUNCATE TABLE $this->tableName";
        $this->makeQuery($slq, false);
    }


    public function getArrayOfColumns()
    {
        return $this->arrayOfColumns;
    }

    private function getTableByName($tableName)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dataBaseName", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $conn->prepare("DESCRIBE $tableName");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
            $this->tableName = $tableName;

            $conn = null;
            return $table_fields;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return array();
        }
    }
}

