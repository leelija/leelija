<?php 
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
require_once("../classes/sample.class.php");
require_once("../classes/employee.class.php");
require_once("../classes/company.class.php"); 
require_once("../classes/vendor.class.php"); 

require_once("../classes/customer.class.php");
require_once("../classes/product_status.class.php");
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
$sample			= new Sample();
$company		= new Company();
$vendor			= new Vendor();

$customer		= new Customer();
$status			= new Pstatus();
$employee		= new Employee();

$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();
$uNum 			= new NumUtility();

######################################################################################################################

//declare vars
$typeM			= $utility->returnGetVar('typeM','');

$sid			= $utility->returnGetVar('sid','0');

//User detail
$userData 		=  $customer->getCustDatabyEmail($_SESSION[ACC_SESS]);


//add a product
if(isset($_POST['btnAddPay']))
{	
	$txtVenName 	    = $_POST['txtVenName'];
	$txtVenCompany	 	= $_POST['txtVenCompany'];
	$txtVenAddrs	 	= $_POST['txtVenAddrs'];
	$txtVenCont	 		= $_POST['txtVenCont'];
	$txtVenGST	 		= $_POST['txtVenGST'];
	$txtVenBalance	 	= $_POST['txtVenBalance'];
	$txtVenTDS	 		= $_POST['txtVenTDS'];

	//registering the post session variables
	$sess_arr	= array('txtVenName','txtVenCompany', 'txtVenAddrs', 'txtVenCont', 'txtVenGST','txtVenTDS');

	$utility->addPostSessArr($sess_arr);
	
	//defining error variables
	$action		= 'add_cmpAcc';
	$url		= $_SERVER['PHP_SELF'];
	$id			= 0;
	$id_var		= '';
	$anchor		= 'addProd';
	$typeM		= 'ERROR';
	
	
	$msg = '';

	if($txtVenName =='')
	{
		echo "Put the Vendor Name";
	}
	elseif($txtVenCompany == ''){
		echo "Put the Vendor Company Name";
	}
	else
	{
		//add New Vendor Records
		$vendor->addVendor($txtVenName, $txtVenCompany, $txtVenAddrs,$txtVenCont,$txtVenGST,$txtVenBalance,$txtVenTDS,$userData[2]);
		
		//deleting the sessions
		$utility->delSessArr($sess_arr);
		
		//forward the web page
		$uMesg->showSuccessT('success', 0, '', 'vendor-dtls.php', "Vendor Details has been successfully added", 'SUCCESS');
	}
	
}//eof add emp payment book entry


