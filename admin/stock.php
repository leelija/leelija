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
require_once("../classes/stock.class.php");

require_once("../classes/report.class.php");


require_once("../classes/sample.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();

$orders		    = new Orders();

$search_obj		= new Search();
$pages			= new Pagination();

$report			= new Report();

$stock			= new Stock();

$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$keyword		= $utility->returnGetVar('keyword','');
$type			= $utility->returnGetVar('type','');
$mode			= $utility->returnGetVar('mode','');
$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 10);
$userId			= $utility->returnSess('userid', 0);

//NO OF PRODUCTS
if((isset($_POST['btnShowDtls'])))
{

$designNo				= $_POST['txtDesignNo'];
$_SESSION['$designNo']  =  $designNo;   

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> -  Stock Maintenance</title>
<!-- Style -->
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
-->
<link href="../style/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">


<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
<script type="text/javascript" src="../js/static.js"></script>

<script type="text/javascript" src="../js/product_report.js"></script>
<!-- eof JS Libraries -->

</head>

<body>
	
	
    <!-- Header -->
	<?php require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<div id="admin-menu">
				<?php require_once('menu.inc.php'); ?>
            </div>
            
            <!-- Inner  -->
            <div id="admin-body">
            	
                <div id="admin-top">
                	<h1>Stock Maintenance</h1>
                   <div class="cl"></div> 
                </div>
                
                <div class="row"><!---row start -->
					<div class="col-lg-12">
					<!--Report form start-->   
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
						<div class="row"><!---row start -->
							<div class="col-lg-12">
								<div class="col-lg-3">
									<div class="form-group">
										<label>Design No.</label>
										<input type="text" id="txtDesignNo" name="txtDesignNo" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-1">
									<label></label><br><br><br>
									<input  class="btn btn-primary" name="btnShowDtls" type='submit' value="Show details"  />
								</div>
							</div>
						</div><!---row end -->	
						
					</form>		
					<!--Report form end-->
					
					</div>
                </div><!---row end -->
				<div class="row"><!---row start -->
				
					<!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 90px;">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                       <?php
                        if((isset($_SESSION['$designNo'])))
						{
							$stockDetail = $stock->showStockDesignwise($_SESSION['$designNo']);
						
                        ?>  
                        <thead>
						<tr>
                          <th width="10%" >#</th>
						  <th width="10%" >Design No. </th>
						  <th width="10%" >Current Stock</th>
						  <th width="10%" >Product In</th>
						  <th width="10%" >Sales</th>
						  <th width="10%" >Net Sales</th>
						  <th width="7%" >Goods Return </th>
						  <th width="15%" > Remarks</th>
						 <th width="10%" > Date</th> 
						 <th width="15%" align="center">Action</th>
						</tr>  
                        </thead>
						<tbody>
                       <?php 
                        
							$k = $pages->getPageSerialNum($numResDisplay);
							$date=date_create($stockDetail[8]);
							
							$bgColor 	= $utility->getRowColor($k);	
							
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?>>
					   <td align="center"><?php echo $stockDetail[0]; ?></td>
					   <td align="center"><?php echo $stockDetail[1]; ?></td>
						<td align="center"><?php echo $stockDetail[2]; ?></td>
					   <td align="center"><?php echo $stockDetail[3]; ?></td>
					   <td align="center"><?php echo $stockDetail[4]; ?></td>
					   <td align="center"><?php echo $stockDetail[12]; ?></td>
					   <td align="center"><?php echo $stockDetail[5]; ?></td>
					   <td align="center"><?php echo $stockDetail[6]; ?></td>
					   <td align="center"><?php echo date_format($date,"m/d/Y"); ?></td>
					  
					   	<td >
						    
							<p href="#" 
						  onClick="MM_openBrWindow('stock_prod_in.php?action=edit_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						  Product In					  </p> 
						 
						    
							<p href="#" 
						  onClick="MM_openBrWindow('product_sale.php?action=edit_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						  Sales					  </p> 
						  
						   
							<p href="#" 
						  onClick="MM_openBrWindow('goods_return.php?action=edit_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						  GR					  </p> 
						  
					   <!--   [ 
							<a href="#" 
						  onClick="MM_openBrWindow('greturn_update.php?action=edit_sid&sid=<?php //echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						  GR Update					  </a> ]  -->
						<?php 
							if($userData[10] == 'monisadia' OR $userData[10] == 'safikul' OR $userData[10] == 'tamim786'){
						?>		
								<p href="#" 
								  onClick="MM_openBrWindow('stock_edit.php?action=edit_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
								  Edit Design No					  </p> 
						<?php
							}
							?>
						<!--  [ 
						  <a href="#" onClick="MM_openBrWindow('stock_delete.php?action=del_sid&sid=<?php echo $stockDetail[0]; ?>','OrdDelete','scrollbars=yes,width=400,height=350')">
						  delete					  </a> ]<br>  -->
						  
					</td>		
				     </tr>
                      <?php 
                      }else{
                      ?>
					
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo " Design no. not available please add this design"; ?>
							<a href="stock_product.php">ADD</a>
						  </td>
                        </tr>
                        <?php 
                        }
					 ?> 
					  
					  
					</tbody>  
                  </table>
                     
					<a onclick="PrintDiv();" class="add-icon tooltip1" title="Print Payment Details">Print</a>
		

					 
                    <div class="first-column">
                 
                    	<!-- Bottom Pagination-->
                     <!--   <div class="pagination-bottom">
                            <div class="upper-block">Total Report: <?php echo count($sid);?></div>
                            <div class="lower-block"><?php //$pages->getPage($numPages, $link, $pageNumber, $pageArray);?>
                            </div>
							<?php //echo $pagination ?>
                        </div>  -->
                  </div>
                  
                </div>
                <!-- eof Display Data -->
					
					
                </div><!---row end -->
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
     
</body>
</html>