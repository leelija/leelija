<?php
include_once("init.php");

$line = $db->queryUniqueObject("SELECT * FROM buyer_details  WHERE company='".$_POST['stock_name1']."'");
$address=$line->party_address;
$contact1=$line->party_phone;
$contact2=$line->gst_no;

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