//cancel adding product
if(isset($_POST['btnCancel']))
{
	
	//hold in session array
	$vendor->addVendor($txtVenName, $txtVenCompany, $txtVenAddrs,$txtVenCont,$txtVenGST,$userData[2]);
	
	//forward
	header("Location: vendor-dtls.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo COMPANY_S; ?> - Add Sales</title>

<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!--Custom --->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="js/date_pic/date_input.css">
<link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

<!--CSS Jquery Calender-->
<link rel="stylesheet" href="../style/jQuery/jquery-ui.css" type="text/css" media="all" />
<!--CSS Jquery Calender-->


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
<script type="text/javascript" src="../js/category.js"></script>
<script type="text/javascript" src="../js/product.js"></script>

<script type="text/javascript" src="../js/sample_product.js"></script>
<script type="text/javascript" src="../js/order_colour.js"></script>
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
<script type="text/javascript">
function contentTitleCopy()
{
	var x=document.getElementById("txtProdName").value;
	document.getElementById("txtPageTitle").value=x;
}
</script>

<!-- jQuery & JS files -->
	<?php include_once("tpl/common_js.php"); ?>
	<script src="js/script.js"></script>  
    <script src="js/date_pic/jquery.date_input.js"></script>  
    <script src="lib/auto/js/jquery.autocomplete.js "></script>    
	<script  src="dist/js/jquery.ui.draggable.js"></script>
<script src="dist/js/jquery.alerts.js"></script>
<script src="dist/js/jquery.js"></script>
<link rel="stylesheet"  href="dist/js/jquery.alerts.css" >
	<script type="text/javascript">
$(function() {
    
    	$("#supplier").autocomplete("party.inc.php", {
		width: 160,
		autoFill: true,
		selectFirst: true
	});
    	$("#item").autocomplete("stock.php", {
		width: 160,
		autoFill: true,
		mustMatch: true,
		selectFirst: true
	});
        $("#item").blur(function()
			{
                          document.getElementById('total').value=document.getElementById('sell').value * document.getElementById('quty').value 
                        });
        $("#item").blur(function()
			{
			 
							
			 $.post('check_item_details.php', {stock_name1: $(this).val() },
				function(data){
                                                              
								$("#sell").val(data.sell);
								$("#stock").val(data.stock);
								$('#guid').val(data.guid);
								if(data.sell!=undefined)
								$("#0").focus();
								
								
							}, 'json');
											
					

			
			});
        $("#supplier").blur(function()
			{
			 
							
			 $.post('party-dtls.inc.php', {stock_name1: $(this).val() },
				function(data){
				
								$("#address").val(data.address);
								$("#contact1").val(data.contact1);
								
								if(data.address!=undefined)
								$("#0").focus();
								
							}, 'json');
											
					

			
			});
 $('#test1').jdPicker();
 $('#test2').jdPicker();
		


		var hauteur=0;
		$('.code').each(function(){
			if($(this).height()>hauteur) hauteur = $(this).height();
		});

		$('.code').each(function(){ $(this).height(hauteur); });
	});

        </script>
		<script>
	/*$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});*/
	$(document).ready(function() {
	document.getElementById('bill_no').focus();
		// validate signup form on keyup and submit
		$("#form1").validate({
			rules: {
				bill_no: {
					required: true,
					minlength: 3,
					maxlength: 200
				},
				stockid: {
					required: true					
				},				
				grand_total: {
					required: true					
				},				
				supplier: {
					required: true,					
				},
				payment: {
					required: true,					
				}
			},
			messages: {
				supplier: {
					required: "Please Enter Supplier"					
				},
				stockid: {
					required: "Please Enter Stock ID"
				},
				payment: {
					required: "Please Enter Payment"
				},
				grand_total: {
					required: "Add Stock Items"
				},
				bill_no: {
					required: "Please Enter Bill Number",
                                        minlength: "Bill Number must consist of at least 3 characters"
				}
			}
		});
	
	});
function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=27 && unicode!=38 && unicode!=39 && unicode!=40 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
        return false
    }
    }
  
	
	</script>
	
