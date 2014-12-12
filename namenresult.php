<?php
require_once('inc/config.php');
beginPage('Paalgeld Europa - Names', true, 'Research based on names');

//Initialize variables
    $inputName = $_POST['inputName'];
    $searchExact = $_POST['searchExact'];
    if ($searchExact == "TRUE"){
        $searchExact = TRUE;
    }
    else {
        $searchExact = FALSE;
    }
    $inputStartDate = $_POST['inputStartDate'];
    $inputEndDate = $_POST['inputEndDate'];
    $inputPlace = $_POST['inputPlace'];
    $departurePlace = $_POST['departurePlace'];

    echo $departurePlace;
    

endPage();
?>
