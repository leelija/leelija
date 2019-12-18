<?php
include_once("init.php");
$line = $db->queryUniqueObject("SELECT * FROM vendor_dtls  WHERE vcompany='".$_POST['stock_name1']."'");
$address=$line->vendor_address;
$contact1=$line->vendor_contact;
$contact2=$line->vendor_gst;
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