<script type="text/javascript">
           function remove_row(o) {
    var p=o.parentNode.parentNode;
         p.parentNode.removeChild(p);
           }
     function add_values(){
         if(unique_check()){
    
         if(document.getElementById('edit_guid').value==""){
     if(document.getElementById('item').value!="" && document.getElementById('quty').value!="" &&  document.getElementById('total').value!="" ){
     
                    if(document.getElementById('quty').value!=0){
                        code=document.getElementById('item').value;
  
    quty=document.getElementById('quty').value;
    sell=document.getElementById('sell').value;
    disc=document.getElementById('stock').value;
    total=document.getElementById('total').value;
    item=document.getElementById('guid').value;
    main_total=document.getElementById('posnic_total').value;
    roll=parseInt(document.getElementById('roll_no').value);
 
    $('<tr id='+item+'><td><lable id='+item+'roll class=jibi007 >'+roll+'</label></td><td><input type=hidden value='+item+' id='+item+'id ><input type=text name="stock_name[]"  id='+item+'st style="width: 150px" class="round  my_with" readonly="readonly" ></td><td><input type=text name=quty[] readonly="readonly" value='+quty+' id='+item+'q class="round  my_with" style="text-align:right;" ></td><td><input type=text name=sell[] readonly="readonly" value='+sell+' id='+item+'s class="round  my_with" style="text-align:right;"  ></td><td><input type=text name=stock[] readonly="readonly" value='+disc+' id='+item+'p class="round  my_with" style="text-align:right;" ></td><td><input type=text name=jibi[] readonly="readonly" value='+total+' id='+item+'to class="round  my_with" style="width: 120px;margin-left:20px;text-align:right;" ><input type=hidden name=total[] id='+item+'my_tot value='+main_total+'> </td><td><input type=button value="" id='+item+' style="width:30px;border:none;height:30px;background:url(images/edit_new.png)" class="round" onclick="edit_stock_details(this.id)"  ></td><td><input type=button value="" id='+item+' style="width:30px;border:none;height:30px;background:url(images/close_new.png)" class="round" onclick=reduce_balance("'+item+'");$(this).closest("tr").remove(); ></td></tr>').fadeIn("slow").appendTo('#item_copy_final');
    document.getElementById('quty').value="";
    document.getElementById('sell').value="";
    document.getElementById('stock').value="";
    document.getElementById('roll_no').value=roll+1;
    document.getElementById('total').value="";
    document.getElementById('item').value="";
    document.getElementById('guid').value="";
    if(document.getElementById('grand_total').value==""){
        document.getElementById('grand_total').value=main_total;
    }else{
    document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(main_total);
    }
     document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
    document.getElementById(item+'st').value=code;
    document.getElementById(item+'to').value=total;
}else{
     alert('No Stock Available For This Item');
}
}else{
     alert('Please Select An Item');
    }
    }else{
    id=document.getElementById('edit_guid').value;
    document.getElementById(id+'st').value=document.getElementById('item').value;  
    document.getElementById(id+'q').value=document.getElementById('quty').value;
    document.getElementById(id+'s').value=document.getElementById('sell').value;
    document.getElementById(id+'p').value=document.getElementById('stock').value;
    document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(document.getElementById('posnic_total').value)-parseFloat(document.getElementById(id+'my_tot').value);
    document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
    document.getElementById(id+'to').value=document.getElementById('total').value;
    document.getElementById(id+'id').value=id;

    document.getElementById(id+'my_tot').value=document.getElementById('posnic_total').value
    document.getElementById('quty').value="";
    document.getElementById('sell').value="";
    document.getElementById('stock').value="";
    document.getElementById('total').value="";
    document.getElementById('item').value="";
    document.getElementById('guid').value="";
    document.getElementById('edit_guid').value="";
    }
    }
    discount_amount();
    }
    function total_amount(){
    balance_amount();
               
        document.getElementById('total').value=document.getElementById('sell').value * document.getElementById('quty').value
    document.getElementById('posnic_total').value=document.getElementById('total').value;
      //  document.getElementById('total').value = '$ ' + parseFloat(document.getElementById('total').value).toFixed(2);
    if(document.getElementById('item').value===""){
       document.getElementById('item').focus();
   }
    }
   function edit_stock_details(id) {
     document.getElementById('item').value=document.getElementById(id+'st').value;
     document.getElementById('quty').value=document.getElementById(id+'q').value;
    document.getElementById('sell').value=document.getElementById(id+'s').value;
    document.getElementById('stock').value=document.getElementById(id+'p').value;
    document.getElementById('total').value=document.getElementById(id+'to').value;
   
    document.getElementById('guid').value=id;
    document.getElementById('edit_guid').value=id;
     
   }
   function unique_check(){
      if(!document.getElementById(document.getElementById('guid').value) || document.getElementById('edit_guid').value==document.getElementById('guid').value){
            return true;
           
        }else{
           
            alert("This Item is already added In This Purchase");
            document.getElementById('item').focus();
             document.getElementById('quty').value="";
                document.getElementById('sell').value="";
                document.getElementById('stock').value="";
                document.getElementById('total').value="";
                document.getElementById('item').value="";
                document.getElementById('guid').value="";
                document.getElementById('edit_guid').value="";
                return false;
   }
   }
   function quantity_chnage(e){
         var unicode=e.charCode? e.charCode : e.keyCode
                if (unicode!=13 && unicode!=9){
        }
       else{
         add_values();
          
            document.getElementById("item").focus();
           
        }
         if (unicode!=27){
        }
       else{
               
             document.getElementById("item").focus();
        }
   }
    function formatCurrency(fieldObj)
{
    if (isNaN(fieldObj.value)) { return false; }
    fieldObj.value = '$ ' + parseFloat(fieldObj.value).toFixed(2);
    return true;
}
function balance_amount(){
    if(document.getElementById('payable_amount').value!="" && document.getElementById('payment').value!=""){
    data=parseFloat(document.getElementById('payable_amount').value);
    document.getElementById('balance').value=data-parseFloat(document.getElementById('payment').value);
        if(parseFloat(document.getElementById('payable_amount').value) >= parseFloat(document.getElementById('payment').value)){
       
    }else{
        if(document.getElementById('payable_amount').value!=""){
         document.getElementById('balance').value='000.00';
         document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);
        }else{
            document.getElementById('balance').value='000.00';
         document.getElementById('payment').value="";
        }
    }
    }else{
        document.getElementById('balance').value="";
    }

    
}
function stock_size(){
    if(parseFloat(document.getElementById('quty').value) > parseFloat(document.getElementById('stock').value)){
       document.getElementById('quty').value=parseFloat(document.getElementById('stock').value);
    
    console.log();
        }
}
function discount_amount(){
 
        if(document.getElementById('grand_total').value!=""){
            document.getElementById('disacount_amount').value=parseFloat(document.getElementById('grand_total').value)*(parseFloat(document.getElementById('discount').value))/100;
        
        }
        if(document.getElementById('discount').value==""){
             document.getElementById('disacount_amount').value="";
        }
        
        discont=parseFloat(document.getElementById('disacount_amount').value);
    if(document.getElementById('disacount_amount').value==""){
        discont=0;
    }
    document.getElementById('payable_amount').value=parseFloat(document.getElementById('grand_total').value)-discont;
    if(parseFloat(document.getElementById('payment').value)>parseFloat(document.getElementById('payable_amount').value)){
    document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);
         
        }
    
}
function discount_as_amount(){
      if(parseFloat(document.getElementById('disacount_amount').value) > parseFloat(document.getElementById('grand_total').value))
document.getElementById('disacount_amount').value="";

    if(document.getElementById('grand_total').value!=""){
        if(parseFloat(document.getElementById('disacount_amount').value) < parseFloat(document.getElementById('grand_total').value))
       { discont=parseFloat(document.getElementById('disacount_amount').value);
        
         document.getElementById('payable_amount').value=parseFloat(document.getElementById('grand_total').value)-discont;
    if(parseFloat(document.getElementById('payment').value)>parseFloat(document.getElementById('payable_amount').value)){
    document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);
   
    }
    }else{
      // document.getElementById('disacount_amount').value=parseFloat(document.getElementById('grand_total').value)-1;
    }
}
}
function reduce_balance(id){
 var minus=parseFloat(document.getElementById(id+"my_tot").value);
  document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)-minus;
  document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
   discount_amount();
   var elements = document.getElementsByClassName('jibi007');
