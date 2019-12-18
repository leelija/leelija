<?php 
ob_start();
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/product.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/order.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/stock.class.php");

require_once("../classes/sample.class.php");

require_once("../classes/rozelle_order.class.php");

require_once("../classes/fabric.class.php");
require_once("../classes/customer.class.php");


require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$orders 		= new Orders();
$search_obj		= new Search();
$page			= new Pagination();
$stock			= new Stock();

$fabric			= new Fabric();
$customer			= new Customer();
$rozelleOrder			= new Rozelleorders();

$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
//$oid			= $utility->returnGetVar('oid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//$RozorderDtl  = $rozelleOrder->RozDeliverDtl();
	
//if( (isset($_GET['txtColour'])) && (isset($_GET['txtQuantity'])))
//{
	
	$txtColour 	             = $_GET['txtColour'];
	$txtQuantity 	         = $_GET['txtQuantity'];
	$oid  	       			 = $_GET['oid'];
  // echo $oid ;exit;
	//$oid 	               = $_GET['oid'];
	$RozorderDtl  = $rozelleOrder->RozordersDtlDisp($oid);
	
	//echo $oid ;exit;
	$orderDetail = $rozelleOrder->showRozelleOrders($oid);
		//echo $orderDetail[1];exit;
	$designNo		= $orderDetail[1];
	$stockDetails = $stock->showStockDesignwise($designNo);
	

if($txtQuantity == '')
	{
		echo "Put the Quantity value";
	}
	else
	{
		
		
		 $stockDetailsDtl  = $stock->stockDetailsDisplay();
			foreach($stockDetailsDtl as $eachrecord ){
				//echo $eachrecord['colour'];
				//echo $eachrecord['design_no'];exit;
				
				if($txtColour == $eachrecord['colour'] && $orderDetail[1] == $eachrecord['design_no'])
					{
						$total_quantity = $eachrecord['quantity'] - $txtQuantity; 
						$sales = $eachrecord['sales'] + $txtQuantity;
						$netSales = $sales - $eachrecord['quantity_return'];
						if($total_quantity >= 0){
						// stock Details edit
						//echo "hi";exit;
						
						//($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
					
						$txtStock			= $stockDetails[2] - $txtQuantity;  //current stock
						$totalSales		= $txtQuantity + $stockDetails[4];// Total sales
						$net_sales		= $totalSales - $stockDetails[5];// Net Sales	
				//	echo $txtStock;exit;    //no problem//
							
						
						// Rozelle order update
						
						
						//echo count($RozorderDtl);exit;
						foreach($RozorderDtl as $eachrecordDeli ){
					//	echo $eachrecordDeli['colour'];
					//	echo $eachrecordDeli['design_no'];exit;
						
						if($txtColour == $eachrecordDeli['colour'] && $orderDetail[0] == $eachrecordDeli['orders_id'])
							{
							$leftQuantity  = $eachrecordDeli['due_quantity']- $txtQuantity;
							$payQuantity	= $eachrecordDeli['pay_quantity']+$txtQuantity;
							
								if($leftQuantity >= 0){
														// update status of rozelle orders tables
														if($leftQuantity == 0)
														{
															$rozelleOrder->UpdateRozOrders($orderDetail[0],'closed');
														}
														
														
														
								$stock->editstockDetails($eachrecord['stock_dtl_id'],$stockDetails[0],$orderDetail[1], $eachrecord['colour'], $total_quantity,$eachrecord['quantity_in'],
						$sales,$netSales ,$eachrecord['quantity_return'],'', '');
						
									//edit stock
								$stock->editStock($stockDetails[0],$stockDetails[1], $txtStock, $stockDetails[3], $totalSales, $net_sales, $stockDetails[5],
								$stockDetails[6], $stockDetails[7],'');	
								
								// Rozelle orders update
								//$rozelleOrder->UpdateRozelleOrders($oid,$leftQuantity,$payQuantity);
								
								//product deliver
								$rozelleOrder->addRozOrderDeliver($oid,$orderDetail[14],$orderDetail[1],$orderDetail[2],$orderDetail[5],$txtQuantity,$txtColour,'','');
								
								
								// add sales
								$stock->addSales($orderDetail[1], $txtQuantity,$txtColour, $orderDetail[2], $orderDetail[5] ,'' , '', '');
													
														
														
								// update rozelle orders details
								$rozelleOrder->UpdateRozelleOrders($eachrecordDeli['rorder_dtl_id'],$leftQuantity,$payQuantity);
							//	echo $txtColour ;exit;
							echo "Deliver Has been successful";echo "<br>"; 
							
												
							echo "Order Details:";
							$RozOrderDetails         = $rozelleOrder->RozordersDtlDisp($oid);
							If(count($RozOrderDetails) == 0)
								{
								 echo "product not available";
								}
							 $reco_record = 0; 
							//echo "$data[2]";
							foreach( $RozOrderDetails as $eachrecord ){
	
	
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
					 echo $eachrecord['colour']; echo "->";
					 
					 echo $eachrecord['due_quantity']; 
						$reco_record++;
						} 

						exit;	
							
							
							
								}
								else{
									echo "Delivery Quantity greater than order quantity";exit;
								}
							}
						
						}
						
						$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], PRSALODOD001, 'SUCCESS');
						exit;
					
						}else { echo "Current Stock product less than your input values"; exit;}
					}
					/*else {
							$stock->addstockDetails($stockDetails[0], $txtDesignNo, $txtColour, $txtProductIn, '', '');
					}*/
						
		
			}
		
				
		
		//deleting the sessions
		//$utility->delSessArr($sess_arr);
		
		
		
		//forward the web page
		//$uMesg->showSuccessT('success', 0, '', $_SERVER['PHP_SELF'], "Product has been successfully deliver", 'SUCCESS');
		
		echo "Deliver Has been successful";echo "<br>"; 
		
		
		
	}
//}
?>

					
						