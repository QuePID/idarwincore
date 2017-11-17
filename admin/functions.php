<?php

function export_table_structure($table_name, $conn) {
	$query = "SHOW CREATE TABLE $table_name;";
	$result = mysqli_query($conn, $query) or die ('MySQL Error (Function - export_table_structure): ' . mysqli_error($conn));
	$fh_structures = fopen("$exportdbfile", "a+");
	while ($table_array = mysqli_fetch_array($result)) {
		$line = $table_array[1] . ";" . PHP_EOL;
		fwrite($fh_structures, $line);
		}
	fclose($fh_structures);
}

function idarwincore_delete_indexes($myindexes, $row_color, $conn) {
	$delindexquery = "ALTER TABLE " . $myindexes['TABLE_NAME'] ." DROP INDEX " . $myindexes['INDEX_NAME'];
	$delresults = mysqli_query($conn, $delindexquery)  or die (' MySQL Error (Function - idarwincore_delete_indexes): ' . mysqli_error($conn));
	//echo "<tr><td bgcolor = $row_color><center><strong> $myindexes[TABLE_NAME] </td><td bgcolor = $row_color><center><strong> $myindexes[INDEX_NAME] </strong></center></td></tr>"; 
}

function idarwincore_add_index($tablearray, $fieldarray, $conn) {
	$addindexquery = "ALTER TABLE " . $tablearray . " ADD INDEX " . $fieldarray . "(". $fieldarray . ");";
	$addresults = mysqli_query($conn, $addindexquery) or die ('MySQL Error (Function - idarwincore_add_index): ' . mysqli_error($conn));
	echo "<center><strong><h3>Index added to " . $tablearray . " ON Field " .  $fieldarray ." </h3></strong></center>";
}

function load_dwca_table($filename, $query, $tablename, $conn) {
	if (file_exists($filename)) {
		//send the query string to MySQL server that causes the loading of the occurrences.csv into the occurrences table and check for any mysql errors
		$result = mysqli_query($conn, $query) or die ('MySQL Error (Function - load_dwca_table) : (loading ' . $tablename . ' records): ' . mysqli_error($conn));
		echo "<h3><center><strong><i>" . $tablename . "</i> Table</i> was populated.</i></strong></center></h3>";
		//flush the buffers so that the above echo statement appears immediately and not later.
		ob_flush();
		flush();
	} else {
		echo "<h3><center><strong>Skipping the creation of <i>" . $tablename . "</i> Table</i> as the file does not exist within the DWCA folder</h3>";
		//flush the buffers so that the above echo statement appears immediately and not later.
		ob_flush();
		flush();
	}
}

function dwca_drop_table($tablename, $conn) {
	$droptablequery = "DROP TABLE " . $tablename . " ;";
	$droptableresult = mysqli_query($conn, $droptablequery) or die ('MySQL Error (Function - dwca_drop_table): ' . mysqli_error($conn));
}

function truncate_mysql_table($tablename, $conn) {
	$truncatetablequery = "TRUNCATE TABLE " . $tablename . " ;";
	$truncatetableresult = mysqli_query($conn, $truncatetablequery) or die ('MySQL Error (Function - truncate_mysql_table): ' . mysqli_error($conn));
}

?>