var j=1;
var my_id=id+'roll';
for (var i = 0; i < elements.length; i++) {
    elements[0].value=1;
   if(parseFloat(document.getElementById(my_id).innerHTML)==i){
     elements[i].innerHTML =parseFloat(elements[i-1].innerHTML)
   }else{
       if(i!=0){
         elements[i].innerHTML =parseFloat(elements[i-1].innerHTML)+1;
        j++;
       }
   }
     document.getElementById('roll_no').value=elements.length;
}
   //console.log(id);
}
function discount_type(){
    if(document.getElementById('round').checked){
        document.getElementById("discount").readOnly=true;
        document.getElementById("disacount_amount").readOnly=false;
        if(parseFloat(document.getElementById('grand_total'))!=""){
            document.getElementById('disacount_amount').value="";
            document.getElementById('discount').value="";
            discount_amount();
        }
    }else{
        document.getElementById("discount").readOnly=false;
        document.getElementById("disacount_amount").readOnly=true;  
    }
}
function discount_type_per(){
     if(document.getElementById('round').checked){
          document.getElementById("disacount_amount").value="";
    document.getElementById('discount').disabled=false;
    document.getElementById("discount").readOnly=false;
        document.getElementById("disacount_amount").readOnly=true;  
        document.getElementById("disacount_amount").style.background="#D9DBDD";
    
     }else{
         document.getElementById("disacount_amount").style.background='white';
         document.getElementById('discount').disabled=true;
          document.getElementById("discount").readOnly=true;
        document.getElementById("disacount_amount").readOnly=false;
        if(parseFloat(document.getElementById('grand_total'))!=""){
            document.getElementById('disacount_amount').value="";
            document.getElementById('discount').value="";
            discount_amount();
        }
     }
}
</script>
	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="//netsh.pp.ua/upwork-demo/1/js/typeahead.js"></script>
	-->
