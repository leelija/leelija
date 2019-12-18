<?php 
ob_start();
session_start();
require_once("_config/connect.php"); 

require_once("includes/constant.inc.php");
require_once("includes/product.inc.php");

require_once("classes/adminLogin.class.php"); 
require_once("classes/date.class.php");  
require_once("classes/error.class.php"); 
require_once("classes/order.class.php"); 
require_once("classes/search.class.php");
require_once("classes/pagination.class.php");
require_once("classes/stock.class.php");
require_once("classes/bill.class.php");
require_once("classes/email.class.php"); 
require_once("classes/ratechart.class.php");

require_once("classes/fabric.class.php");
require_once("classes/customer.class.php");
require_once("classes/sample.class.php");

require_once("classes/product_status.class.php");
require_once("classes/status_cat.class.php");

require_once("classes/employee.class.php");
require_once("classes/plan.class.php");

require_once("classes/utility.class.php"); 
require_once("classes/utilityMesg.class.php"); 
require_once("classes/utilityImage.class.php");
require_once("classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$fabric			= new Fabric();
$customer		= new Customer();
//$status		= new Pstatus();
$prodStatus		= new Pstatus();
$ratechart		= new Ratechart();
$sample 		= new Sample();

$statCat		= new StatusCat();
$emailObj		= new Email();

$employee		= new Employee();
$plan			= new Plan();
$bill			= new Bill();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################
date_default_timezone_set('Asia/Calcutta'); 
//echo date("Y-m-d H:i:s"); // time in India
$attDate 		= date("Y-m-d");// Attendance Date
$attDateTime 	= date("d-m-Y H:i:s");// Attendance Date time

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$psid			= $utility->returnGetVar('psid','0');

$userId			= $utility->returnSess('userid', 0);
//customer detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[USR_SESS]);

$prodstatDtl	= $prodStatus->showProductStat($psid);

$statCatDtl		= $statCat->showProductStatCat1($psid); 
$finalStatusDtl = $statCat->showPStatusPrStatusId($psid);

$ordDtls		= $orders->showOrders($prodstatDtl[1]);



//echo count($statCatDtl);exit;

if(isset($_POST['btnEditOrd']))
{	
	$txtEmpId 	        	= $_POST['txtEmpId'];
	$txtStatus 	        	= $_POST['txtStatus'];
	//$txtQuantity 	        = $_POST['txtQuantity'];
	$txtProdDesc 	        = $_POST['txtProdDesc'];
	$OrderDate 	        	= $_POST['OrderDate'];
	$TargetDate 	        = $_POST['TargetDate'];
	$txtBillNo 	            = '';		//Bill no
	//$txtFabricType 	        = $_POST['txtFabricType']; // Fabric Type Or Particulars
	//$txtDesignNo			= $_POST['txtDesignNo']; //Computer Design no.
	//$txtNoOfStich			= $_POST['txtNoOfStich'];
	//$txtTime			    = $_POST['txtTime'];
	
	 
	$selNum					= $_POST['selNum'];
	
	// Bill User details
	$bUserDtls 				= $customer->getCustomerData($txtEmpId);
	
	
	// Calculate current stock
//$current_stock= $txtAmount+$fabricDtl[2];
	
	//registering the post session variables
	
		$sess_arr	= array('txtEmpId','txtStatus','txtQuantity','txtProdDesc','OrderDate','TargetDate');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'update_status';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'updateStatus';
	$typeM		= 'ERROR';
	
	
	$msg = '';


if($txtEmpId == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Employee Id field empty", $typeM, $aname);
	}
	/*elseif($txtFabricType == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Select particulars type ", $typeM, $aname);
	}*/
	elseif($OrderDate == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Select Order Date", $typeM, $aname);
	}
	elseif($TargetDate == '')
	{
		$error->showErrorTA($action, $id, $id_var, $url, "Select Target Date", $typeM, $aname);
	}
	
	
	else
	{
		if($txtStatus=='Dyeing')
		{
			$billName 	= 'Dyeing';
			$custDtls 		= $customer->getCustomerData($txtEmpId);
			//echo $custDtls[39];echo $eachRecord['fabric_type'];exit;
			
			
			if($ordDtls[14] == 2)
				{
					$dyeCat 	= $_POST['txtFabricCat'];
					if($dyeCat == "Dyeable")
						{
						//add bill in the Dye bill table
						$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_dye_bbook');
						for($i=0; $i < $selNum; $i++)
						{
							$dyeRateDtls 	= $ratechart->showDyeWFDtls($custDtls[39],$_POST['txtProductType'][$i]);
							
							$tFabAmount 	= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
							//add the dyeing table
							$statCat->addStasCat($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtBillNo,
							$txtStatus,$_POST['txtProductType'][$i],$tFabAmount,$_POST['txtColour'][$i],$txtProdDesc,$OrderDate,
							$TargetDate,0,'Running',$userData[2],$_POST['txtNoOfColor'][$i],$_POST['txtFabricAmount'][$i],$dyeCat);	
							// $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
						
							$dyeBillDtls = $bill->allRFRIBillTable($txtBillNo,'rfri_dye_bbook');
							
							$fabQuantity 	= $dyeBillDtls[7] + $tFabAmount;
							$fabCost 		= $fabQuantity * $dyeRateDtls[3];
							//update bill table
							$bill->UpdateAllBill($txtBillNo,$fabQuantity,$dyeRateDtls[3],$fabCost,'rfri_dye_bbook');
						
						}//for
						
						// Add Dyeing bill 
						$plan->updatePlanfoDye($prodstatDtl[1],$OrderDate);	
					  
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],'Running',$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
						$dyekDetails  			= $statCat->disPlTableDtls($txtBillNo,'dyeing_table');
						$billDtl 				= $bill->allRFRIBillTable($txtBillNo,'rfri_dye_bbook');
						$bDate					= date_create($billDtl[1]);
						
					}
					else{
					
						// Add Dyeing bill 
						$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_dye_bbook');
						
						//add the additional images
						for($i=0; $i < $selNum; $i++)
						{
								$tFabAmount 	= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
								//add the dyeing table
								$statCat->addStasCat($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtBillNo,
								$txtStatus,$_POST['txtProductType'][$i],0,$_POST['txtColour'][$i],$txtProdDesc,$OrderDate,
								$TargetDate,$tFabAmount,'complete',$userData[2],$_POST['txtNoOfColor'][$i],$_POST['txtFabricAmount'][$i],$dyeCat);	
								// $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
										
						}//for
							  
						$plan->updatePlanfoDye($prodstatDtl[1],$OrderDate);	
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],'complete',$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
						$dyekDetails  			= $statCat->disPlTableDtls($txtBillNo,'dyeing_table');
						$billDtl 				= $bill->allRFRIBillTable($txtBillNo,'rfri_dye_bbook');
						$bDate					= date_create($billDtl[1]);
					
					}
					
					$employeeDtls 			= $employee->EmployeeAllData(23);
					//echo count($employeeDtls);exit;
					foreach($employeeDtls as $eachRecord)
                            {
							//echo $eachRecord['emp_mobile'];exit;
						// ==== Send SMS =======
							$apikey = "Cel1HfkoUkOIJP7VlXPAPA";
							$apisender = "MoniEn";
							$msgs =" Order Id ".$prodstatDtl[1]." ,Design No. ".$prodstatDtl[2]." has been assigned for dye. Receive Date:   ".$TargetDate."  ";
							$number = $eachRecord['emp_mobile'];    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
						
				}
			else{
			
				$dyeCat 	= $_POST['txtFabricCat'];
					if($dyeCat == "Dyeable")
						{
						//add bill in the Dye bill table
						$txtBillNo 	 	= $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_dye_bbook');
						//$billNo			= D'.'$txtBillNo;
						$billNo			= "D".$txtBillNo."";
						for($i=0; $i < $selNum; $i++)
						{
							$dyeRateDtls 	= $ratechart->showDyeWFDtls($custDtls[39],$_POST['txtProductType'][$i]);
							
							$tFabAmount 	= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
							//add the dyeing table
							$statCat->addStasCat($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$billNo,
							$txtStatus,$_POST['txtProductType'][$i],$tFabAmount,$_POST['txtColour'][$i],$txtProdDesc,$OrderDate,
							$TargetDate,0,'Running',$userData[2],$_POST['txtNoOfColor'][$i],$_POST['txtFabricAmount'][$i],$dyeCat);	
							// $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
						
							$dyeBillDtls = $bill->allRFRIBillTable($txtBillNo,'mep_dye_bbook');
							
							$fabQuantity 	= $dyeBillDtls[7] + $tFabAmount;
							$fabCost 		= $fabQuantity * $dyeRateDtls[3];
							//update bill table
							$bill->UpdateAllBill($txtBillNo,$fabQuantity,$dyeRateDtls[3],$fabCost,'mep_dye_bbook');
						
						}//for
						
						// Add Dyeing bill 
						$plan->updatePlanfoDye($prodstatDtl[1],$OrderDate);	
					  
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],'Running',$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
						$dyekDetails  			= $statCat->disPlTableDtls($txtBillNo,'dyeing_table');
						$billDtl 				= $bill->allRFRIBillTable($txtBillNo,'mep_dye_bbook');
						$bDate					= date_create($billDtl[1]);
						
					}
					else{
					
						// Add Dyeing bill 
						$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_dye_bbook');
						
						//add the additional images
						for($i=0; $i < $selNum; $i++)
						{
								$tFabAmount 	= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
								//add the dyeing table
								$statCat->addStasCat($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtBillNo,
								$txtStatus,$_POST['txtProductType'][$i],0,$_POST['txtColour'][$i],$txtProdDesc,$OrderDate,
								$TargetDate,$tFabAmount,'complete',$userData[2],$_POST['txtNoOfColor'][$i],$_POST['txtFabricAmount'][$i],$dyeCat);	
								// $fabric->editFabric($fid,$fabricDtl[1],$current_stock,$fabricDtl[5],$fabricDtl[4]);
										
						}//for
							  
						$plan->updatePlanfoDye($prodstatDtl[1],$OrderDate);	
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],'complete',$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
						$dyekDetails  			= $statCat->disPlTableDtls($txtBillNo,'dyeing_table');
						$billDtl 				= $bill->allRFRIBillTable($txtBillNo,'mep_dye_bbook');
						$bDate					= date_create($billDtl[1]);
					
					}
					
					$employeeDtls 			= $employee->EmployeeAllData(23);
				}
		  
		}//end of dyeing
		elseif($txtStatus=='Hand')
		{
			$txtWorkType			= $_POST['txtWorkType'];
			$billName 				= 'Hand';
			if($ordDtls[14] == 2)//Bill for HMDA
				{
					// Add Hand bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_hand_bbook');
					$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_hand_bbook');
				
				if($txtWorkType == "PureHand")	
					{
						
						// Cost Calculate		
						$sHandDtls		= $sample->getAllHandDtlDT($prodstatDtl[2],'PureHand');	
						if(count($sHandDtls) == 0)
						{
							$tAmount = 0;
						}else{
						
						$tAmount 		= 0;
						foreach($sHandDtls as $eachRecord)
							{
								$totalAmount	= $eachRecord['sample_time'] * $eachRecord['labour_rate'] + $eachRecord['material_cost']+ $eachRecord['other_cost'];
								//$quantity		= $eachRecord['quantity'] + $eachRecord['complete'];
								$tAmount 		+= $totalAmount;
							}
						}
					
						for($i=0; $i < $selNum; $i++)
						{
						
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[6] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						if($dueQty >= 0)
							{
							// update Order Details
							$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'hand_rquantity');
							
							$statCat->addStasHand($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
							$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','',
							'','','','',$txtProdDesc,$OrderDate,$TargetDate,$txtWorkType);
							
							$handBillDtls 	= $bill->allRFRIBillTable($txtBillNo,'rfri_hand_bbook');
							$partQuantity 	= $handBillDtls[7] + $_POST['txtFabricAmount'][$i];
							$labCost 		= $partQuantity * $tAmount;
							//update bill table
							$bill->UpdateAllBill($txtBillNo,$partQuantity,$tAmount,$labCost,'rfri_hand_bbook');
							
							}
							else{
								echo "Put the valid input";exit;
							}
						}
						//Update Plan
						$plan->updatePlanforHand($prodstatDtl[1],$OrderDate);	
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],'Running',$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
					} 
				else{
						// Cost Calculate		
						$sHandDtls		= $sample->getAllHandDtlDT($prodstatDtl[2],'HighLight');	
						if(count($sHandDtls) == 0)
						{
							$tAmount = 0;
						}else{
						
						$tAmount 		= 0;
						foreach($sHandDtls as $eachRecord)
							{
								$totalAmount	= $eachRecord['total_cost'];
								//$quantity		= $eachRecord['quantity'] + $eachRecord['complete'];
								$tAmount 		+= $totalAmount;
							}
						}
				
				
						for($i=0; $i < $selNum; $i++)
						{
						$statCat->addStasHand($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
						$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','',
						'','','','',$txtProdDesc,$OrderDate,$TargetDate,$txtWorkType);
						
						
						$handBillDtls 	= $bill->allRFRIBillTable($txtBillNo,'rfri_hand_bbook');
						$partQuantity 	= $handBillDtls[7] + $_POST['txtFabricAmount'][$i];
						$labCost 		= $partQuantity * $tAmount;
						//update bill table
						$bill->UpdateAllBill($txtBillNo,$partQuantity,$tAmount,$labCost,'rfri_hand_bbook');
						
						
						}
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],'Running',$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
					}
				
				}//End Bill For HMDA	
				else{//Hand bill for MEP
					
					// Add Hand bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_hand_bbook');
					$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_hand_bbook');
					$billNo			= "H".$txtBillNo."";
					
				if($txtWorkType == "PureHand")	
					{
						// Cost Calculate		
						$sHandDtls		= $sample->getAllHandDtlDT($prodstatDtl[2],'PureHand');	
						if(count($sHandDtls) == 0)
						{
							$tAmount = 0;
						}else{
						
						$tAmount 		= 0;
						foreach($sHandDtls as $eachRecord)
							{
								$totalAmount	= $eachRecord['sample_time'] * $eachRecord['labour_rate'] + $eachRecord['material_cost']+ $eachRecord['other_cost'];
								//$quantity		= $eachRecord['quantity'] + $eachRecord['complete'];
								$tAmount 		+= $totalAmount;
							}
						}
					
						for($i=0; $i < $selNum; $i++)
						{
						
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[6] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						if($dueQty >= 0)
							{
							// update Order Details
							$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'hand_rquantity');
							
							$statCat->addStasHand($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$billNo,
							$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','',
							'','','','',$txtProdDesc,$OrderDate,$TargetDate,$txtWorkType);
							
							$handBillDtls 	= $bill->allRFRIBillTable($txtBillNo,'mep_hand_bbook');
							$partQuantity 	= $handBillDtls[7] + $_POST['txtFabricAmount'][$i];
							$labCost 		= $partQuantity * $tAmount;
							//update bill table
							$bill->UpdateAllBill($txtBillNo,$partQuantity,$tAmount,$labCost,'mep_hand_bbook');
							
							}
							else{
								echo "Put the valid input";exit;
							}
						}
						//Update Plan
						$plan->updatePlanforHand($prodstatDtl[1],$OrderDate);	
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],'Running',$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
					} 
				else{
						// Cost Calculate		
						$sHandDtls		= $sample->getAllHandDtlDT($prodstatDtl[2],'HighLight');	
						if(count($sHandDtls) == 0)
						{
							$tAmount = 0;
						}else{
						
						$tAmount 		= 0;
						foreach($sHandDtls as $eachRecord)
							{
								$totalAmount	= $eachRecord['total_cost'];
								//$quantity		= $eachRecord['quantity'] + $eachRecord['complete'];
								$tAmount 		+= $totalAmount;
							}
						}
				
				
						for($i=0; $i < $selNum; $i++)
						{
						$statCat->addStasHand($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$billNo,
						$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','',
						'','','','',$txtProdDesc,$OrderDate,$TargetDate,$txtWorkType);
						
						$handBillDtls 	= $bill->allRFRIBillTable($txtBillNo,'mep_hand_bbook');
						$partQuantity 	= $handBillDtls[7] + $_POST['txtFabricAmount'][$i];
						$labCost 		= $partQuantity * $tAmount;
						//update bill table
						$bill->UpdateAllBill($txtBillNo,$partQuantity,$tAmount,$labCost,'mep_hand_bbook');
						
						}
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],'Running',$prodstatDtl[8],$prodstatDtl[18],$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
					}
				}//end bill for MEP
				
		}
		elseif($txtStatus=='Manual')
		{
			$billName 	= 'Manual';
			if($ordDtls[14] == 2)
				{
					
				// Add Manual bill 
				//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_manual_bbook');
				$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_manual_bbook');
				
				for($i=0; $i < $selNum; $i++)
					{
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[7] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						if($dueQty >= 0)
							{
								// update Order Details
								$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'manual_rquantity');
								$statCat->addStasManual($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
								$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','','','','','',$txtProdDesc,$OrderDate,$TargetDate);
							}
						else{
							echo "Put the valid input";exit;
						}	
					
					}
							
					//Update Plan
						$plan->updatePlanforManual($prodstatDtl[1],$OrderDate);
						
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
					   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],'Running',$prodstatDtl[18],$prodstatDtl[9],
					   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				}
				else{
				
					// Add Manual bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','mep_manual_bbook');
					$txtBillNo 	 	= $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_manual_bbook');
					$billNo			= "M".$txtBillNo."";
				
				for($i=0; $i < $selNum; $i++)
					{
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[7] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						if($dueQty >= 0)
							{
								// update Order Details
								$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'manual_rquantity');
								$statCat->addStasManual($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$billNo,
								$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','','','','','',$txtProdDesc,$OrderDate,$TargetDate);
							}
						else{
							echo "Put the valid input";exit;
						}	
					
					}
							
					//Update Plan
						$plan->updatePlanforManual($prodstatDtl[1],$OrderDate);
						
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
					   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],'Running',$prodstatDtl[18],$prodstatDtl[9],
					   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				
				
				}
		}
		
		elseif($txtStatus=='Computer')
		{
			$billName 	= 'Computer';
			if($ordDtls[14] == 2)
				{
					// Add Computer bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_comp_bbook');
					$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_comp_bbook');
					//$txtColor 	= $_POST['txtColor'];
					for($i=0; $i < $selNum; $i++)
					{
						$color 			= $_POST['txtColor'][$i];
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$color);
						$Quantity 		= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
						
						$readyQty		= $ordDtlDtls[7] + $Quantity;
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						
						// update Order Details
						$orders->updateOrdDtls($prodstatDtl[1],$color,$readyQty,'comp_rquantity');
					
						$statCat->addStasComputer($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
						$color,$_POST['txtDesignNo'][$i],$Quantity,$_POST['txtTotalStirch'][$i],
						$_POST['txtStitchRate'][$i],'','','',$txtProdDesc,$OrderDate,$TargetDate,$userData[2],$_POST['txtNoOfHead'][$i]
						,$_POST['txtNoOfColor'][$i],$_POST['txtUnit'][$i]);
					}
						//Update Plan
						$plan->updatePlanforComputer($prodstatDtl[1],$OrderDate);
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],'Running',$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				}
				else{
				
					// Add Computer bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','mep_comp_bbook');
					$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_comp_bbook');
					$billNo			= "C".$txtBillNo."";
					//$txtColor 	= $_POST['txtColor'];
					for($i=0; $i < $selNum; $i++)
					{
						$color 			= $_POST['txtColor'][$i];
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$color);
						$Quantity 		= $_POST['txtNoOfColor'][$i] * $_POST['txtFabricAmount'][$i];
						
						$readyQty		= $ordDtlDtls[7] + $Quantity;
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						
						// update Order Details
						$orders->updateOrdDtls($prodstatDtl[1],$color,$readyQty,'comp_rquantity');
					
						$statCat->addStasComputer($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$billNo,
						$color,$_POST['txtDesignNo'][$i],$Quantity,$_POST['txtTotalStirch'][$i],
						$_POST['txtStitchRate'][$i],'','','',$txtProdDesc,$OrderDate,$TargetDate,$userData[2],$_POST['txtNoOfHead'][$i]
						,$_POST['txtNoOfColor'][$i],$_POST['txtUnit'][$i]);
					}
						//Update Plan
						$plan->updatePlanforComputer($prodstatDtl[1],$OrderDate);
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],'Running',$prodstatDtl[9],
						$prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				
				}
		}
		
		elseif($txtStatus=='Kali Cutting')
		{
			for($i=0; $i < $selNum; $i++)
			{
			$statCat->addStasKaliCut($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
			$_POST['txtProductType'][$i],$_POST['txtFabricAmount'][$i],$txtProdDesc,$OrderDate,$TargetDate);
			}
			
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],'Running',
			   $prodstatDtl[10],$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
			
			
		}
		
		elseif($txtStatus=='Final Stiching')
		{
			$billName 	= 'Final Stiching';
			if($ordDtls[14] == 2)//for HMDA
				{
					// Add Final Stiching bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_fs_bbook');
					$txtBillNo 	 = $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','rfri_fs_bbook');
					for($i=0; $i < $selNum; $i++)
					{
						//echo $_POST['txtColor'][$i];
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[10] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						//echo $ordDtlDtls[2];exit;
						if($dueQty >= 0)
							{
								// update Order Details
								$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'fs_rquantity');
								
								$statCat->addStasFinal($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$txtBillNo,
								$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','','',$txtProdDesc,$OrderDate,$TargetDate);
							}
						else{
							echo "Put the valid input";exit;
						}
					}
					
					//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
					   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
					   $prodstatDtl[9],'Running',$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				}
				else{
				
					// Add Final Stiching bill 
					//$txtBillNo 	= $bill->addBill($txtEmpId,$attDate, $userData[2],'No','rfri_fs_bbook');
					$txtBillNo 	 	= $bill->addBill($txtEmpId,'','','',$attDate, $userData[2],'No','mep_fs_bbook');
					$billNo			= "F".$txtBillNo."";
					for($i=0; $i < $selNum; $i++)
					{
						//echo $_POST['txtColor'][$i];
						$ordDtlDtls 	= $orders->ordDtlsShow($prodstatDtl[1],$_POST['txtColor'][$i]);
						$readyQty		= $ordDtlDtls[10] + $_POST['txtFabricAmount'][$i];
						$dueQty			= $ordDtlDtls[2] - $readyQty;
						//echo $ordDtlDtls[2];exit;
						if($dueQty >= 0)
							{
								// update Order Details
								$orders->updateOrdDtls($prodstatDtl[1],$_POST['txtColor'][$i],$readyQty,'fs_rquantity');
								
								$statCat->addStasFinal($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$billNo,
								$_POST['txtColor'][$i],$_POST['txtFabricAmount'][$i],'','','',$txtProdDesc,$OrderDate,$TargetDate);
							}
						else{
							echo "Put the valid input";exit;
						}
					}
					
						//Update status table		
						$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
						$prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
						$prodstatDtl[9],'Running',$prodstatDtl[11],$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
				
				}
		}
		
		elseif($txtStatus=='Iron' )
		{
			$txtQuantity 	        = $_POST['txtQuantity'];
			if($orders->TotalQuantitySum($oid)>= $txtQuantity){
			$statCat->addStasIron($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$finalStatusDtl[17],$txtQuantity,$txtProdDesc,$OrderDate,$TargetDate);
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
			   $prodstatDtl[9],$prodstatDtl[10],'Running',$prodstatDtl[12],$prodstatDtl[13],$prodstatDtl[20]);
			}
			else{
				echo "quantity greater than order quantity";
			
			}
		}
		
		elseif($txtStatus=='Packing' )
		{
			$txtQuantity 	        = $_POST['txtQuantity'];
			$statCat->addStasPacking($psid,$prodstatDtl[1],$prodstatDtl[2],$userId,$txtEmpId,$txtStatus,$finalStatusDtl[17],$txtQuantity,$txtProdDesc,$OrderDate,$TargetDate);
			
			
			//Update status table		
				$prodStatus->editStatus($psid,$prodstatDtl[1],$prodstatDtl[2], $prodstatDtl[19],$prodstatDtl[3],
			   $prodstatDtl[4], $prodstatDtl[5],$prodstatDtl[6],$prodstatDtl[7],$prodstatDtl[8],$prodstatDtl[18],
			   $prodstatDtl[9],$prodstatDtl[10],$prodstatDtl[11],'Running',$prodstatDtl[13],$prodstatDtl[20]);
		}
		else
		{
			echo "Select Proper input";
			echo '<input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />';
			exit;
		}
		
		
					$txtNewsLetterEmail  = 'newsforshopping@gmail.com';
					$txtCompany			 =  'RFRI';	
					//send email
					$subjectEmail 	= $billName. "Bill for  - ".$bUserDtls[5]." - ". date("d-m-Y");
					$to 			= SITE_ADMIN. "<".$txtNewsLetterEmail.">";
					$from 			= $txtCompany. "<".SITE_EMAIL.">";
					 
					$body = '
						 <div style="width: 100%; height:auto; font:normal 13px Georgia, Times, Arial, Verdana, sans-serif;
									color: #000000; bachground-color:#fff;">
							<div style="padding:10px; margin:0px auto;" align="center">
								<img src="'.URL.LOGO_WITH_PATH.'" height="'.LOGO_HEIGHT.'" width="'.LOGO_WIDTH.'" 
								 alt="'.LOGO_ALT.'" />
							</div>
							
							<div style="width: 650px; height:auto; margin:5px auto 10px auto; padding:20px 10px;
										font:normal 12px Helvetica, Arial, Verdana, sans-serif;
										color: #000000; bachground-color:#FCFCFC; -moz-border-radius: 4px; -webkit-border-radius: 4px;
										border:1px solid #eee;">

								<h2 style="font:bold 12px Arial, Verdana, sans-serif;width:650px; height:30px;
										   background-color:#DCDCC7; color:#7C6677; text-align:center; line-height:30px;
										   vertical-align:middle; padding:0; margin:0">
									'.$billName.' Bill
								</h2>
								
								<p>Dear '.$bUserDtls[5].',</p>
								<p>You have received a new '.$billName.' Bill. Below is the Bill detail:</p>
								
								
								<p style="padding:10px">
									Bill Id:   '.$txtBillNo.'<br />
									Email:   '.$txtNewsLetterEmail.'<br />
								</p>
								
								<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
								
								';
								 
								if(count($dyekDetails) == 0)
								{
							$body		.=  '
								<tr align="left" class="orangeLetter">
								  <td height="20" colspan="5"> Table is empty</td>
								</tr>
								';
								}
								else
								{
								
							$body		.=  '
							
								<thead>
								<tr>
								  <th width="5%" height="25"  align="center">QLTY</th>
								  <th width="55%" >PARTICULARS</th>
								  <th width="10%" >Order Id</th>
								  <th width="10%" >DSG No.</th>
								  <th width="10%" >QTY</th>
								  <th width="10%" >RATE</th>
								  <th width="10%" >AMOUNT<th>
								</tr>  
								</thead>
								<tbody>
								';
									$sl=1;  
									$tAmount 		= 0;
									foreach($dyekDetails as $eachRecord)
										{
										$bgColor 	 	= $utility->getRowColor($sl);
												
										$dyeRateDtls 	= $ratechart->showDyeWFDtls($userData[20],$eachRecord['fabric_type']);
										$totalAmount	= $eachRecord['quantity'] * $dyeRateDtls[3];
										
										$tAmount 		+= $totalAmount;
								$body		.=  '
									<tr>
										<td align="left">'.$sl.'</td>
										<td align="center">'.$eachRecord['fabric_type'].'</td>
										<td align="center">'.$eachRecord['order_id'].'</td>
										<td align="center">'.$eachRecord['design_no'].'</td>
										<td align="center">'.$eachRecord['quantity'].'</td>
										<td align="center">'.$dyeRateDtls[3].'</td>
										<td align="center">RS.'.$totalAmount.'</td>
									</tr>
								  ' ;
									$sl++;
										}
										
									}
								$body		.=  '
								</tbody>  
							</table>
							<div class="tBillTitle" style="background:#ddd; height: 30px;">
								<p class="ltotal" style="width:50%; float:left;">Total</p>
								<p class="rtotal" style="width: 45%; float: right;position: relative;left: 185px;"><b>Rs.'.$tAmount.'</b></p>
							</div>
							<p>Bill By <b>'.$billDtl[2].'</b></p>
							
								<p>
								Regards,<br />
								Employee Service<br />
								'.COMPANY_S.'
								</p>
							</div>
					
					</div>
					';
					$headers = 'From: YourLogoName newsforshopping@gmail.com' . "\r\n" ;
					$headers .='Reply-To: '. $to . "\r\n" ;
					$headers .='X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					//send email to client
					$emailObj->sendEmail($to, $subjectEmail, $body, $bUserDtls[5], $txtNewsLetterEmail);

		
		//deleting the sessions
		$utility->delSessArr($sess_arr);

		//forward the web page
		$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], SUPROD001, 'SUCCESS');
	}
}





