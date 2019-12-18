<?php
/*
* 	Export Mysql Data in excel or CSV format using PHP
*	Safikul Islam
*/
 
// Connect to database server and select 
$con=mysqli_connect('localhost','raqib','admin123','moni_enterprises');
 
if (mysqli_connect_errno()) { 
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
// retrive data which you want to export
$query = "SELECT * FROM manual_table ";
$header = '';
$data ='';
 
$export = mysqli_query($con,$query ) or die(mysqli_error($con));
 
// extract the field names for header 
 
while ($fieldinfo=mysqli_fetch_field($export))
{
	$header .= $fieldinfo->name."\t";
}
 
// export data 
while( $row = mysqli_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );
 
if ( $data == "" )
{
    $data = "\nNo Record(s) Found!\n";                        
}
 
// allow exported file to download forcefully
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=manual_status.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
 
?>