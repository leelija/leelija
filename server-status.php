<?php
//connect

$url            = "localhost";               
$user           = "root";                                              
$password       = "Gold@2018";                                                 
$db             = "moni_enterprises";    

$link = mysqli_connect($url, $user, $password, $db);

// check connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//perform simple query
if ($result = mysqli_query($link, "SELECT 1")) {
    if(mysqli_num_rows($result)) echo "SUCCESS";
    mysqli_free_result($result);
}

//close
mysqli_close($link);
?>
