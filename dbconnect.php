<?php

    include("logindata.php");
	
	$connection = new mysqli($host,$user,$password,$db);
	if($connection)
		//echo "Verbunden";

?>