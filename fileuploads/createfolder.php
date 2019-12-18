<?php

$curdir = getcwd();
if(mkdir($curdir ."/images" , 0777)){
	echo "successful";
	}
	else{
		echo "Failed";
	
	}
?>