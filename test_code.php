<?php phpinfo() ?>
<?php


mysql_connect("localhost","root","Gold@2018");
mysql_select_db("moni");

$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";


mysql_query($sql);
echo 333;
?>
