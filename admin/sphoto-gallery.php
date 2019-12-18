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

require_once("../classes/employee.class.php"); 
require_once("../classes/stock.class.php"); 
require_once("../classes/sample.class.php"); 
require_once("../classes/photo_gallery.class.php");


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

$employee		= new Employee();
$search_obj		= new Search();
$pages			= new Pagination();

$stock			= new Stock();
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

//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

$sphotoGL		= $photogallery->sPhotoAllData();

$numResDisplay	= (int)$utility->returnGetVar('numResDisplay', 20);
$userId			= $utility->returnSess('userid', 0);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Sample Photo Gallery Maintenance</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- DataTables -->
  
<!--<link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../style/bootstrap/js/bootstrap.min.js"></script>-->
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


<style>

.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}


</style>

</head>


<script type='text/javascript'>
    //<![CDATA[
      $(document).ready(function() {
        $('.filter').multifilter()
      })
    //]]>
  </script>
  
 <script>
$(document).ready(function(){
  $('#example').dataTable().yadcf([
		{column_number : 8,  filter_type: "range_date", filter_container_id: "filterDate"}
	
		]);
});
</script>	 
 
<script>
 $(document).ready(function(){
     $('#example').dataTable()
		  .columnFilter({ 	sPlaceHolder: "head:before",
					aoColumns: [ 	{ type: "text" },
				    	 		{ type: "text" },
                                { type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" },
								{ type: "text" }
								
								//{ type: "date-range" }
								
						]

		});
}); 


</script>

  
  


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
                	<h1>Sample Photo Gallery Maintenance</h1>
                   <div class="cl"></div> 
                </div>
                
                <!-- Options --><br><br><br><br>
                <div id="options-area">
                	<div class="add-new-option">
                    	<a href="#" onClick="MM_openBrWindow('add-sample-gallery.php?action=add_img','AddImg','scrollbars=yes,width=700,height=600')">
						  Add New Photo					  
						</a> 
                    </div>
                </div>
							
              <div class="padT30"><!-- --> </div> 
               <div id="PrintForm">

                <!-- Display Data -->
                <div id="data-column" style="position:relative; bottom: 50px;">
                	<table id="example" class="single-column table table-fixed" cellpadding="0" cellspacing="0" >
                        <!-- display option -->
                        <?php 
						if(count($sphotoGL) == 0)
						{
						?>
                        <tr align="left" class="orangeLetter">
                          <td height="20" colspan="5"> <?php echo "Table is empty"; ?></td>
                         </tr>
                        <?php 
                        }
                        else
                        {
                        ?>  
                        <thead>
						<tr>
                          <th width="3%" height="25"  align="center">Sl No.</th>
						 <!-- <th width="3%" height="25"  align="center">Stock Id</th> -->
						  <th width="10%" >Factory Name</th>
						  <th width="10%" >Design No</th>
						  <th width="10%" >Price</th>
						  <th width="10%" >Status</th>
						  <th width="7%" >Images</th>
						  <th width="15%" >Added By</th>
						  <th width="15%" >Added Date</th>
						  
						 <th width="15%" align="center">Action</th>
						</tr>  
                        </thead>
						<tbody >
                       <?php 
                        $sl=1;
	                    $k = $pages->getPageSerialNum($numResDisplay);
						//	$sid = array_slice($sid, $start, $limit);     
                        foreach($sphotoGL as $eachRecord)
                            {
							
							//$sampleDetail 		= $sample->showSampleDtls($eachRecord['sample_id']);
							//$empdata 				= $employee->showEmployee($eachRecord['emp_id']);
							
							$factoryDtls 			= $sample->showFactory($eachRecord['factory_id']);
							
							$bgColor 	= $utility->getRowColor($k);	
							
                    ?>
                      <tr align="left"<?php $utility->printRowColor($bgColor);?> >
					   <td align="left"><?php echo $sl; ?></td>
					   <td align="center"><?php echo $factoryDtls[1]; ?></td>
					   <td align="center"><?php echo $eachRecord['design_no']; ?></td>
					   <td align="center"><?php echo $eachRecord['pprices']; ?></td>
					   <td align="center"><?php echo $eachRecord['pstatus']; ?></td>
					   
					   <td align="center">
					 	<?php 
							if(($eachRecord['thumb_image'] != '') && ( file_exists("../images/spgallery/thumb/".$eachRecord['thumb_image'])) )
							{
								echo $utility->imageDisplay2('../images/spgallery/thumb/', $eachRecord['thumb_image'], 50, 50, 0, '', $eachRecord['sample_gallery_id']);
	
							}
						?>
                      </td>
						<td align="center"><?php echo $eachRecord['added_by']; ?></td>
						<td><?php echo $dateUtil->printDate($eachRecord['added_on']); ?></td>
					   
					   <td align="center">
					   <p href="#" 
						    onClick="MM_openBrWindow('sphoto-gallery-add.php?action=Add_Image&sgid=<?php echo $eachRecord['sample_gallery_id']; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						    Add More Images		  
						</p> 
						<p href="#" 
						    onClick="MM_openBrWindow('sphoto-gallery-edit.php?action=Edit_Gallery&sgid=<?php echo $eachRecord['sample_gallery_id']; ?>','stockEdit','scrollbars=yes,width=750,height=600')">
						    Edit	  
						</p> 
					   </td>
					  
					  	
				     </tr>
                      <?php 
						$sl++;
                            }
                      }
                      ?>
					</tbody>  
                  </table>
                   
                    <div class="first-column">
                  </div>
                  
                </div>
                <!-- eof Display Data -->
               </div> 
                <div class="cl"></div>
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
	
	<!--Used for print-->
	<script type="text/javascript">     
        function PrintDiv() {    
           var PrintForm = document.getElementById('PrintForm');
           var popupWin = window.open('', '_blank', 'width=800,height=800');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + PrintForm.innerHTML + '</html>');
           popupWin.document.close();
                }
    </script>

	<!--end print process-->

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>	
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>

-->	
<script>
  $(function () {
    $("#example").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>	
	
     
</body>
</html>