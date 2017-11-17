<?php
include("connect.php");
include("common.php");
include("header.php");
include("functions.php");

$query_tbl_list = "SHOW TABLES FROM $dbname;";
$result = mysqli_query($conn, $query_tbl_list) OR DIE("MySQL Error") . mysqli_error($conn);

$cdbase = "CREATE DATABASE IF NOT EXISTS " . $dbname  . ";"  . PHP_EOL;
$usedbase = "USE $dbname" . ";"  . PHP_EOL;

$fh_structures = fopen("$exportdbfile", "w");
fwrite($fh_structures, $cdbase);
fwrite($fh_structures, $usedbase);
fclose($fh_structures);

$numtables = mysqli_num_rows($result);

echo "<center><h2><strong>$numtables tables to be exported</strong></h2></center><br>";

while($tables = mysqli_fetch_array($result)) {
export_table_structure($tables[0], $conn);
}
echo "<center><strong><h2>Finished!</h2></strong></center><br>"
?>