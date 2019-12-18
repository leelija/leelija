<?php
//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'root');
define ('DBPASS','');
define ('DBNAME','moni_enterprises');

//LET'S INITIATE CONNECT TO DB
$connection = mysql_connect(DBSERVER, DBUSER, DBPASS) or die("Can't connect to server. Please check credentials and try again");
$result = mysql_select_db(DBNAME) or die("Can't select database. Please check DB name and try again");

//CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];
    $sql = mysql_query ("SELECT party_name, party_id FROM party WHERE party_name LIKE '%{$query}%' OR party_id LIKE '%{$query}%'");
	$array = array();
    while ($row = mysql_fetch_array($sql)) {
        $array[] = array (
            'label' => $row['party_name'].', '.$row['party_id'],
            'value' => $row['party_name'],
        );
    }
    //RETURN JSON ARRAY
    echo json_encode ($array);
	//print_r($array);exit;
}

$line = $db->queryUniqueObject("SELECT * FROM party  WHERE party_name='".$_POST['stock_name1']."'");
$address=$line->customer_address;
$contact1=$line->customer_contact1;
$contact2=$line->customer_contact2;

if($line!=NULL)
{

$arr = array ("address"=>"$address","contact1"=>"$contact1","contact2"=>"$contact2");
echo json_encode($arr);

}
else
{
$arr1 = array ("no"=>"no");
echo json_encode($arr1);

}

?>