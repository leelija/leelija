<?php 
/**
*	This class is going to work with all Employee associated with category. 
*
*	@author		Safikul Islam
*	@date		nov 15, 2016
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/

require_once('encrypt.inc.php'); 
require_once('utility.class.php');

class Employee extends Utility
{

	#####################################################################################################
	#
	#										Add Employee Records 
	#
	#####################################################################################################
	
	/**
	*	Add a new Employee Records in employee table.
	*
	*	@param
	*			$emp_id					Employee Identification no.
	*			$emp_type_id			Employee type
	*			$emp_name				Employee Name
	*			$emp_mobile			    Emp mobile Number
	*			$email					Employee Email
	*			$password				Employee Login password
	*			$fname				    Emp First Name
	*			$lname					Employee Last Name
	*			$guardian     		    Guardian Name
	*			$marital_status			marital status
	*			$gender					Gender
	
	*			$dob					Date of Birth
	*			$photo_img				emp photo
	*			$emp_name				Employee Name
	*			$emp_mobile			    Emp mobile Number
	*			$email					Employee Email
	*			$password				Employee Login password
	*			$fname				    Emp First Name
	*			$lname					Employee Last Name
	*			$guardian     		    Guardian Name
	*			$marital_status			marital status
	*			$gender					Total Amount 
	
	*		
	*			
	*
	*	@return int
	*/
	function addEmployee($emp_type_id,$emp_name, $emp_mobile,$email,$adhar_no, $password, $fname, $lname, $guardian,$marital_status,
	$gender,$dob,$photo_img,$adhar_img,$votar_img,$factory,$work_under,$worker_type,$sort_order,$acc_verified,
	$verified_by,$verified_on,$status,$total_income,$added_by)
	
	{
		$emp_type_id			= mysql_real_escape_string(trim($emp_type_id));
		$emp_name	        	=	trim($emp_name);
		//$emp_mobile			= mysql_real_escape_string(trim($emp_mobile));
		$emp_mobile				= addslashes(trim($emp_mobile));
		$email			   		=	mysql_real_escape_string(trim($email));
		$adhar_no		  		=	mysql_real_escape_string(trim($adhar_no));
		$password		  		=	mysql_real_escape_string(trim($password));
		$fname			 		=	mysql_real_escape_string(trim($fname));
		$lname					=	mysql_real_escape_string(trim($lname));
		$guardian		     	=	mysql_real_escape_string(trim($guardian));
		$marital_status		   	=	mysql_real_escape_string(trim($marital_status));
		$gender					=	mysql_real_escape_string(trim($gender));
		$dob					=	mysql_real_escape_string(trim($dob));
		$photo_img				=	mysql_real_escape_string(trim($photo_img));
		
		$adhar_img			   	= mysql_real_escape_string(trim($adhar_img));
		$votar_img			   	=	mysql_real_escape_string(trim($votar_img));
		$factory		  		=	mysql_real_escape_string(trim($factory));
		$work_under			 	=	mysql_real_escape_string(trim($work_under));
		$worker_type			=	mysql_real_escape_string(trim($worker_type));
		$sort_order		     	=	mysql_real_escape_string(trim($sort_order));
		$acc_verified		   	=	mysql_real_escape_string(trim($acc_verified));
		$verified_by			=	mysql_real_escape_string(trim($verified_by));
		$verified_on			=	mysql_real_escape_string(trim($verified_on));
		$status					=	mysql_real_escape_string(trim($status));
		$total_income			=	mysql_real_escape_string(trim($total_income));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		
		$x_security 			=  md5_encrypt($password,USER_PASS);
		//satement to insert in employee table
		$insert		=   "INSERT INTO employee
						(emp_type_id,emp_name, emp_mobile, email,adhar_no, password, fname,lname,guardian,marital_status,gender,
						dob,photo_img,adhar_img,votar_img,factory,work_under,worker_type,sort_order,acc_verified,verified_by,
						verified_on,status,total_income,added_by,added_on,entry_time,exit_time)
							
						VALUES
						('$emp_type_id','$emp_name', '$emp_mobile', '$email','$adhar_no', '$x_security','$fname', 
							'$lname','$guardian','$marital_status','$gender','$dob','$photo_img','$adhar_img',
							'$votar_img','$factory','$work_under','$worker_type','$sort_order','$acc_verified',
							'$verified_by','$verified_on','$status','$total_income','$added_by', now(),'08:30:00','20:00:00')
							
						";	
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$emp_id	= mysql_insert_id();
		
		//return primary key
		return $emp_id;

	}//eof
	
	// Add Employee address	
	function addEmpAddress($emp_id,$address1,$address2,$address3,$town,$postal_code,$country)
	{
		$emp_id			   	=	mysql_real_escape_string(trim($emp_id));
		$address1	        =	trim($address1);
		$address2			=	mysql_real_escape_string(trim($address2));
		$address3			=	mysql_real_escape_string(trim($address3));
		$town		     	=	mysql_real_escape_string(trim($town));	
		$postal_code		=	mysql_real_escape_string(trim($postal_code));
		$country		    =	mysql_real_escape_string(trim($country));
		//satement to insert in employee address table
		$insert		=   "INSERT INTO emp_address
						(emp_id,address1,address2,address3,town,postal_code,country)
							
						VALUES
						('$emp_id','$address1','$address2','$address3','$town','$postal_code','$country')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$emp_id	= mysql_insert_id();
		
		//return primary key
		return $emp_id;

	}//eof	
		
	
	
	#####################################################################################################
	#
	#										Edit Employee Details
	#
	#####################################################################################################
	
	
	/**
	*	Edit Employee Record
	*	
	*	@param	
	*			$id			Employee unique identity
	*			
	*/
	function editEmpRecord($id,$emp_type_id, $fname, $lname,$emp_mobile,$modified_by)
	{
		//statement
		$sql	 = "UPDATE employee 
					SET 
					emp_type_id    	= '$emp_type_id' ,
					fname    		= '$fname' ,	
					lname    		= '$lname' ,
					emp_mobile    	= '$emp_mobile' ,
					modified_by    	= '$modified_by' 
					WHERE emp_id	= '$id'";
			
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	/**
	*	Add Employee Salary
	*	
	*	@param	
	*			$id			Employee unique identity
	*			
	*/
	function addEmpSalary($id, $emp_salary, $sal_added_by)
	{
		//statement
		$sql	 = "UPDATE employee 
					SET 
					emp_salary    	= '$emp_salary' ,
					sal_added_by    = '$sal_added_by' 		
					WHERE emp_id	= '$id'";
			
		//execute query		
		$query  = mysql_query($sql);
		//echo $sql.mysql_error();exit;
	}//eof
	
	
	
	
	#####################################################################################################
	#
	#										Delete Employee Records
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a Employee Records permanently
	*
	*	@param
	*			$eid			Employee id
	*
	*	@return null
	*/
	function delEmployee($eid)
	{
		//delete from Employee
		$delete1 = "DELETE FROM employee WHERE emp_id='$eid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	

	#####################################################################################################
	#
	#										Display Employee Records
	#
	#####################################################################################################
	
	/*
	*	This funcion will return all the Employee Id
	*	
	*	@param
	*			$orderby		Order by clause in runtime
	*			$orderType		Order type, either ascending or descending
	*
	*	@return array
	*/
	function getAllEmployee($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT emp_id FROM employee";
		}
		else
		{
			//statement
			$select	= "SELECT emp_id FROM employee
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['emp_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	

	/**
	*	Get the data associated with a Employee based upon the primary key
	*
	*	@param
	*			$eid		Employee id
	*
	*	@return array				
	*/
	function showEmployee($eid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM employee
				   WHERE emp_id	= '$eid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->emp_id,			//0
					$result->emp_type_id,		//1
					$result->emp_name,			//2
					$result->emp_mobile,		//3
					$result->email,				//4
					$result->password,			//5
					$result->fname,				//6
					$result->lname,				//7
					$result->guardian,			//8
					$result->marital_status,	//9
					$result->gender,			//10
					$result->dob,				//11
					$result->photo_img,			//12
					$result->adhar_img,			//13
					$result->votar_img,			//14
					$result->factory,			//15
					$result->work_under,		//16
					$result->worker_type,		//17
					$result->sort_order,		//18
					$result->acc_verified,		//19
					$result->verified_by,		//20
					$result->verified_on,		//21
					$result->status,			//22
					$result->total_income,		//23
					$result->added_by,			//24
					$result->added_on,			//25
					$result->modified_by,		//26
					$result->modified_on,		//27
					$result->adhar_no,			//28
					$result->emp_salary			//29

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a Employee based upon the Adhar no.
	*
	*	@param
	*			$Adhar		Adhar No
	*
	*	@return array				
	*/
	function showEmployeeAdhar($Adhar)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM employee
				   WHERE adhar_no	= '$Adhar'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->emp_id,			//0
					$result->emp_type_id,		//1
					$result->emp_name,			//2
					$result->emp_mobile,		//3
					$result->email,				//4
					$result->password,			//5
					$result->fname,				//6
					$result->lname,				//7
					$result->guardian,			//8
					$result->marital_status,	//9
					$result->gender,			//10
					$result->dob,				//11
					$result->photo_img,			//12
					$result->adhar_img,			//13
					$result->votar_img,			//14
					$result->factory,			//15
					$result->work_under,		//16
					$result->worker_type,		//17
					$result->sort_order,		//18
					$result->acc_verified,		//19
					$result->verified_by,		//20
					$result->verified_on,		//21
					$result->status,			//22
					$result->total_income,		//23
					$result->added_by,			//24
					$result->added_on,			//25
					$result->modified_by,		//26
					$result->modified_on,		//27
					$result->adhar_no,			//28
					$result->emp_salary			//29

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	/*	
	*	Display employee address
	*/	

	function showEmpAddress($eid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM emp_address
				   WHERE emp_id	= '$eid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->emp_id,			//0
					$result->address1,			//1
					$result->address2,			//2
					$result->address3,			//3
					$result->town,		//4
					$result->postal_code,		//5
					$result->country		//6

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	// Display employee all data in a array
	 public function EmployeeDis(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM employee order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 // Display all sample employee data in a array 
	 public function EmployeeAllData($etid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM employee where emp_type_id ='$etid' order by emp_name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	  // Display all employee data in a array 
	 public function AllEmployeeData($eid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM employee where emp_id ='$eid' order by emp_name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 // Display all employee address data
	 public function EmpAddressData($eid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_address where emp_id ='$eid'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	####################################################################################################################
	#
	#													Employee Type
	#	
	####################################################################################################################
	
	/**
	*	Create a new category. Note that the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	August 21, 2016
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Employee Name
	*			$url				Customized url name for the website
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function addEmpType($parentId, $employee_type, $emp_type_code, $remarks)
	{
		//get the var
		$emp_type_code 		= mysql_real_escape_string($emp_type_code);
		$remarks			= mysql_real_escape_string($remarks);
		
		//statement
		$insert  = "INSERT INTO emp_type 
					(parent_id, employee_type, emp_type_code, remarks, added_on)
					VALUES
					('$parentId', '$employee_type', '$emp_type_code', '$remarks', now())";
			
		//execute query		
		$query   = mysql_query($insert);
		//echo $insert.mysql_error(); exit;
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof


	
	/**
	*	Get EmployeeType data associated with its key.
	*
	*	@return array
	*/
	function getEmpTypeData($emp_type_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM emp_type WHERE emp_type_id='$emp_type_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->emp_type_id,			//0
					$result->parent_id,				//1
					$result->employee_type,			//2
					$result->emp_type_code,			//3
					$result->images,				//4
					$result->added_on,				//5
					$result->modified_on			//6
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	/**
	*	Retrieve all customer type id
	*	@param	$id		customer type id
	*	@return array
	*/
	function getChildEmpTypeId($parent_id)
	{
		$sql	= "SELECT emp_type_id FROM emp_type WHERE parent_id = '$parent_id'";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->emp_type_id;
			}
		}
		return $data;
	}//eof
	
	
	/**
	*	Retrieve all employee type id
	*	@param	$id		Employee type id
	*	@return array
	*/
	function getAllParentEmpTypeId()
	{
		$sql	= "SELECT emp_type_id FROM emp_type WHERE parent_id = 0";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->emp_type_id;
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all employee type id
	*	@param	$id		employee type id
	*	@return array
	*/
	function getAllEmployeeTypeId()
	{
		$sql	= "SELECT emp_type_id FROM emp_type";
		//execute the query
		$query	= mysql_query($sql);
		
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->emp_type_id;
			}
		}
		return $data;
	}//eof
	
	
		/**
	*	Populate a dropdown list of category, if there is any selected category, it seletec it first.
	*	This function retrieve the data in recursive manner.
	*
	*	The another version of this function is availble in Utility class. The selection part works when
	*	a user already selected a field.
	*
	*	@param
	*			$id			Parent id of the category
	*			$level		Depth of the category
	*			$selected	Selected category by user, if not any then it will produce the normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its name in the 
	*						parent section so that the user won't add the child as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	
	
	function employeeTypeDropDown($id,$level,$selected,$type,$cat_id, $table)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id='$id' AND emp_type_id 
			<> $cat_id ORDER BY employee_type ";
		}
		else
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id= $id ORDER BY employee_type ";
		}
		
		$query  = mysql_query($select);
		
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['emp_type_id'];
			$parent_id 	= $result['parent_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			if($parent_id == 0)
			{
				echo "<option style='font-weight:bold' value='".$new_cat_id."' class='menuText' ".$select_string.">".
				str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['employee_type'].
				"</option>";
			}
			else
			{
				echo "<option value='".$new_cat_id."' class='menuText' ".$select_string.">".
				str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['employee_type'].
				"</option>";
			}
			
			$this->employeeTypeDropDown($new_cat_id,$level+1,$selected,$type,$cat_id, $table);
		}
	}//eof
	
	
	 
	function duplicateEmpType($parent_id, $employee_type, $type_id, $table)
	{
		if($type_id == (int)0)
		{
			$select = "SELECT * FROM ".$table." WHERE  parent_id = '$parent_id' 
						AND employee_type = '$employee_type'";
		}
		else
		{
			$select = "SELECT * FROM  ".$table." 
					WHERE  parent_id 	= '$parent_id' 
					AND employee_type = '$employee_type'
					AND emp_type_id	<> '$type_id'";
		}
		
		$query  = mysql_query($select);
		$msg = '';
		if(mysql_num_rows($query) == 1 )
		{
			$msg = 'ER004';
		}
		else
		{
			$msg = 'SU004';
		}
		
		return $msg;
	}//eof 
	
	
	// Display employee type in a array where parent id are equal 
	/*
	* 	
	*/
	 public function samEmpType(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_type where parent_id = 15 OR parent_id = 25 order by employee_type asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	
	
	
	// Display employee name in a array
	/*
	* 	where employee post in fashion designer and asst. fashion designer
	*/
	 public function designerName(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM employee where emp_type_id = 16 order by emp_name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Display employee name in a array
	/*
	* 	where employee post in computer operator 
	*/
	 public function getComopName($factory){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM employee where emp_type_id IN(23,32,33) AND factory = '$factory' order by emp_name asc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	
	
	
	 
	####################################################################################################################
	#
	#													Employee Payment
	#	
	####################################################################################################################
	 
	 
	// Apply for payment approved	
	function addPayApprved($emp_id,$detailsofpay,$pay_amount,$cheque_no,$payment_type,$apply_by,$checked_by,
	$apply_date,$pay_approved,$approved_date,$payment_date,$pay_status)
	{
		$emp_id			   			=	mysql_real_escape_string(trim($emp_id));
		$detailsofpay	        	=	trim($detailsofpay);
		$pay_amount					=	mysql_real_escape_string(trim($pay_amount));
		$cheque_no				   	=	mysql_real_escape_string(trim($cheque_no));
		$payment_type		     	=	mysql_real_escape_string(trim($payment_type));	
		$apply_by		     		=	mysql_real_escape_string(trim($apply_by));
		$checked_by		     		=	mysql_real_escape_string(trim($checked_by));
		$apply_date				   	=	mysql_real_escape_string(trim($apply_date));
		$pay_approved		     	=	mysql_real_escape_string(trim($pay_approved));	
		$approved_date		     	=	mysql_real_escape_string(trim($approved_date));
		$payment_date		     	=	mysql_real_escape_string(trim($payment_date));
		$pay_status		     		=	mysql_real_escape_string(trim($pay_status));
		
		//satement to insert in employee address table
		$insert		=   "INSERT INTO emp_payment
						(emp_id,detailsofpay,pay_amount,cheque_no,payment_type,apply_by,checked_by,payment_by,apply_date,pay_approved
						,approved_date,payment_date,pay_status)
							
						VALUES
						('$emp_id','$detailsofpay','$pay_amount','$cheque_no','$payment_type','$apply_by','$checked_by',
						'',now(),'$pay_approved','$approved_date','$payment_date','$pay_status')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$payment_id	= mysql_insert_id();
		
		//return primary key
		return $payment_id;

	}//eof	
		
	
	//Payment Approved
	function PaymentApproved($payment_id, $checked_by,$pay_approved)
	
	{
		$payment_id			   	   =	mysql_real_escape_string(trim($payment_id));
		$checked_by	        	   =	trim($checked_by);
		$pay_approved			   = mysql_real_escape_string(trim($pay_approved));

		//update payment
		$edit  = "UPDATE emp_payment
				SET
				checked_by		 		= '$checked_by',
				pay_approved			= '$pay_approved',
				approved_date			= now()
				WHERE
				payment_id 			= '$payment_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	//Payment Complete
	function PaymentComp($payment_id, $payment_by,$pay_status)
	
	{
		$payment_id			   	   =	mysql_real_escape_string(trim($payment_id));
		$payment_by	        	   =	trim($payment_by);
		$pay_status			   = mysql_real_escape_string(trim($pay_status));

		//update payment
		$edit  = "UPDATE emp_payment
				SET
				payment_by		 		= '$payment_by',
				pay_status				= '$pay_status',
				payment_date			= now()
				WHERE
				payment_id 			= '$payment_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
			
		
	// Display employee voucher all data in a array
	 public function EmpVoucherList(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_payment order by apply_date desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	 /**
	*	Get the data associated with a Employee payment based upon the payment id.
	*
	*	@param
	*			$pid		Payment
	*
	*	@return array				
	*/
	function showVoucherDtls($pid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM emp_payment
				   WHERE payment_id	= '$pid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->payment_id,			//0
					$result->emp_id,		//1
					$result->detailsofpay,			//2
					$result->pay_amount,		//3
					$result->cheque_no,				//4
					$result->payment_type,			//5
					$result->apply_by,				//6
					$result->checked_by,				//7
					$result->payment_by,			//8
					$result->apply_date,	//9
					$result->pay_approved,			//10
					$result->approved_date,				//11
					$result->payment_date,			//12
					$result->pay_status			//13

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	####################################################################################################################
	#
	#													Employee Salary
	#	
	####################################################################################################################
	 
	/*=============   Count duty Month wise=================*/
	 public function monthlyDuty($aadharNo,$month,$year){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM attendance_list where aadhaar_no ='$aadharNo' AND amonth ='$month' AND ayear ='$year'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 
	 /*=============   Count duty day wise=================*/
	 public function eDayDuty($aadharNo,$tday){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM attendance_list where aadhaar_no ='$aadharNo' AND added_on = '$tday' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	
	####################################################################################################################
	#
	#													Employee Payment Book
	#	
	####################################################################################################################
	 
	// Add data in payment book	
	function addPaymentBook($emp_id,$total_duty,$due_amount,$advance_amount,$esalary,$eoffer,$efood,$current_income,$current_payment,$remarks,$added_by)
	{
		$emp_id			   			=	mysql_real_escape_string(trim($emp_id));
		$total_duty	        		=	trim($total_duty);
		$due_amount					=	mysql_real_escape_string(trim($due_amount));
		$advance_amount				=	mysql_real_escape_string(trim($advance_amount));
		$esalary		     		=	mysql_real_escape_string(trim($esalary));	
		$eoffer		    			=	mysql_real_escape_string(trim($eoffer));
		$efood		     			=	mysql_real_escape_string(trim($efood));
		$current_income		     	=	mysql_real_escape_string(trim($current_income));	
		$current_payment		    =	mysql_real_escape_string(trim($current_payment));
		$remarks		     		=	mysql_real_escape_string(trim($remarks));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		
		
		//satement to insert in employee payment book table
		$insert		=   "INSERT INTO emp_payment_book
						(emp_id,total_duty,due_amount,advance_amount,esalary,eoffer,efood,current_income,current_payment,remarks,added_on,added_by)
							
						VALUES
						('$emp_id','$total_duty','$due_amount','$advance_amount','$esalary','$eoffer','$efood','$current_income','$current_payment','$remarks',
						now(),'$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$pb_id	= mysql_insert_id();
		
		//return primary key
		return $pb_id;

	}//eof	
	
	
	//Update Employee Payment Book
	function UpdateEmpPayBook($pb_id, $total_duty,$due_amount,$advance_amount,$esalary,$current_income,$current_payment,$modified_by)
	{
		$total_duty			   	   =	mysql_real_escape_string(trim($total_duty));
		$due_amount			   	   =	mysql_real_escape_string(trim($due_amount));
		$advance_amount			   = mysql_real_escape_string(trim($advance_amount));
		$esalary			   	   = mysql_real_escape_string(trim($esalary));
		$current_income			   =	mysql_real_escape_string(trim($current_income));
		$current_payment		   =	mysql_real_escape_string(trim($current_payment));
		$modified_by			   = mysql_real_escape_string(trim($modified_by));
		//update Sample db
		$edit  = "UPDATE emp_payment_book
				SET
				total_duty		 		= '$total_duty',
				due_amount		 		= '$due_amount',
				advance_amount			= '$advance_amount',
				esalary					= '$esalary',
				current_income			= '$current_income',
				current_payment			= '$current_payment',
				modified_by				= '$modified_by',
				modified_on				= now()
				WHERE
				pb_id 				= '$pb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	//Update Employee food 
	function UpdateEmpFood($pb_id, $efood,$current_income,$modified_by)
	{
		$efood			   	   	=	mysql_real_escape_string(trim($efood));
		$current_income			=	mysql_real_escape_string(trim($current_income));
		$modified_by			= mysql_real_escape_string(trim($modified_by));
		//update Sample db
		$edit  = "UPDATE emp_payment_book
				SET
				efood		 			= '$efood',
				current_income			= '$current_income',
				modified_by				= '$modified_by',
				modified_on				= now()
				WHERE
				pb_id 				= '$pb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	//Update Employee Offer 
	function UpdateEmpOffer($pb_id, $eoffer,$current_income,$modified_by)
	{
		$eoffer			   	   	=	mysql_real_escape_string(trim($eoffer));
		$current_income			=	mysql_real_escape_string(trim($current_income));
		$modified_by			= mysql_real_escape_string(trim($modified_by));
		//update Sample db
		$edit  = "UPDATE emp_payment_book
				SET
				eoffer		 			= '$eoffer',
				current_income			= '$current_income',
				modified_by				= '$modified_by',
				modified_on				= now()
				WHERE
				pb_id 				= '$pb_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	 // Display employee payment book all data in a array
	 public function EmpPayBookData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_payment_book order by pb_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	 /**
	*	Get the data associated with a Employee payment book based upon the payment id.
	*
	*	@param
	*			$pb_id		Payment book id
	*
	*	@return array				
	*/
	function showEmpBookData($pb_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM emp_payment_book
				   WHERE pb_id	= '$pb_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->pb_id,				//0
					$result->emp_id,			//1
					$result->total_duty,		//2
					$result->due_amount,		//3
					$result->advance_amount,	//4
					$result->esalary,			//5
					$result->eoffer,			//6
					$result->efood,				//7
					$result->current_income,	//8
					$result->current_payment,	//9
					$result->remarks,			//10
					$result->added_on,			//11
					$result->added_by,			//12
					$result->modified_on,		//13
					$result->modified_by		//14
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	 /**
	*	Get the data associated with a Employee payment book based upon the employee id.
	*
	*	@param
	*			$emp_id		Employee id
	*
	*	@return array				
	*/
	function showEmpPayBookData($emp_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM emp_payment_book
				   WHERE emp_id	= '$emp_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->pb_id,				//0
					$result->emp_id,			//1
					$result->total_duty,		//2
					$result->due_amount,		//3
					$result->advance_amount,	//4
					$result->esalary,			//5
					$result->eoffer,			//6
					$result->efood,				//7
					$result->current_income,	//8
					$result->current_payment,	//9
					$result->remarks,			//10
					$result->added_on,			//11
					$result->added_by,			//12
					$result->modified_on,		//13
					$result->modified_by		//14
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	####################################################################################################################
	#
	#													Employee Payment Book Details
	#	
	####################################################################################################################
	 
	
	// Add data in payment	details
	function addPaymentDtls($pb_id,$total_duty,$payable,$payment_via,$pay_amount,$ctno,$remarks,$added_by)
	{
		$pb_id			   			=	mysql_real_escape_string(trim($pb_id));
		$total_duty					=	mysql_real_escape_string(trim($total_duty));
		$payable		     		=	mysql_real_escape_string(trim($payable));
		$payment_via				=	mysql_real_escape_string(trim($payment_via));
		$pay_amount		     		=	mysql_real_escape_string(trim($pay_amount));
		$ctno		     			=	mysql_real_escape_string(trim($ctno));	
		$remarks		    		=	mysql_real_escape_string(trim($remarks));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		
		
		//satement to insert in employee payment details table
		$insert		=   "INSERT INTO emp_payment_dtls
						(pb_id,total_duty,payable,payment_via,pay_amount,ctno,remarks,added_on,added_by)
							
						VALUES
						('$pb_id','$total_duty','$payable','$payment_via','$pay_amount','$ctno','$remarks',now(),'$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$payment_id	= mysql_insert_id();
		
		//return primary key
		return $payment_id;

	}//eof	
	
	 // Display employee payment book details all data in a array
	 public function EmpPayBookDtsData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_payment_dtls order by payment_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	  /**
	*	Get the data associated with a Employee payment dtls based upon the payment id.
	*
	*	@param
	*			$payment_id		Payment id
	*
	*	@return array				
	*/
	function showEmpPayDtlsData($payment_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM emp_payment_dtls
				   WHERE 	payment_id = '$payment_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->payment_id,		//0
					$result->pb_id,				//1
					$result->total_duty,		//2
					$result->payable,			//3
					$result->payment_via,		//4
					$result->pay_amount,		//5
					$result->ctno,				//6
					$result->remarks,			//7
					$result->added_on,			//8
					$result->added_by,			//9
					$result->modified_on,		//10
					$result->modified_by		//11
					);
		}
		
		//return the data
		return $data;
		
	}//eof
	####################################################################################################################
	#
	#													Employee Duty Salary
	#	
	####################################################################################################################
	 
	
	// Add data in emp Duty Salary
	function addDutySalary($pb_id,$total_duty,$salary,$adv_withdraw,$remarks,$added_by)
	{
		$pb_id			   			=	mysql_real_escape_string(trim($pb_id));
		$total_duty					=	mysql_real_escape_string(trim($total_duty));
		$salary		     			=	mysql_real_escape_string(trim($salary));
		$adv_withdraw				=	mysql_real_escape_string(trim($adv_withdraw));
		$remarks		    		=	mysql_real_escape_string(trim($remarks));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		
		
		//satement to insert in emp_duty_salary table
		$insert		=   "INSERT INTO emp_duty_salary
						(pb_id,total_duty,salary,adv_withdraw,remarks,added_on,added_by)
							
						VALUES
						('$pb_id','$total_duty','$salary','$adv_withdraw','$remarks',now(),'$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sal_id	= mysql_insert_id();
		
		//return primary key
		return $sal_id;

	}//eof	
	
	 // Display employee duty salary all data in a array
	 public function EmpDutySalaryData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_duty_salary order by sal_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	####################################################################################################################
	#
	#													Employee Advance 
	#	
	####################################################################################################################
	 
	
	// Add data in employee advance table
	function addEmpAdv($pb_id,$adv_amount,$remarks,$added_by)
	{
		$pb_id			   			=	mysql_real_escape_string(trim($pb_id));
		$adv_amount					=	mysql_real_escape_string(trim($adv_amount));
		$remarks		    		=	mysql_real_escape_string(trim($remarks));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		
		
		//satement to insert in emp_advance table
		$insert		=   "INSERT INTO emp_advance
						(pb_id,adv_amount,remarks,added_on,added_by)
							
						VALUES
						('$pb_id','$adv_amount','$remarks',now(),'$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$adv_id	= mysql_insert_id();
		
		//return primary key
		return $adv_id;

	}//eof	
	
	 // Display employee duty salary all data in a array
	 public function EmpAdvData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_advance order by adv_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	 
	/**
	*	Get Employee Advance data associated with its key.
	*
	*	@return array
	*/
	function getEmpAdvance($adv_id)
	{
		$data	= array();
		
		$select = "SELECT * FROM emp_advance WHERE adv_id='$adv_id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->adv_id,			//0
					$result->pb_id,				//1
					$result->adv_amount,		//2
					$result->remarks,			//3
					$result->added_on,			//4
					$result->added_by,			//5
					$result->modified_on		//6
					);
		}
		
		//return the value
		return $data;
	}//eof 
	 
	####################################################################################################################
	#
	#													Employee Attendance
	#	
	####################################################################################################################
	 
	 /**
	*	Validate the employee against its Aadhaaar Card.
	*
	*	@param	
	*			$adhar_no 		user input for Aadhaaar Number
	*			$dbAadhaar    	database Aadhaaar column name
	*			$table      	table name to query
	*
	*	@return NULL
	*/
	function empAttendance($adhar_no, $dbAadhaar,$attDate,$attDateTime, $table)
	{
		
		$attDate			   			=	mysql_real_escape_string(trim($attDate));
		$attDateTime					=	mysql_real_escape_string(trim($attDateTime));
		
		//echo $attDate;exit;
		
		$select     = "SELECT * FROM ".$table." WHERE ".$dbAadhaar." = '$adhar_no'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		
		$selectD     = "SELECT * FROM emp_type WHERE emp_type_id = ".$result['emp_type_id']."";
		$queryD      = mysql_query($selectD);
		$deptDtls    = mysql_fetch_array($queryD);
		//if employee found
		if(mysql_num_rows($query) > 0)
		{
			$dbaadhar	    = $result[$dbAadhaar];
			
			//if Aadhaaar Number match
			if($adhar_no == $dbaadhar)
			{
				$now 		= new \DateTime('now');
				$month 		= $now->format('M');
				$year 		= $now->format('Y');
				
				$select1     = "SELECT * FROM attendance_list WHERE aadhaar_no = '$adhar_no' AND added_on = '$attDate'";
				$query1      = mysql_query($select1);
				$result1 	= mysql_fetch_array($query1);
				//echo $select1.mysql_error();exit;	
					if(mysql_num_rows($query1) > 0)
						{
							//statement to update attendance_list
							$update = "UPDATE attendance_list SET exit_time = '$attDateTime', exit_attendance = 1
									   WHERE aadhaar_no = '$adhar_no' AND added_on = '$attDate'";
							//execute query
							mysql_query($update); 
							
							$entrTime 				= date_create($attDateTime);
							$currTime 				= date_format($entrTime,"H:i:s");
							
							$time2 					= '00:07:00';
							$timeEx  				= strtotime($currTime) - strtotime($time2) + strtotime('00:00:00');
							$timeext 				= date("H:i:s", $timeEx);
							//echo $currTime;exit;
							$to_time 				= strtotime($result['exit_time']);
							$from_time 				= strtotime($timeext);
							//$dtime 				=  round(abs($to_time - $from_time) / 60,2);
							$exdtime 				=  round(($to_time - $from_time) / 60,2);
								
						/*if($result['emp_salary'] > 9500){
							// ==== Send SMS =======
							$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
							$apisender = "MoniEn";
							$msgs ="".$result['emp_name']." (".$deptDtls['employee_type'].")are exit.Time:$timeext Phone No: ".$result['emp_mobile']."";
							$number = 9836199258;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
							//echo $num;exit;
							$mss = rawurlencode($msgs);   //This for encode your message content                 		
							$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
							 //echo $url;
							 $ch=curl_init($url);
							 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							 curl_setopt($ch,CURLOPT_POST,1);
							 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
							 $data = curl_exec($ch);
						}*/
						
						//	$attDetails 	= 
						if($exdtime > 0 ){	
							// ==== Send SMS =======
							$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
							$apisender = "MoniEn";
							$msgs ="".$result['emp_name']." (".$deptDtls['employee_type'].")are exit after $exdtime minute ago.Time:$currTime. Phone No: ".$result['emp_mobile']."";
							$number = 9836664554;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
							//echo $num;exit;
							$mss = rawurlencode($msgs);   //This for encode your message content                 		
							 
							$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
												 
							 //echo $url;
							 $ch=curl_init($url);
							 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							 curl_setopt($ch,CURLOPT_POST,1);
							 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
							 $data = curl_exec($ch);
							}
							//echo "Success!...";
							//header("Location: ".$_SERVER['PHP_SELF']."?msg=".$result['emp_name']." Your Exit Time has been Successfully Added...");	
							echo "".$result['emp_name']." Your Exit Time has been Successfully Added...";
						}
					else{
							//echo $attDate;exit;
							$insert = "INSERT INTO attendance_list (aadhaar_no, entry_attendance, exit_attendance,entry_time,
							exit_time,amonth,ayear,added_on,added_by)
							VALUES ('$adhar_no', '1', '0','$attDateTime','','$month','$year','$attDate','')";
							//execute quary
							mysql_query($insert);
							//echo $insert.mysql_error();exit;
							
							$entrTime 				= date_create($attDateTime);
							$currTime 				= date_format($entrTime,"H:i:s");
							
							$time2 					= '00:12:00';
							$time  					= strtotime($currTime) - strtotime($time2) + strtotime('00:00:00');
							$timef 					= date("H:i:s", $time);
							//echo $currTime;exit;
							$to_time 				= strtotime($result['entry_time']);
							$from_time 				= strtotime($timef);
							//$dtime 				=  round(abs($to_time - $from_time) / 60,2);
							$dtime 					=  round(($from_time - $to_time) / 60,2);
							
							$cTime 					= date_format($entrTime,"H");
							
						if($result['emp_salary'] > 9500){
							// ==== Send SMS =======
							$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
							$apisender = "MoniEn";
							$msgs ="".$result['emp_name']." (".$deptDtls['employee_type'].")are entry .Time:$timeext Phone No: ".$result['emp_mobile']."";
							$number = 9836664554;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
							//echo $num;exit;
							$mss = rawurlencode($msgs);   //This for encode your message content                 		
							$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
							 //echo $url;
							 $ch=curl_init($url);
							 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							 curl_setopt($ch,CURLOPT_POST,1);
							 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
							 $data = curl_exec($ch);
						}
							
							//$cTime = 19;
							//echo $cTime;exit;
						if($cTime >=19){
							//echo "here";
						}
						else{
							//echo date("H:i:s", $dtime);exit;
							if($dtime > 0 ){
								//echo "late...";
								// ==== Send SMS =======
								$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
								$apisender = "MoniEn";
								$msg ="".$result['emp_name']."You are $dtime minute late...";
								$num = $result['emp_mobile'];    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
								//echo $num;exit;
								$ms = rawurlencode($msg);   //This for encode your message content                 		
								 
								$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
													 
								 //echo $url;
								 $ch=curl_init($url);
								 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								 curl_setopt($ch,CURLOPT_POST,1);
								 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
								 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
								 $data = curl_exec($ch);
								 
								 // ==== Send SMS =======
								$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
								$apisender = "MoniEn";
								$msgs ="".$result['emp_name']." (".$deptDtls['employee_type'].") are $dtime minute late to join duty.Time:$currTime .Phone No: ".$result['emp_mobile']."";
								$number = 9836664554;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
								//echo $num;exit;
								$mss = rawurlencode($msgs);   //This for encode your message content                 		
								 
								$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$number.'&text='.$mss.'&route=1';
													 
								 //echo $url;
								 $ch=curl_init($url);
								 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								 curl_setopt($ch,CURLOPT_POST,1);
								 curl_setopt($ch,CURLOPT_POSTFIELDS,"");
								 curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
								 $data = curl_exec($ch);
								
							}	
						else{
						
							// ==== Success Send SMS =======
						
							}
						}	
						echo "".$result['emp_name']." Your Entry Time has been Successfully Added...";
						//header("Location: ".$_SERVER['PHP_SELF']."?msg=".$result['emp_name']." Your Entry Time has been Successfully Added...");

						}
				
			}
			else
			{
				echo "invalid Aadhaaar No.";
				//header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhaaar No.");
			}
		}
		else
		{
			echo "invalid Aadhaaar No.";
			//header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhaaar No.");
		} 
		
	}//eof
	
	
	/**
	*	Validate the employee against its Aadhar and password.
	*
	*	@param	
	*			$login 		user input for Aadhar no
	*			$password 	user input for password
	*			$dbLogin    database login column name
	*			$dbPass     database password column name
	*			$table      table name to query
	*
	*	@return NULL
	*/
	function validEmployee($login, $password, $bdLogin, $dbPass, $table)
	{
		
		$select     = "SELECT * FROM ".$table." WHERE ".$bdLogin." = '$login'";
		$query      = mysql_query($select);
		$result 	= mysql_fetch_array($query);
		
		
		//if user found
		if(mysql_num_rows($query) > 0)
		{
			$dbpass	    = $result[$dbPass];
			$x_password = md5_decrypt($dbpass,USER_PASS);
			//echo $x_password;exit;
			
			
			//if password match
			if($password == $x_password)
			{
				//user session
				$_SESSION[STAFF_SESS]      = $login;
				
				//name session
				$_SESSION['adminuser']  = $result['fname']." ".$result['lname'];
				
				//email session
				$_SESSION['adminemail'] = $result['email'];
				
				//statement to update login detail
				$update = "UPDATE employee SET last_logon = now(), no_logon = no_logon + 1
						   WHERE adhar_no = '$login'";
				
				//execute query
				mysql_query($update);
				
				$session_id	= md5(session_id());
				
				//get the page name
				if(isset($_SESSION['goToAdm']))
				{
					$pageName	= $_SESSION['goToAdm'];
					$id_var		= $_SESSION['id_var'];
					$id_var_val	= $_SESSION['id_var_val'];
				}
				else
				{
					$pageName	= 'dashboard';
					$id_var		= '';
					$id_var_val	= 0;
				}
				
				//forward page
				$forwardPage	= $this->buildForwardPage($pageName, 'php');
				
				//url
				$url	= $forwardPage.'?session_id='.$session_id."&".$id_var."=".$id_var_val;
				
				//forwarding 
				header("Location: ".$url);
				
			}
			else
			{
				header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhar or password");
			}
		}
		else
		{
			header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhar or password");
		} 
		
	}//eof Employee login class
	
	
	
	
	
	// Display employee Attendance all data in a array
	 public function EmpAttendanceData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM attendance_list order by att_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Display employee Attendance all data month wise in a array
	 public function EmpAttpermonth($month){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM attendance_list where amonth = '$month'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
	/**
	*	Search Employee status keyword
	*
	*	@param
	*			$keyword	Keyword to search
	*
	*	@return array
	*/
	function getEmployeeSearch($keyword)
	{
		$keyword = mysql_real_escape_string($keyword);
		
		if($keyword == '')
		{
			$sql =  "SELECT emp_id FROM employee ";
		}
		else
		{
			$sql = "SELECT emp_id
					FROM   employee
					WHERE (emp_id LIKE '%$keyword%' OR
						   emp_name LIKE '%$keyword%' OR
						   emp_mobile LIKE '%$keyword%' OR
						   email LIKE '%$keyword%' OR
						   adhar_no LIKE '%$keyword%' OR
						   fname LIKE '%$keyword%' 
						  ) ;";		
		}
		 $query = mysql_query($sql);
		 $data = array();
		 //echo $sql.mysql_error();exit;
		 //echo "<p>".$sql."</p>";echo "data";
		 while($result = mysql_fetch_object($query))
		 {
			$data[] = $result->emp_id;
		 } 
		 if(!$query)
		 {
			return mysql_error();
		 }
		 else
		 {
			return $data;
		 }
	}//eof
	
	
	
	####################################################################################################################
	#
	#													Employee Offer 
	#	
	####################################################################################################################
	
	// Add data in employee Offer table
	function addEmpOffer($emp_id,$offer,$purpose,$added_by)
	{
		$emp_id			   			=	mysql_real_escape_string(trim($emp_id));
		$offer						=	mysql_real_escape_string(trim($offer));
		$purpose		    		=	mysql_real_escape_string(trim($purpose));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		//satement to insert in emp_offer_dtls table
		$insert		=   "INSERT INTO emp_offer_dtls
						(emp_id,offer,purpose,added_by,added_on)
							
						VALUES
						('$emp_id','$offer','$purpose','$added_by',now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;

	}//eof	
	
	
	
	####################################################################################################################
	#
	#													Employee food 
	#	
	####################################################################################################################
	
	// Add data in employee food table
	function addEmpFood($emp_id,$no_of_food,$fmonth,$added_by)
	{
		$emp_id			   			=	mysql_real_escape_string(trim($emp_id));
		$no_of_food					=	mysql_real_escape_string(trim($no_of_food));
		$fmonth		    			=	mysql_real_escape_string(trim($fmonth));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		//satement to insert in emp_food table
		$insert		=   "INSERT INTO emp_food
						(emp_id,no_of_food,fmonth,added_by,added_on)
							
						VALUES
						('$emp_id','$no_of_food','$fmonth','$added_by',now())
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;

	}//eof	
	
	// Display employee payment transaction all data in a array
	 public function EmpFoodData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_food order by id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	####################################################################################################################
	#
	#													Employee Transaction
	#	
	####################################################################################################################
	
	// Add data in employee transaction table
	function addEmpTran($emp_id,$purpose,$tran_amount,$prev_amount,$curr_amount,$added_by)
	{
		$emp_id			   			=	mysql_real_escape_string(trim($emp_id));
		$purpose					=	mysql_real_escape_string(trim($purpose));
		$tran_amount		    	=	mysql_real_escape_string(trim($tran_amount));
		$prev_amount				=	mysql_real_escape_string(trim($prev_amount));
		$curr_amount				=	mysql_real_escape_string(trim($curr_amount));
		$added_by				   	=	mysql_real_escape_string(trim($added_by));
		//satement to insert in emp_tran table
		$insert		=   "INSERT INTO emp_tran
						(emp_id,purpose,tran_amount,prev_amount,curr_amount,added_by,added_on)
						VALUES
						('$emp_id','$purpose','$tran_amount','$prev_amount','$curr_amount','$added_by',now())
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$id	= mysql_insert_id();
		//return primary key
		return $id;

	}//eof	
	
	
	 // Display employee payment transaction all data in a array
	 public function EmpTranData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM emp_tran order by id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	
}	//eoc

?>