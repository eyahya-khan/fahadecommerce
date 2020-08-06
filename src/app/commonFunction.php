<?php
function redirect($location){
    header("Location: {$location}");
    exit;
}

function checkLogginSession() {
	if (!isset($_SESSION['email'])) {
	    redirect('login.php?mustLogin');
	} 
}

function debug($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

?>

