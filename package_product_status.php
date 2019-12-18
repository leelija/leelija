<?php 
session_start();
//include_once('checkSession.php');
require_once("_config/connect.php"); 
require_once("includes/constant.inc.php"); 
require_once("includes/content.inc.php"); 

require_once("classes/order.class.php");
//require_once("classes/sample.class.php");
require_once("classes/plan.class.php");
require_once("classes/customer.class.php");


require_once("classes/error.class.php"); 
require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php");

/* INSTANTIATING CLASSES */
$orders 		= new Orders();
$error 			= new Error();
$utility		= new Utility();
$uMesg 			= new MesgUtility();
$customer			= new Customer();

//$sample			= new Sample();
$plan			= new Plan();

$Design			= $utility->returnGetVar('Design',0);//$Design -> order id 
$oid  			= $Design;

$orderDtl       = $orders->showOrders($oid);
$orderColorDtl	= $orders->ordersDtlDisplay($oid);

//echo $Design;
//$planDetail = $plan->showPlanDtl($oid);

//echo $Design;

if( (isset($_GET['txtStatus'])))
{
	$txtStatus		= $_GET['txtStatus'];
	//$Design			= $_GET['Design'];
	//echo $Design;
	if($txtStatus=="Dyeing") 
		{
		$planDetail = $plan->showPlanDtl($oid,'Dyeing');
    	?>
		
		
		 <div class="cl"></div>
							
	<!--	<label>Employee Id<span class="orangeLetter">*</span></label>
        <input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
		size="15" />  -->
		
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(8);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}
				echo "</select>";//?>
		</div>
		<div class="cl"></div>
		
		<div >
			<label>Fabric Category<span class="orangeLetter">*</span></label>							
			<select name="txtFabricCat" type="text" id="txtFabricCat" class="text_box_large">
				<option value="Dyeable">Dyeable</option>
				<option value="MillDye">MillDye</option>
			</select>
		</div>
		<div class="cl"></div>
		
		<tr>
			<label>Select No. Fabric Type</label>
			<!--<td align="left" class="menuText">Select No. Type </td>-->
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,30);
			$arr_label	= range(1,30);
			?>
			  <select name="selNum" id="selNum" onchange="return getFabricType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showFabricType"></div>
		
		 
		 <div class="cl"></div>
		 
		 
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" value=""
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25"  />
          <div class="cl"></div>
		
      
	  <!--=======================Hand field=================================================-->
		<?php
		}
		elseif($txtStatus=="Hand")
		{
		$planDetail = $plan->showPlanHand($oid);
		?>
		
		<div class="cl"></div>
							
			<div >
			<label>Work Type<span class="orangeLetter">*</span></label>							
			<select name="txtWorkType" type="text" id="txtWorkType" class="text_box_large">
				<option value="PureHand">PureHand</option>
				<option value="HighLight">HighLight</option>
				<option value="AllWork">AllWork</option>
			</select>	
			</div>
		<div class="cl"></div>
		
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(11);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}
				echo "</select>";//?>
		</div>
		<div class="cl"></div>
		
		<tr>
			<label>Select No. Colour</label>
			
			<!--<td align="left" class="menuText">Select No. Type </td>-->
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,28);
			$arr_label	= range(1,28);
			?>
			  <select name="selNum" id="selNum" onchange="return getHandType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showHandType"></div>
		
		 
		 <div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25" />
          <div class="cl"></div>
		 
		
      
		<?php
		}
		/*==========================Manual===========================*/
		elseif($txtStatus=="Manual")
		{
		$planDetail = $plan->showPlanManual($oid);
			if($planDetail == 0){ echo "Don't create plan . Please contact Administrator";} 
		
		?>
		
		<div class="cl"></div>				
	<!--	<label>Employee Id<span class="orangeLetter">*</span></label>
        <input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
		size="15" /> -->
		
		
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(12);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
		
		
		
		<div class="cl"></div>
		
		<p style="color:red">Note: Unit of Amount is pieces<p>
		<!--<label>Bill No</label>
        <input name="txtBillNo" id="txtBillNo" type="text" class="text-field" />
        <div class="cl"></div>
		
		-->
		
		<tr>
			<label>Select No. Colour</label>
			
			<!--<td align="left" class="menuText">Select No. Type </td>-->
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,8);
			$arr_label	= range(1,8);
			?>
			  <select name="selNum" id="selNum" onchange="return getManualType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showManulType"></div>
		
		 
		 <div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25"  />
          <div class="cl"></div>
		 
		
      
		<?php
		}
		
		
		elseif($txtStatus=="Computer")
		{
			$planDetail = $plan->showPlanComputer($oid);
		?>
		
		<div >
			<label>Type<span class="orangeLetter">*</span></label>							
			<select name="txtWorkType" type="text" id="txtWorkType" class="text_box_large">
				<option value="Multi">Multi</option>
				<option value="Embroidery">Embroidery</option>
				<option value="Ari">Ari</option>
				<option value="Ari(Thread)">Ari(Thread)</option>
				<option value="Cord">Cord</option>
			</select>	
		</div>
		<div class="cl"></div>
		<label>Machine Area<span class="orangeLetter">*</span></label>
          <input name="txtMarea" type="text" class="text_box_large" id="txtMarea" 
		  size="25"  />
          <div class="cl"></div>
		
		<div class="cl"></div>					
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(13);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
		
		
		<div class="cl"></div>
		<tr>
			<label>No of Comp. Design</label>
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,20);
			$arr_label	= range(1,20);
			?>
			  <select name="selNum" id="selNum" onchange="return getComputerType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}       
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showComputerType"></div>
		
		
		
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25" />
          <div class="cl"></div>
		
		<?php
		}
		elseif($txtStatus=="Kali Cutting")
		{
		$planDetail = $plan->showPlanKali($oid);
		
		?>
		
		
		<div class="cl"></div>				
	<!--	<label>Employee Id<span class="orangeLetter">*</span></label>
        <input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
		size="15" />   -->
		
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(14);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
		
		
		<div class="cl"></div>
		
		
			<label>Bill No</label>
        <input name="txtBillNo" id="txtBillNo" type="text" class="text-field" />
        <div class="cl"></div>
		
		
		<tr>
			<label>Select No. Particulars</label>
			<!--<td align="left" class="menuText">Select No. Type </td>-->
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,8);
			$arr_label	= range(1,8);
			?>
			  <select name="selNum" id="selNum" onchange="return getKaliCuttingType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showKaliCttingType"></div>
		
		
		<div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25"  />
          <div class="cl"></div>
		
       <!--=================================Final stiching ======================================-->
		<?php
		}
		elseif($txtStatus=="Final Stiching")
		{
		$planDetail = $plan->showPlanFinalStich($oid);
		?>
		
		<div class="cl"></div>				
		<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(15);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>	
		<div class="cl"></div>
		
		<tr>
			<label>Select No. Particulars</label>
			<!--<td align="left" class="menuText">Select No. Type </td>-->
			<td align="left" class="bodyText pad5">
			<?php 
			//gen number array
			$arr_value	= range(1,28);
			$arr_label	= range(1,28);
			?>
			  <select name="selNum" id="selNum" onchange="return getFinalStichingType(<?php echo $oid; ?>);"
			   class="textBoxA">
				<option value="0">--Select--</option>
				<?php 
				if(isset($_SESSION['selNum']))
				{
					$utility->genDropDown($_SESSION['selNum'], $arr_value, $arr_label);
				}
				else if(isset($_GET['selNum']))
				{
					$utility->genDropDown($_GET['selNum'], $arr_value, $arr_label);
				}
				else
				{
					$utility->genDropDown(0, $arr_value, $arr_label);
				}
				?>
			  </select>				    </td>
		  </tr>
		<div class="cl"></div>
		<div id="showFinalStichingType"></div>
		
		
		
		
		<div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25"  />
          <div class="cl"></div>
		
		<!--==============================Iron status=========================================-->
		<?php
		}
		elseif($txtStatus=="Iron")
		{
		?>
		
		<div class="cl"></div>				
		<!--	<label>Employee Id<span class="orangeLetter">*</span></label>
			<input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
			size="15" />  -->
			
			
			<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(16);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
			
			
			<div class="cl"></div>
		
			<!--<label>Bill No</label>
			<input name="txtBillNo" id="txtBillNo" type="text" class="text-field" />
			<div class="cl"></div> -->
		
		<label>Quantity(in Pieces)<span class="orangeLetter">*</span></label>
        <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
		 value="<?php  $orders->TotalQuantitySum($oid);?>" size="25" />
        <div class="cl"></div>
		
		
		<div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25" />
          <div class="cl"></div>
		
		
		<?php
		}
		elseif($txtStatus=="Packing")
		{
		?>
		
		<div class="cl"></div>				
		<!-- 	<label>Employee Id<span class="orangeLetter">*</span></label>
			<input name="txtEmpId" type="text" class="text_box_large" id="txtEmpId" 
			size="15" />   -->
			
			
			<div >
			<label>Employee Name<span class="orangeLetter">*</span></label>							
			<select name="txtEmpId" type="text" id="txtEmpId" class="text_box_large">
			<?php
				$customerDetails         = $customer->getAllCustomerDtlPipeline(17);
				foreach ($customerDetails as $row){//Array or records stored in $row
				//echo $row[colour_name];
				echo "<option value=$row[customer_id]>$row[user_name]</option>"; 

				/* Option values are added by looping through the array */ 
								
				}

				echo "</select>";//?>
		</div>
			
			<div class="cl"></div>
		
	<!--	<label>Bill No</label>
        <input name="txtBillNo" id="txtBillNo" type="text" class="text-field" />
        <div class="cl"></div>	-->
		
		<label>Quantity(in Pieces)<span class="orangeLetter">*</span></label>
        <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
		 value="<?php  $orders->TotalQuantitySum($oid);?>" size="25" />
        <div class="cl"></div>
		
		
		<div class="cl"></div>
		 
		  <label>Order Date<span class="orangeLetter">*</span></label>
          <input name="OrderDate" type="date" class="text_box_large" id="OrderDate" 
			size="25"  />
          <div class="cl"></div>
							
		  <label>Target Date<span class="orangeLetter">*</span></label>
          <input name="TargetDate" type="date" class="text_box_large" id="TargetDate" 
		  size="25"  />
          <div class="cl"></div>
		
		
		<?php
		}
		
		else {
		echo "Hi..";
		}

                
	

}
else
{
	//echo NRSPAN.$uMesg->dispMesgImg('ERROR', 'images/icon/', 'error.gif').ERSTCON003.ENDSPAN;
}

