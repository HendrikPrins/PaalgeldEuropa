<?php

require("inc/config.php");

$query = $_SESSION["query"][$_POST["download_query"]];
if ($_POST["column_names"]) {
	$column_names = $_POST["column_names"];
}
else {
	$column_names = null;
}
get_csv($query, $_db, $column_names);

function get_csv($query, $_db, $column_names){
	// queryresult 1
	$query_result = $_db->query($query);

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	if ($column_names == null) {
		// get fields information
		$finfo = $query_result->fetch_fields();

		// new array for the column names
		$column_names = array();

		// collecting all column names into an array
		foreach ($finfo as $val) {
		    $column_names[] = $val->name;
		}
	}
	
	// basic csv file, with column names in first row
	fputcsv($output, $column_names, ";");
	
	// queryresult 1
	$rows = $_db->query($query);

	// loop over the rows, outputting them to csv file
	// every row in the csv is same as row in sql result ($query_result)
	while ($row = $rows->fetch_assoc()) {
		fputcsv($output, $row, ";");
	}

	// now CSV file is done creating
}
?>