?>

<title><?php echo COMPANY_S; ?> -  - Job Assign</title>

<!-- Style -->
<link href="style/admin/style.css" rel="stylesheet" type="text/css">
<link href="style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utility.js"></script>
<script type="text/javascript" src="js/advertiser.js"></script>
<script type="text/javascript" src="js/location.js"></script>
<script type="text/javascript" src="js/checkEmpty.js"></script>
<script type="text/javascript" src="js/email.js"></script>
<script type="text/javascript" src="js/static.js"></script>
<script type="text/javascript" src="js/product.js"></script>
<script type="text/javascript" src="js/pipeline.js"></script>
<script type="text/javascript" src="js/pipeline_manual.js"></script>
<script type="text/javascript" src="js/pipeline_kali.js"></script>

<!-- eof JS Libraries -->
<!-- TinyMCE --> 
 <script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
 <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "image,fontsizeselect,forecolor,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,bullist,numlist,|,outdent,indent",
		theme_advanced_buttons2 :
"undo,redo,|,emotions,|,pasteword,code",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		formats : {
			alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
			aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
			alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
			alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
			bold : {inline : 'span', 'classes' : 'bold'},
			italic : {inline : 'span', 'classes' : 'italic'},
			underline : {inline : 'span', 'classes' : 'underline', exact : true},
			strikethrough : {inline : 'del'}
		},

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->


