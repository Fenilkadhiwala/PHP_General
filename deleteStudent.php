<?php
include "general.php";

$uid = $_GET['uid'];
$dbName = "projects";
$tableName = "student";
$location = "allStudent.php";

$myObj1 = new GeneralMethods($dbName);

$myObj1->deleteData($tableName, $uid, $location);

?>