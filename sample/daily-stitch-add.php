<?php 
session_start();
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");
require_once("../includes/registration.inc.php");
require_once("../includes/email.inc.php");
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php");  
require_once("../classes/error.class.php"); 
require_once("../classes/search.class.php");
require_once("../classes/pagination.class.php");
require_once("../classes/employee.class.php");
require_once("../classes/daily_comp_stitch.class.php");
require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");
require_once("../classes/utilityNum.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$search_obj		= new Search();
$page			= new Pagination();

$employee		= new Employee();
$dStitch		= new DailyStitch();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
//admin detail
$userData 		=  $adminLogin->getUserDetail($_SESSION[ADM_SESS]);

if(isset($_POST['btnAddRecord']))
{	
	$txtOperator 	        = $_POST['txtOperator'];
	$txtCompNo 	        	= $_POST['txtCompNo'];
	$txtShift	 			= $_POST['txtShift'];
	$txtStitchNo	 		= $_POST['txtStitchNo'];
	$txtNote	 			= $_POST['txtNote'];
	$txtOrderId 	        = '';
	$txtDesignNo 	        = '';
	$txtWorkedDate 	        = $_POST['txtWorkedDate'];
	
	$selNum 	        	= $_POST['selNum'];
	
	$amount 				= ($txtStitchNo / 100) * .8;
	
	
	//registering the post session variables
	$sess_arr	= array('txtOperator','txtCompNo', 'txtShift','txtStitchNo', 'txtNote');
	$utility->addPostSessArr($sess_arr);

	
	//defining error variables
	$action		= 'add_emp';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addEmp';
	$typeM		= 'ERROR';
	
	$msg = '';

	//field validation
	if($txtOperator=='')
	{
		echo "Fill The Operator Name Field";
	}
	
	elseif($txtCompNo=='')
	{
		echo "Fill Up The Computer no. Field";
	}
	elseif($txtShift=='')
	{
		echo "Fill Up Shift Field";
	}
	else
	{
		
		$empDtls 				= $employee->showEmployee($txtOperator);
		//add the Daily Stitch
		$dcsId 	= $dStitch->addDailyStitch($txtOperator,$empDtls[2],$txtCompNo, $txtShift, $txtStitchNo,$amount,0,'',$txtOrderId,$txtDesignNo,$txtNote,$txtWorkedDate,$userData[10],'No');
		
		for($i=0; $i < $selNum; $i++)
			{
				$prodtype 		= $_POST['txtProdType'][$i];
				$rstitch 		= $_POST['txtStitch'][$i];
				$noofHead 		= $_POST['txtNoOfHead'][$i];
				
				if($prodtype == "sample" )
				{
					$roffer 			= ($rstitch / 100000 ) * 100;
				}
				elseif($prodtype == "cod" ){
					$roffer 			= ($rstitch / 100000 ) * 110;
				}
				elseif($prodtype == "badla" ){
					$roffer 			= ($rstitch / 100000 ) * 155;
				}
				else{
					if($noofHead 	== 16 )
						{
							if($txtStitchNo < 300000 ){
								$txtOffer 	        = ($txtStitchNo / 100000 ) * 90;
								$roffer 			= ($rstitch / 100000 ) * 90;
							}
							elseif($txtStitchNo >= 300000 AND $txtStitchNo < 360000)
								{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 120;
									$roffer 			= ($rstitch / 100000 ) * 120;
								}
							elseif($txtStitchNo >= 360000 AND $txtStitchNo < 420000)
								{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 140;
									$roffer 			= ($rstitch / 100000 ) * 140;
								}
							else{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 160;
									$roffer 			= ($rstitch / 100000 ) * 160;
								}
							
						}else{
							
							$lessHead 				= 16 - $noofHead;
							$hpercentage 			= 3 * $lessHead;
						
							if($txtStitchNo < 300000 ){
								$txtOffer 	        = ($txtStitchNo / 100000 ) * 90;
								$offer 				= ($rstitch / 100000 ) * 90;
								$roffer				= $offer - $offer * $hpercentage / 100;
							}
							elseif($txtStitchNo >= 300000 AND $txtStitchNo < 360000)
								{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 120;
									$offer 				= ($rstitch / 100000 ) * 120;
									$roffer				= $offer - $offer * $hpercentage / 100;
								}
							elseif($txtStitchNo >= 360000 AND $txtStitchNo < 420000)
								{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 140;
									$offer 				= ($rstitch / 100000 ) * 140;
									$roffer				= $offer - $offer * $hpercentage / 100;
								}
							else{
									$txtOffer 	        = ($txtStitchNo / 100000 )* 160;
									$offer 				= ($rstitch / 100000 ) * 160;
									$roffer				= $offer - $offer * $hpercentage / 100;
								}
						
						}
					}	
				//Daily Stitch Display
				$stitchDtls 	= $dStitch->showDailyStitch($dcsId);
				$tsOffer		= $stitchDtls[11] + $roffer;
				//Update Stitch Offer
				$dStitch->StitchOffer($dcsId, $tsOffer,$userData[10]);
				
				//echo $_POST['txtColor'][$i];
				$dStitch->addDailyStitchDtls($dcsId,$_POST['txtOrderId'][$i],$_POST['txtDesignNo'][$i],$_POST['txtStitch'][$i],$_POST['txtNoOfHead'][$i],$roffer);
			}				
		
		//forward
		$uMesg->showSuccessT('success', $id, 'id', $_SERVER['PHP_SELF'], "Stitch Records has been successfully added", 'SUCCESS');
	}
	
	//deleting the sessions
	$utility->delSessArr($sess_arr);
		
}//eof add product





?>

<title><?php echo COMPANY_S; ?> -  Add Sample Records</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
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
<script type="text/javascript" src="../js/comp-round.js"></script>
<!-- eof JS Libraries -->
<!--Jquery Calender-->
<script src="../js/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="../js/jQuery/jquery-ui.min.js" type="text/javascript"></script>
<!--Jquery Calender-->  

<!-- TinyMCE --> 
 <script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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


</head>


	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
        if( (isset($_GET['action'])) && ($_GET['action'] == 'sample_add') )
        {
             
            //$ordDetail = $orders->showOrders($oid);
        ?>
		
<h3></h3>
    
          <form action="<?php $_SERVER['PHP_SELF']?>?action=sample_add" method="post" enctype="multipart/form-data">
         
		 
		 <h2><a name="addUser">Add Sample Products Details</a></h2>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
							<div class="cl"></div>
							<div >
								<label>Operator Name<span class="orangeLetter">*</span></label>							
								<select name="txtOperator" type="text" id="txtOperator" class="text_box_large">
								<?php
									$empDetails         = $employee->getComopName('hmdad');
									foreach ($empDetails as $row){//Array or records stored in $row
									//echo $row[colour_name];
									echo "<option value=$row[emp_id]>$row[emp_name]</option>"; 

									/* Option values are added by looping through the array */ 
													
									}

									echo "</select>";//?>
							</div>
							
							<div class="cl"></div>
                            <label>Computer No.<span class="orangeLetter">*</span></label>
                            <input name="txtCompNo" type="text" class="text_box_large" id="txtCompNo" size="25" />
                            <div class="cl"></div>
							
							<div >
								<label>Shift<span class="orangeLetter">*</span></label>							
								<select name="txtShift" class="form-control input-lg" id="txtShift" required>
									<option value="">Select any one</option>
									<option value="Day">Day</option>
									<option value="Night">Night</option>
								</select>
							</div>
							<div class="cl"></div>
							
							<tr>
								<label>Select No. of Round</label>
								<!--<td align="left" class="menuText">Select No. Type </td>-->
								<td align="left" class="bodyText pad5">
									<?php 
									//gen number array
									$arr_value	= range(1,13);
									$arr_label	= range(1,13);
									?>
									  <select name="selNum" id="selNum" onchange="return getCompRoundType();"
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
									  </select>				   
								</td>
							</tr>
								<div class="cl"></div>
								<div id="showCompRoundType"></div>
							
							
							<div class="cl"></div>
                            <label>Total Stitch<span class="orangeLetter">*</span></label>
                            <input name="txtStitchNo" type="text" class="text_box_large" id="txtStitchNo" size="25" />
                            <div class="cl"></div>
							
							<div class="cl"></div>
                            <label>Worked Date<span class="orangeLetter">*</span></label>
                            <input name="txtWorkedDate" type="date" class="text_box_large" id="txtWorkedDate" size="25" />
                            <div class="cl"></div>
							
							 <label>Note</label>
                            <textarea  name="txtNote" id="txtNote">
							<?php $utility->printSess2('txtNote',''); ?>
                            </textarea>
                                                                    
					<input name="btnAddRecord" type="submit" class="button-add"  value="Add" />
               
                <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
        	</form>
    
        <?php 
        }
        ?>
    </div>
	
	
<script>	

$(document).ready(function() {
    $("#txtStitchNo").keyup(function() {
	//alert('hi..');
        var grandTotal = 0;
        $("input[name='txtStitch[]']").each(function (index) {
            var txtStitch = $("input[name='txtStitch[]']").eq(index).val();
            //var price = $("input[name='price[]']").eq(index).val();
            //var output = parseInt(qty) * parseInt(price);
	
            if (!isNaN(txtStitch)) {
				$("input[name='txtStitch[]']").eq(index).val(txtStitch);
				grandTotal = parseInt(grandTotal) + parseInt(txtStitch);    
            	$('#txtStitchNo').val(grandTotal);
            }
        });
    });
});
</script>
