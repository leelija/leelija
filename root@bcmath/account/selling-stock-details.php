<?php
include_once("init.php");

$designPart = $_POST['stock_name1'];
$dsgn = explode("-", $designPart);

$design = $dsgn[0];
$part  	= $dsgn[1];


$line = $db->queryUniqueObject("SELECT * FROM selling_stock  WHERE design_no ='$design' AND design_part ='$part'");
$sell=$line->sprice;
$stock_id =$line->id; 

if($line!=NULL)
{

$arr = array ("sell"=>"$sell","guid"=>$stock_id );
echo json_encode($arr);

}
else
{
$arr1 = array ("no"=>"no");
echo json_encode($arr1);

}
?>