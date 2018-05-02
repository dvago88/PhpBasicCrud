<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hola mundo</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <table class="table">
        <?php
        $count = 1;
        try {
            include("/var/www/Tabla.php");
//            include("/var/www/Main.php");
            if ($_POST["checker"]) {
                $columns = array();
                $tableName = $_POST["tableName"];
                if ($tableName == null) {
                    $tableName = "Mi Tabla";
                }
                while ($_POST["column" . $count] != null) {
                    $val = $_POST["column" . $count];
                    $size = $_POST["size" . $count];
                    if ($size == null) {
                        $size = 20;
                    } else {
                        $size = round($size);
                    }
                    $columns[$val] = $size;
                    $count++;
                }
                $myTable = new Tabla($tableName, $columns, false);
                preConstructTable($myTable);
                postConstructTable($myTable, $tableName);

            } else {
                $arr = array();
                $tableName = $_POST["tableName"];
                $myTable = new Tabla($tableName, 0, true);
                foreach ($myTable->getArrayOfColumns() as $col_name) {
                    if ($col_name != "id" && $col_name != "reg_date") {
                        $arr[$col_name] = $_POST[$col_name];
                    }
                }
                $myTable->addData($arr);
                preConstructTable($myTable);
                echo $myTable->getAllContacts();
                postConstructTable($myTable, $tableName);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        function preConstructTable($myTable)
        {
            echo "<thead><tr>";
            foreach ($myTable->getArrayOfColumns() as $col_name) {
                echo "<th scope='col'>$col_name</th>";
            }
            echo "<th>Agregar</th></tr></thead><tbody>";
        }

        function postConstructTable($myTable, $tableName)
        {
            echo "<form method='post' action='DealWithForm.php'><input type='hidden' name='tableName' value='$tableName'><tr>";

            foreach ($myTable->getArrayOfColumns() as $col_name) {
                if ($col_name != "id" && $col_name != "reg_date") {
                    echo "<td><input name='$col_name' type='text'></td>";
                } else {
                    echo "<td>-</td>";
                }

            }
            echo "<td><button type='submit' class='btn btn-primary'>Agregar</button></td></tr></form></tbody>";
        }
        ?>
    </table>
</div>

</body>