<script>
 /*       $(document).ready(function() {
            $('input.supplier').typeahead({
                name: 'supplier',
                remote: 'party.inc.php?query=%QUERY'

            });

        })*/
</script>
	
<style>	
.my_with { width:100px;}

</style>
	
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
                <!-- Form -->
                <div class="webform-area">
					<div class="content-module-heading cf">
						<h3 class="fl">Add Sales</h3>
						<span class="fr expand-collapse-text">Click to collapse</span>
						<span class="fr expand-collapse-text initial-expand">Click to expand</span>
					</div> <!-- end content-module-heading -->
				
                    <!-- show message -->
                    <?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?>
                    
                    <?php 
					if(isset($_GET['action']) && ($_GET['action'] == 'add_Vendor')) 
					{	
					?>
						<br>
                        <span>Please note that all the <span class="required">*</span> marked fileds are required</span>
                        <form name="form1" method="post" id="form1" action="">
                            <input type="hidden" id="posnic_total" >
                            <input type="hidden" id="roll_no" value="1" >
						<div class="mytable_row "><br>
							<table class="form "  border="0" cellspacing="0" cellpadding="0">
								<tr>  <td>&nbsp; </td> <td>&nbsp; </td>
                               <?php
									//$max = $db->maxOfAll("id","stock_entries");
									$max = 11;
									$max=$max+3;
									$autoid="PR".$max."";
								?>
									<td>Stock ID:</td>
									<td><input name="stockid" type="text" id="stockid" readonly maxlength="200"  class="round default-width-input" style="width:130px " value="<?php echo $autoid ?>" /></td>
									<td>Date:</td>
									<td><input  name="date"  placeholder="" value= "<?php echo date('d-m-Y');?>" type="text" id="name" maxlength="200"  class="round default-width-input"  /></td>
									<td>&nbsp; </td>  <td>&nbsp; </td>
                      
									<td>Bill No.</td>
									<td><input name="bill_no" type="text" id="bill_no" readonly maxlength="200"  class="round default-width-input" style="width:130px " value="<?php echo $autoid ?>" /></td>
                                            
								</tr>
								<tr>  <td>&nbsp; </td> <td>&nbsp; </td>
									<td><span class="man">*</span>Customer:</td>
									<td>
										<input type="text" name="supplier" id="supplier"  maxlength="200"  class="round default-width-input supplier"  style="width:150px " />
                      		
									</td>
                       
									<td>Address:</td>
									<td><input name="address" placeholder="ENTER ADDRESS" type="text" id="address" maxlength="200"  class="round default-width-input"  /></td>
									<td>&nbsp; </td> <td>&nbsp; </td> <td >contact:&nbsp; &nbsp; &nbsp; </td>
									<td><input name="contact" placeholder="ENTER CONTACT" type="text" id="contact1" maxlength="25"  class="round default-width-input" onkeypress="return numbersonly(event)" style="width:120px " /></td>
                       
								</tr>
							</table>
						</div><br>
						<div align="center">
							<input type="hidden" id="guid">
							<input type="hidden" id="edit_guid">
							
							<table class="form" >
								<tr>
									<td>Item:</td>
									<td>Quantity:</td>
									<td>Price:</td>
									<td>Available Stock:</td>
									<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
									<td>&nbsp; </td>
								</tr>
								<tr>
									<td>
									<input name="item"  type="text" id="item"  maxlength="200"  class="round default-width-input " style="width: 100px"   /></td>
									<td><input name="quty"  type="text" id="quty"  maxlength="200"   class="round default-width-input my_with" onKeyPress="quantity_chnage(event);return numbersonly(event)" onkeyup="total_amount();unique_check();stock_size();"  style="width: 150px"  /></td>
									<td><input name="price"  type="text" id="sell" readonly maxlength="200"  class="round default-width-input my_with" /></td>
									<td><input name="stock"  type="text" id="stock" readonly maxlength="200"  class="round  my_with"  /></td>
									<td><input name="total"  type="text" id="total" maxlength="200"  class="round default-width-input " style="width:100px;  margin-left: 20px"  /></td>
									<td><input type="button" onclick="add_values()" onkeyup=" balance_amount();" id="add_new_code"  style="margin-left:30px; width:30px;height:30px;border:none;background:url(images/add_new.png)" class="round"> </td>
						 
								</tr>
							</table>
							  
							<div style="overflow:auto ;max-height:300px;  ">
							   <table class="form" id="item_copy_final" style="margin-left:45px ">
						
								</table>
							</div>
						</div>
                  
						<div class="mytable_row ">
							<table class="form">
								<tr>
									<td>&nbsp; </td> <td> <input type="checkbox" id="round" onclick="discount_type_per()" >Discount As Percentage</td>
									<td></td> 
								</tr>
								<tr> 
									<td>&nbsp; </td>
									<td>Discount %<input type="text" maxlength="3" disabled class="round" onkeyup=" discount_amount(); " onkeypress="return numbersonly(event);" name="discount" id="discount" >
									</td>
                 
									<td>Discount Amount:<input type="text"  onkeypress="return numbersonly(event);"  onkeyup=" discount_as_amount(); "  class="round" id="disacount_amount" name="dis_amount" >               
									</td>
                    
									<td>Grand Total:<input type="hidden" readonly id="grand_total" name="subtotal" > 
									<input type="text" id="main_grand_total" readonly class="round default-width-input" name="grand_total" style="text-align:right;width: 120px" >
									</td>  <td>&nbsp; </td>
									<td>Description</td>
									<td><textarea name="description"></textarea></td>
								</tr> 
								<tr> 
									<td>&nbsp; </td>
									<td>Payment:<input type="text"  class="round" onkeyup=" balance_amount(); " onkeypress="return numbersonly(event);" name="payment" id="payment" >
									</td>
							 
									<td>Balance:<input type="text"  class="round" readonly id="balance" name="balance" >               
									</td>
									<td>Payable Amount:<input type="hidden" readonly id="grand_total"  > 
									<input type="text" id="payable_amount" readonly name="payable" class="round default-width-input"  style="text-align:right;width: 120px" >
									</td>  <td>&nbsp; </td>  <td>&nbsp; </td>  <td>&nbsp; </td>
								</tr> 
								<tr> <td>Mode &nbsp;</td><td>
									<select name="mode">
									<option value="cash">Cash</option>
									<option value="cheque">Cheque</option>                      
									<option value="other">Other</option>
									</select>
									</td>
									<td>
										Due Date:<input type="text" name="duedate" id="test2" value="<?php echo date('d-m-Y');?>" class="round">
									</td>
									<td> Tax:<input type="text" name="tax" onkeypress="return numbersonly(event);"></td>              
									<td>Tax Description:<input type="text" name="tax_dis"> </td>
									<td>&nbsp; </td>
									<td>&nbsp; </td>
								</tr>
							</table>
							<table class="form">
								<tr>
								 <td>
									<input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add" >
										
								 </td><td>			(Control + S)
								 <input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td>
								  <td><input class="button round red   text-upper"  type="button" name="print" value="Print" onClick='print1();'> </td>
								  <td>&nbsp; </td>
								</tr>
							</table>
						</div>
					</form>
						<li><a href="pdf_new_student_med.php">priecnt</a></li>
                    <?php 
					}
					?>
                    
                </div>
                <div class="cl"></div>
                <!-- eof Form -->
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php// require_once('footer.inc.php'); ?>
     
</body>
</html>
