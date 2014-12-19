<?php
	// Input validatie functie, maakt eventueel in een html formulier geinjecteerde code onschadelijk door
	// tags te veranderen in html entiteiten, quotes worden geescaped
	function validate($data){
	  global $_db;
		$data = trim($data);
		$data = $_db->real_escape_string($data);
		return $data;
	}
?>