<?php 
session_start();
include_once('checkSession.php');
require_once("../connection/connection.php"); 
require_once("../classes/adminLogin.class.php"); 
require_once("../classes/date.class.php"); 
require_once("../includes/constant.inc.php"); 
require_once("../classes/error.class.php"); 
require_once("../classes/news.class.php"); 
require_once("../classes/utility.class.php"); 


/* INSTANTIATING CLASSES */
$adminLogin 	= new adminLogin();
$dateUtil      	= new DateUtil();
$error 			= new Error();
$news			= new News();
$utility		= new Utility();


if(isset($_GET['id']))
{
	$news_id = $_GET['id'];
}


if(isset($_POST['btnDelete']))
{	
	$news->deleteNews($news_id, '../images/news/');
	header("Location:".$_SERVER['PHP_SELF']."?action=success&msg=news is deleted");
	
}
?> 

<title>Delete News</title>
<!-- Style -->
<link href="../style/admin/style.css" rel="stylesheet" type="text/css">
<link href="../style/admin/admin.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../js/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
</link>
<!-- eof Style -->

<div class="popup-form">
	<?php 
    if(isset($_GET['msg']))
    {
        echo "<tr class='maroonError'><td align='left' height='25'>".stripslashes($error->printError($_GET['msg']))."</td></tr>";
    }
    ?>
    <?php 
    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'success')
        {
         ?>


            <form name="form1" method="post" action="">
              <input name="Button" type="button" class="buttonYellow" onClick="opener.location.reload();self.close()" value="Close">
            </form>

         <?php
        }
    }
    ?>
    <?php 
    //CHECKING WHETHER THE CATEGORY HAS ANY SUB CATEGORY AND/OR PRODUCTS OR NOT
    
    //CREATING NEW USER FORM
    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'news_delete')
        {
            
            $newsDetail = $news->getNewsData($news_id);
    ?>

      <h3>Delete News</h3>

      <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

            Are you sure that you want to delete the News - <br />
            <span class="maroonError">"<?php echo $newsDetail[0];?>"	</span>
            <br />
            <input name="" type="hidden" value="">
            <input name="btnDelete" type="submit" class="buttonYellow" id="btnDelete" value="delete">
            <input name="btnCancel" type="button" class="buttonYellow" id="btnCancel" onClick="self.close()" value="cancel">

    
      </form>

    <?php 
        }//END OF  IF
    }//END OF  IF
    ?>
</div>