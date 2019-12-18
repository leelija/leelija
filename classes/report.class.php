<?php 
/**
*	This class is going to work with all orders associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		Feb 10, 2015
*	@version	1.0
*	@copyright	MIS
*	
*	@email		safikulislamwb@gmail.com
* 
*/

class Report
{

 /* sum of current products all data */
	/*
		$dno	= design no
	*/
	
	 public function CurtstockSum($dno){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_quantity` FROM `stock_details` where design_no='$dno' 
	 AND modified_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_quantity'];
     }
     return $temp_arr;  
     }
	 
	 
	 /* sum of Due Rozelle order        */
	/*
		$dno	= design no
	*/
	
	 public function DueRozOrder($dno){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( due_quantity ) AS `count_due` FROM `rozelle_order_dtl` where design_no='$dno'
    AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()	 ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_due'];
     }
     return $temp_arr;  
     }
	
	 /* display Due Rozelle order        */
	/*
		$dno	= design no
	*/
	
	
	 public function showRozDueOrd($dno){
   
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM rozelle_order_dtl where design_no = '$dno' AND due_quantity != 0 
	 AND
	  target_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() order by order_date desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }

	  /* display Due Rozelle order        */
	/*
		$dno	= design no
	*/
	
	
	 public function showCurrentStock($dno){
   
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_details where design_no = '$dno' AND quantity != 0 AND
	  modified_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 

}