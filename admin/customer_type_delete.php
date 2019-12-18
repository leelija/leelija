<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/category.inc.php"); 
require_once("../includes/customer.inc.php"); 

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/category.class.php"); 
require_once("../classes/customer.class.php"); 

require_once("../classes/utility.class.php"); 
require_once("../classes/utilityMesg.class.php"); 
require_once("../classes/utilityImage.class.php");

/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$category		= new Cat();
$customer		= new Customer();


$utility		= new Utility();
$uMesg 			= new MesgUtility();
$uImg 			= new ImageUtility();

###############################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');
$type_id	= $utility->returnGetVar('type_id','');

if(isset($_POST['btnDeleteType']))
{	
	$cus	 = $customer->getCustomerByTypeId($type_id);
	$subType  = $customer->getChildCustomerTypeId($type_id);
	
	//defining error variables
	$action		= 'delete_cat';
	$url		= $_SERVER['PHP_SELF'];
	$id			= $cat_id;
	$id_var		= 'cat_id';
	$anchor		= 'delCat';
	$typeM		= 'ERROR';
	
	if(count($cus) > 0)
	{
		//echo "in if ";exit;
		header("Location:".$_SERVER['PHP_SELF']."?id=".$cat_id."&action=error&msg=Error: This type has customer(s), please delete the customer(s) before deleting the type");
		
	}
	elseif(count($subType) > 0)
	{
		//echo "in elseif ";exit;
		header("Location:".$_SERVER['PHP_SELF']."?id=".$cat_id."&action=error&msg=Error: This type has subcategory(ies), please delete the subcategory(ies) before deleting the type");
		
	}
	else
	{
		$customer->deleteCustomerType($type_id);
		header("Location:".$_SERVER['PHP_SELF']."?action=success&msg=type is deleted");
	}
	
}
?>

<title><?php echo COMPANY_S; ?> -  - Delete Customer</title>
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">

<div class="popup-form">
	<?php 
	//display message
	$uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');
	
	//close button
	echo $utility->showCloseButton();
	?>
	<?php 
    if( (isset($_GET['action'])) && ($_GET['action'] == 'delete_type')  )
    {
        $typeDetail			= $customer->getCustomerTypeData($type_id);
    ?>

      

      <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
      		<h3>Delete Customer Type :: <?php echo $typeDetail[1]; ?></h3>
            Are you sure	that	you	want	to delete the customer type named 
            <?php $parentPath = "Category Home ". ">";
            echo "<span class=\"orangeLetter fl\">".$typeDetail[1]."<span>";?>
            <div class="cl"></div>	

            <input name="btnDeleteType" type="submit" class="button-add" id="btnDeleteType" value="delete" />
            <input name="btnCancel" type="button" class="button-cancel" id="btnCancel" onClick="self.close()" 
            value="cancel" />


      </form>

    <?php 
    }//END OF  IF
    ?>
</div>
