<?php

class GeneralMethods
{
    public $con;
    public $dbName;

    public $lh = "localhost";
    public $un = "root";
    public $ps = "";



    function __construct($dbName)
    {

        $this->dbName = $dbName;
        $this->con = new mysqli($this->lh, $this->un, $this->ps, $this->dbName);

        if (!$this->con) {
            header("location:index.php");
            die(mysqli_error($this->con));
        }
    }

    public function loginVerification($dataArr, $keyArr, $arrValues, $tableName)
    {
        $columns = implode(",", $keyArr);


        $quotedValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, $arrValues);

        $values = implode(",", $quotedValues);



        $columnsArray = explode(",", $columns);
        $valuesArray = explode(",", $values);

        $query = "SELECT * FROM $tableName WHERE $columnsArray[0]=$valuesArray[0] AND $columnsArray[1]=$valuesArray[1]";

        $result = mysqli_query($this->con, $query);

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $uid = $row['uid'];

            header("location:dashboard.php?err=$uid");
        } else {
            header("location:index.php?err=failed");
        }


    }


    public function insertData($dataArr, $keyArr, $arrValues, $tableName)
    {
        $columns = implode(",", $keyArr);


        $quotedValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, $arrValues);

        $values = implode(",", $quotedValues);



        $query = "INSERT INTO $tableName($columns) VALUES($values)";

        $result = mysqli_query($this->con, $query);

        if ($result) {
            header("location:dashboard.php?err=succ");
        } else {
            header("location:dashboard.php?err=failed");
        }
    }

    public function updateData($dataArr, $keyArr, $arrValues, $tableName, $uid)
    {
        $columns = implode(",", $keyArr);


        $quotedValues = array_map(function ($value) {
            return "'" . $value . "'";
        }, $arrValues);

        $values = implode(",", $quotedValues);




        $setValues = array();
        for ($i = 0; $i < count($dataArr); $i++) {

            if (!empty($quotedValues[$i])) {
                $setValues[] = $keyArr[$i] . " = " . $quotedValues[$i];
            }
        }
        $setStatement = implode(", ", $setValues);

        $query = "UPDATE $tableName SET $setStatement WHERE uid=$uid";

        print_r($setStatement);


        $result = mysqli_query($this->con, $query);

        if ($result) {
            header("location:dashboard.php?err=succ");
        } else {
            header("location:dashboard.php?err=failed");
        }
    }

    public function deleteData($dataArr, $keyArr, $arrValues, $tableName, $uid)
    {
        $query = "DELETE FROM $tableName WHERE uid=$uid";

        $result = mysqli_query($this->con, $query);

        if ($result) {
            header("location:dashboard.php?err=deleted");
        } else {
            header("location:dashboard.php?err=NotDeleted");
        }
    }




}

?>