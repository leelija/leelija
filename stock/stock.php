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

require_once("../classes/report.class.php");
require_once("../classes/product_stock.class.php"); 


require_once("../classes/sample.class.php"); 

require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/photo_gallery.class.php");

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

$productStock	= new ProductStock();

$sample			= new Sample();
$photogallery	= new PhotoGAllery();

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
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- DataTables -->
  
<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

<!-- eof Style -->
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

<!--   multi filter -->
<script src='../js/multifilter.js'></script>
<script src="../js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.yadcf.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
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
					 <!-- Options --><br><br><br><br>
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="<?php echo "stock_add.php"."?action=add_stock"; ?>">
                            Add New Design
                        </a> 
                    </div>
					<a href="download_excel.php?table=stock_products">Download</a>
                </div><br><br>
                </div><!---row end -->
				<div class="cl"></div><br><br>
				<div class="row"><!---row start -->
				
					<!-- Display Data -->
                <div id="data-column" style="">
                	<table id="example" class="single-column" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                       <?php
                        if((isset($_SESSION['$designNo'])))
						{
							$stockDetail 			= $productStock->showPStockDesignwise($_SESSION['$designNo']);
							$photoGallDtls 			= $photogallery->showSampleGalleryDgn($_SESSION['$designNo']);
                        ?>  
                        <thead>
						<tr>
						 <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
						  <th width="10%" > Image</th>
						  <th width="8%" >Design No. </th>
						  <th width="8%" >Current Stock</th>
						  <th width="8%" >Product In</th>
						  <th width="8%" >Sales</th>
						  <th width="8%" >Net Sales</th>
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
					  
						<td align="center">
					 	<?php 
						if(count($photoGallDtls[6]) != 0)
						{
							
							if(($photoGallDtls[6] != '') && ( file_exists("../images/spgallery/thumb/".$photoGallDtls[6])) )
							{
							$design 		= $stockDetail[1];
						?>	
								
								<img onClick="showImageModal('<?php echo $_SESSION['$designNo'];?>');" src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" width="50" height="50" 
								data-toggle="modal" data-target="#ImageModal"  
								title="<?php echo $stockDetail[1]; ?>" >
							
							<!--<img id="myImg" src="../images/spgallery/large/<?php echo $photoGallDtls[6];?>" alt="<?php echo $photoGallDtls[6];?>" width="50" height="50">-->
						<?php	
							}
						}
						?>
                       </td>
					  
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
							onClick="MM_openBrWindow('stock_prod_in.php?action=add_prod&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
							Product In					  </p> 
						
							<p href="#" 
							onClick="MM_openBrWindow('product_sale.php?action=sale_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
							Sales					  </p> 
						  
							<p href="#" 
							onClick="MM_openBrWindow('products_return.php?action=edit_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
							GR					  </p> 
						 
							[ 
							<a href="order_add.php?action=add_ord&sid= <?php echo $stockDetail[0]; ?>" style="color:red;">
							Order					  </a> ]
						  
					   
						<?php 
						//	if($userData[2] == 'Safikul'){
						?>		
							<p href="#" 
						    onClick="MM_openBrWindow('stock_edit.php?action=sale_sid&sid=<?php echo $stockDetail[0]; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						    Edit					  
							</p> 
						<?php
						//	}
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
							<a href="stock_add.php">ADD</a>
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
