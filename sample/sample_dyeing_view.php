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

$sample			= new Sample();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');
$sid			= $utility->returnGetVar('sid','0');

$userId			= $utility->returnSess('userid', 0);
$customerDtl	= $customer->getCustomerData($userId);

//echo $customerDtl[2];exit;
$sampleDtl=$sample->showSample($sid);






?>

<title><?php echo COMPANY_S; ?>View sample Dyeing</title>

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
<script type="text/javascript" src="../js/product.js"></script>
<!-- eof JS Libraries -->

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
	$uMesg->dispMessage($typeM, 'images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	
    <div class="webform-area">		
		<?php 
        //form
    /*    if( (isset($_GET['action'])) && ($_GET['action'] == 'view_colour') )
        {
             
            $sampleDetails = $sample->showSample($sid);*/
        ?>
		
<h2><a name="editStock">View Sample Dyeing Fabric</a></h2>
    
          
		  <table border="1" cellpadding="0" cellspacing="0" width="100%" id="myTable" class="tblListForm">
						<tr class="listheader">
						
						<th class="listheader">Fabric</th>
						<th class="listheader">F.Amount(meter)</th>
						<th class="listheader">F.Rate/Meter </th>
						<th class="listheader">Total F. cost</th>
						<th class="listheader">Labour Rate/meter</th>
						<th class="listheader">Total Labour Cost</th>
						<th class="listheader">Total Cost</th>
						<th class="listheader">Time</th>
						<th class="listheader">Remarks</th>
						<th class="listheader">Action</th>
						</tr>

						<?php 

							$SamDyeingDtl 		= $sample->getAllfabricDtl($sid);
							?>	
							<?php $reco_record = 0; 
							//echo "$data[2]";
							foreach( $SamDyeingDtl as $eachrecord ){
	
	
							//$bgColor 	= $utility->getRowColor($i);
							if($reco_record%2==0)
							$classname="evenRow";
							
								else
									$classname="oddRow";
  
						?>

						<tr class="table-row" >
							
							<td align="center"><?php echo $eachrecord ['fabric_name']; ?></td>
							<td align="center"><?php echo $eachrecord ['fab_amount']; ?></td>
							<td align="center"><?php echo $eachrecord ['rate_per_meter']; ?></td>
							<td align="center"><?php echo $eachrecord ['fab_amount'] * $eachrecord ['rate_per_meter']; ?></td>
							<td align="center"><?php echo $eachrecord ['labour_rate']; ?></td>
							<td align="center"><?php echo $eachrecord ['labour_cost'];?></td>
							<td align="center"><?php echo $eachrecord ['total_cost']; ?></td>
							<td align="center"><?php echo $eachrecord ['total_time'];?></td>
							<td align="center"><?php echo $eachrecord ['remarks'];?></td>
							<td align="center">
							
							<a href="#" 
							  onClick="MM_openBrWindow('sample_dyeing_delete.php?action=del_sdye&sid=<?php echo $eachrecord ['fabric_id']; ?>','delDye','scrollbars=yes,width=400,height=400')">
							  Delete					  </a> 
							 
							<a href="#" 
							  onClick="MM_openBrWindow('sample_dyeing_edit.php?action=del_sdye&fid=<?php echo $eachrecord ['fabric_id']; ?>','delDye','scrollbars=yes,width=600,height=600')">
							  Edit					  </a> 
							 
							</td>
						
						
						</tr>
						
						

						<?php 

						$reco_record++;
						} 
						?>
						
					</table>
					
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<div style="float:right;">
		  <input name="btnCancel" type="submit" class="button-cancel" value="cancel" onClick="self.close()" />
		</div>
		  
		  
	  
		  
    </div>
