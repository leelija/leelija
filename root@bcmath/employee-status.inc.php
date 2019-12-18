<?php
ob_start();
session_start(); 
include_once('_config/connect.php'); 

require_once("includes/constant.inc.php");

include_once('classes/encrypt.inc.php'); 
include_once('classes/adminLogin.class.php'); 
include_once('classes/employee.class.php'); 

require_once("classes/utility.class.php");
require_once("classes/utilityMesg.class.php"); 

//instantiating classes 
$adminLogin 	= new adminLogin();
$employee 		= new Employee();

$utility		= new Utility();
$uMesg 			= new MesgUtility();

########################################################################################################################

	//declare vars
	$typeM		= $utility->returnGetVar('typeM','');
	date_default_timezone_set('Asia/Calcutta'); 
	//echo date("Y-m-d H:i:s"); // time in India
	$attDate 		= date("Y-m-d");// Attendance Date
	$attDateTime 	= date("Y-m-d H:i:s");// Attendance Date time
	$entrTime 		= date_create($attDateTime);
	$currTime 		= date_format($entrTime,"H:i:s");
	
	$time2 = '00:07:00';
	$time = strtotime($currTime) - strtotime($time2) + strtotime('00:00:00');
	

	//$txtAdhar 	= $_POST['txtAdhar']; 
	$txtAdhar 	= $_GET['txtAdhar'];
	//echo $txtAdhar;
	if(($txtAdhar == ''))
	{
		//header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhaar Card No.");
		echo "invalid Aadhaar Card No..";
	}
	else
	{
		//employee details display
		$empDtls 			= $employee->showEmployeeAdhar($txtAdhar);
		if(count($empDtls) == 0)
			{
				echo "Data not found..";
			}
		else{	
				$empAddressDtl		= $employee->showEmpAddress($empDtls[0]);
				$empTypeDtl			= $employee->getEmpTypeData($empDtls[1]);
				
				//Payment Details
				$payDtls 			= $employee->showEmpPayBookData($empDtls[0]);
				
				//date funstion
				$now 			= new \DateTime('now');
				$month 			= $now->format('M');
				$prvsMonth		= date("M", strtotime("-1 months"));
				//echo $month;exit;
				$year 			= $now->format('Y');
				$nMonth 		= $now->format('m');
				
				//Current Month duty
				$monthlyattn 	= $employee->monthlyDuty($txtAdhar,$month,$year);
				$mAttn 			= count($monthlyattn);// Monthly Duty
				
				//Previous Month Duty
				$pmonthlyattn 	= $employee->monthlyDuty($txtAdhar,$prvsMonth,$year);
				$prvmAttn 		= count($pmonthlyattn);// Monthly Duty
	
	?>
	
		<div class="detail-block">
            <h4> 
				<?php 
					echo $utility->imgDisplayR('employee/images/photos/', $empDtls[12], 200, 200, 0, 'greyBorder', $empDtls[3], '');
				?>
				<?php echo $empDtls[6]." ".$empDtls[7]; ?>
            </h4>
            <h5>Department</h5>
            <p><label>Employee Post:</label> <?php echo $empTypeDtl[2]; ?> </p> 
			<p><label>Adhar No</label> <?php echo $empDtls[28]; ?> </p>	
            
			<h5>Duty:</h5>
            <a data-toggle="collapse" data-target="#demo"><label>Current Month(<?php echo $month;?>)</label> <?php echo $mAttn; ?> </a>
			<div id="demo" class="collapse">
				 <!-- Display Data -->
                <div id="data-column">
                	<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
						<thead>
						  <th align="center" width="25%">Date</th>
                          <th align="center" width="25%">Entry Time</th>
                          <th align="center" width="25%">Exit Time</th>
						</thead>  
						<?php
							foreach($monthlyattn as $eachRecord)
								{
							?>	
							<tr>
								<td align="center"><?php echo $eachRecord['added_on']; ?></td>
								<td align="center"><?php echo $eachRecord['entry_time']; ?></td>
								<td align="center"><?php echo $eachRecord['exit_time']; ?></td>	
							</tr>
						
						<?php	
							}//end foreachloop
						?>	
					</table>
				</div>
				<!-- end Display Data -->
			</div>
			<a data-toggle="pcollapse" data-target="#prvmonth" ><label>Previous Month(<?php echo $prvsMonth;?>)</label> <?php echo $prvmAttn; ?> </a>
            
			<div id="prvmonth" class="pcollapse">
				 <!-- Display Data -->
                <div id="data-column">
                	<table class='blue' cellpadding="0" cellspacing="0" id="table-1">
						<thead>
						  <th align="center" width="25%">Date</th>
                          <th align="center" width="25%">Entry Time</th>
                          <th align="center" width="25%">Exit Time</th>
						</thead>  
						<?php
							foreach($pmonthlyattn as $eachRecord)
								{
							?>	
							<tr>
								<td align="center"><?php echo $eachRecord['added_on']; ?></td>
								<td align="center"><?php echo $eachRecord['entry_time']; ?></td>
								<td align="center"><?php echo $eachRecord['exit_time']; ?></td>	
							</tr>
						
						<?php	
							}//end foreachloop
						?>	
					</table>
				</div>
				<!-- end Display Data -->
			</div>
			
			
			<!--<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Simple collapsible</button>-->
 
			
            <h5>Payment:</h5>
            <p><label>Payable</label> <?php echo $payDtls[8]; ?> </p>
            <p><label>Advance</label> <?php echo $payDtls[4]; ?> </p>
			<p><label>Due</label> <?php echo $payDtls[3]; ?> </p>         
            <p><label>Total Duty</label> <?php echo $payDtls[2]; ?> </p>                    
        </div>
	
	<?php
		}//end elseLoop
	}

?>