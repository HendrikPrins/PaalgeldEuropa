<?php
	// Input validatie functie, maakt eventueel in een html formulier geinjecteerde code onschadelijk door
	// tags te veranderen in html entiteiten, quotes worden geescaped
	function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		}
?>