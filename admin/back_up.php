<?php 
session_start();
include_once('checkSession.php');
require_once("../_config/connect.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../includes/email.inc.php");
require_once("../includes/email_account.inc.php");

require_once("../classes/adminLogin.class.php"); 
require_once("../classes/customer.class.php");
require_once("../classes/countries.class.php");
require_once("../classes/email.class.php");
require_once("../classes/backup.class.php");

require_once("../classes/date.class.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/pagination.class.php");
require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$customer	    = new Customer();
$country		= new Countries();
$email_obj		= new Email();
$backup		    = new Backup();


$dateUtil      	= new DateUtil();
$error 			= new Error();
$page			= new Pagination();
$utility		= new Utility();
$uMesg 			= new MesgUtility();

###############################################################################################

$mysqldump_version="1.02";

$print_form=1;
 
$output_messages=array();

     
if( (isset($_POST['btnExport'])) && ($_POST['btnExport'] == 'Export') )
{
 	//db name
	$db			= $backup->getCurrentDatabase(); 
	
	if( 'SQL' == $_REQUEST['output_format'] )
	{

		$print_form=0;
		$dbDownload = $db."-".date('Ymd-His').".sql";
		
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$dbDownload.'"');
		
		echo "-- MySQL Database Backup \n-- @version 1.0 \n-- @date ".date('Y-m-d H:i:s')." \n-- @author Analyze System \n-- @URL http://www.ansysoft.com \n-- @email support@ansysoft.com \n\n\n-- Database:  ".$db."\n\n\n";
			  
		$backup->mysqlDump($db);
	}
 
	
}
if($print_form > 0)
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo COMPANY_S; ?> - Database Backup</title>


<!-- Style -->
<link rel="stylesheet" type="text/css" href="../style/admin/admin.css" />
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<!-- Javascript Libraries -->
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script> 
<script type="text/javascript" 
src="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20051112"></script>

<script type="text/javascript" src="../js/utility.js"></script>
<script type="text/javascript" src="../js/advertiser.js"></script>
<script type="text/javascript" src="../js/location.js"></script>
<script type="text/javascript" src="../js/checkEmpty.js"></script>
<script type="text/javascript" src="../js/email.js"></script>
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
                	<h1>Database Backup </h1>
                </div>
            
                <!-- Display Data -->
                <div class="webform-area">
                
              		<h2>Select your Options</h2> 
            	
                	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">    
                    	
                       <label>Output format:</label>
                       <select name="output_format" class="textBoxA">
                       <option value="SQL" 
					   <?php if( isset($_REQUEST['output_format']) && 'SQL' == $_REQUEST['output_format']) echo "selected";?>>SQL
                       </option>
                       </select>
                        <div class="cl"></div>  
    
                           <label>Dump options(SQL):</label>
                           <div class="cl"></div> 

                           <label>Drop table statement: </label>
                           <input type="checkbox" name="sql_drop_table" <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_drop_table'])) ; else echo 'checked' ?> />
                          <div class="cl"></div>
                             
							<label>Create table statement: </label>
                            <input type="checkbox" name="sql_create_table" <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_create_table'])) ; else echo 'checked' ?> />
							<div class="cl"></div>
                             
							<label>Table data: </label>
                             <input type="checkbox" name="sql_table_data"  <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_table_data'])) ; else echo 'checked' ?>/>
                             <div class="cl"></div>  
                             
                             <label>&nbsp;</label>
                             <label>&nbsp;</label>
                             <div class="cl"></div>

                             <label>&nbsp;</label>
                            <input type="submit" name="btnExport" id="btnExport"  value="Export" />
                            <div class="cl"></div>
                            
                            <label>&nbsp;</label>
                         
                      </form>
	
                </div>
                
                
                <div id="data-column">
                    
                 
                 <div class="first-column">
                 
                <!-- Bottom Pagination-->
                
                </div>
                
                <!-- Gap-->
                <div class="column-gap">&nbsp;</div>
                <div class="cl"></div>
                 
             </div>

            <!-- eof Display Data -->
            <div class="cl"></div>
              
                
            </div>
            <!-- eof Inner  -->
             
            <div class="cl"></div>
        </div>  
    </div>
    <!-- eof Container -->
      

               
  <?php require_once('footer.inc.php'); ?></td>
 
</body>
</html>
<?php 
}
?>