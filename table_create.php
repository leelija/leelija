<?php
$servername = "localhost";
$username = "safikul";
$password = "monimonimoni2030";
$dbname = "moni_enterprises";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS `photo_gallery` (
  `photo_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `design_no` varchar(15) NOT NULL DEFAULT '0',
  `title` varchar(128) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `thumb_image` varchar(255) NOT NULL DEFAULT '',
  `is_default` enum('Y','N') NOT NULL DEFAULT 'Y',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`photo_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>