<!--Ajax search  employee name-->
<script type="text/javascript">
function ajaxFunction(str)
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    try
      {
      httpxml=new ActiveXObject("Microsoft.XMLHTTP");
      }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
function stateChanged() 
    {
    if(httpxml.readyState==4)
      {
document.getElementById("displayDiv").innerHTML=httpxml.responseText;
document.getElementById("msg").style.display='none';

      }
    }
	var url="employee_search.php";
url=url+"?txt="+str;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateChanged;
httpxml.open("GET",url,true);
httpxml.send(null);
//document.getElementById("msg").innerHTML="Please Wait ...";
document.getElementById("msg").style.display='inline';

  }
</script>





</head>


	<?php 
	//display message
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'update_status') )
        {
             
            $statusDetails = $prodStatus->showProductStat($psid);
			
			
        ?>
			
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=update_status&psid=<?php echo $psid; ?>" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Job Assign</a></h2>
		 <h2>->Order Id:<?php echo $statusDetails[1];?>&nbsp;->Design No:<?php echo $statusDetails[2];?><br><br>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <div class="cl"></div>
							<div >
                                    <label>Status <span class="orangeLetter">*</span></label>
                                    <!----- After select one option call package_product_status.php file ----->
                                    <select name="txtStatus" type="text" id="txtStatus" class="text_box_large" onchange="return getProductStat(<?php echo $prodstatDtl[1]; ?>); ">
                                    <option value="0">------ Select an option ------</option>
                                    <option value="Dyeing" >Dyeing</option>
                                    <option value="Hand" >Hand</option>
                                    <option value="Manual" >Manual</option>
                                    <option value="Computer" >Computer</option>
                                    <option value="Kali Cutting" >Kali Cutting</option>
                                    <option value="Final Stiching" >Final Stiching</option>
                                    <option value="Iron" >Iron</option>
                                    <option value="Packing" >Packing</option>
                                    
                                    </select>
                            </div>
                            <div class="cl"></div>
                            <div id="showResponse"></div>
                           <div class="cl"></div>
						   
							<!--<label>Quantity<span class="orangeLetter">*</span></label>
                            <input name="txtQuantity" type="text" class="text_box_large" id="txtQuantity" 
					         size="25" />
                            <div class="cl"></div>
                            <h2>Note: Unit of Dyeing and Computer is meter</h2>-->
                            
                             <label>Remarks</label>
                            <textarea  name="txtProdDesc" id="txtProdDesc">
							<?php $utility->printSess2('txtProdDesc',''); ?>
                            </textarea>
							
							
							
							
                            
                            
<?php /*?>                            <label>Tax</label>
                            <select name="txtTaxId" id="txtTaxId" class="textBoxA">
							  <?php
                              if(isset($_SESSION['txtTaxId']))
                              {
                                $tax->taxDropDown($_SESSION['txtTaxId']);
                              }
                              else
                              {
                                $tax->taxDropDown(0);
                              } 
                              ?>
                            </select>	
                            <div class="cl"></div><?php */?>
                            
                           
                            <div class="cl"></div>
                            
                           <!-- <span class="menuTxt"><a href="#AddDesc" onClick="showAdditionalDesc('divId')"> Add additional Remarks</a></span>
                            <div class="cl"></div>
                            
                            <a name="AddDesc">
                                <div id="divId" class="hideDesc">
                                    <label>Additional Remarks</label>
                                    <textarea  name="txtRemarks" id="txtRemarks">
                                    <?php //$utility->printSess2('txtRemarks',''); ?>
                                    </textarea>
                                </div>
                            </a>-->
                            <div class="cl"></div>
                                            
                                                                    
                <input name="btnEditOrd" type="submit" class="button-add"  value="asign" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
