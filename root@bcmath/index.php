<?php 
include_once('_config/connect.php');




?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Moni Enterprises</title>
    
<link rel="stylesheet" type="text/css" href="style/admin/admin.css" />

<script type="text/javascript" src="js/jQuery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-1.10.1.js"></script>
<script type="text/javascript" src="js/jQuery/jquery.min.js"></script>
<script type="text/javascript" src="js/jQuery/jquery.slimscroll.js"></script>
<script type="text/javascript" src="js/jQuery/jquery.slimscroll.min.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
 {
	$('.option-block').hover(function()
	{
		
		var id		= $(this).attr('id');
		var dId		= id+"-dropdown";
		/*$("#"+dId).slideDown();*/
		$("#"+dId).css({display:'block'});
		
	},function()
	{
		var id		= $(this).attr('id');
		var dId		= id+"-dropdown";
		/*$("#"+dId).slideUp();*/
		$("#"+dId).css({display:'none'});
	});
 });
</script>






<script type="text/javascript">
function startTime()
{
	var today=new Date();
	d=today.toString('dddd, MMMM ,yyyy');
	//document.getElementById('server-date').innerHTML= d;
	t=setTimeout('startTime()',500);
}

function checkTime(i)
{
	if (i<10)
  	{
  		i="0" + i;
 	}
	return i;
}
</script>

</head>


<body onload="startTime()">
<script src="js/highcharts.js"></script>	
    <!-- Header -->
	<?php// require_once('header.inc.php'); ?>
    
    <!-- Container -->
    <div class="container">
        <div class="inner-container">
        	<!-- Left content-->
        	<div id="left-content">
			<a href="https://a2plcpnl0140.prod.iad2.secureserver.net:2096/logout/?locale=en" target="null">Monienterprises Email Box</a>
			<!--||<a href="https://sso.godaddy.com/?regionsite=www&ci=86066&realm=pass&app=o365&marketid=en-US" target="null">Monienterprises DropBox</a>-->
            --------<a href="employee-status.php">Check Employee Status</a>
			
			<!--	<div id="logo">
                	<img src="../<?php// echo LOGO_ADMIN_PATH; ?>" width="<?php //echo LOGO_ADMIN_WIDTH; ?>" 
   					 height="<?php// echo LOGO_ADMIN_HEIGHT; ?>" alt="<?php //echo LOGO_ALT; ?>" />
                </div>-->
                <!-- Statistics-->
                <div id="statistics">
                  <!--  <div id="hits">
                    </div>
                    <div id="user" class="marT20">
                    </div>
                    <div id="org" class="marT20">
                    </div>-->
                </div>
                <!-- eof Statistics-->
            </div>						
            <!-- eof Left content-->
            
            <!-- Main section-->
            <div id="main-section">
            	<h1>Welcome to <?php// echo COMPANY_S; ?> Moni Enterprises</h1>
                <div class="cl"></div>
                <div class="option">
               
                    <div id="static" class="option-block">
                    	<div id="static-dropdown" class="option-dropdown">
                        	<ul>
                                <li><a href="admin/admin_login.php" title="Static Categories">Administrator</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/administrator.png" width="99.9%" >
                        <div class="option-title">Administrator</div>
                    </div>
                    
                    <div id="marketing" class="option-block">
                    	<div id="marketing-dropdown" class="option-dropdown">
                        	<ul>
                                <li><a href="login.php" title="Email Group">Product Manager</a></li>
                               
                            </ul>
                        </div>
                    	<img src="images/icon/pro_manager.png" width="99.9%" >
                        <div class="option-title">Product Manager</div>
                    </div>
                    <div id="setup" class="option-block">
                    	<div id="setup-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="stock/index.php" title="Stock User" >Stock Manager</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/store_manager.png" width="99.9%" >
                        <div class="option-title">Stock Manager</div>
                    </div>
					
					 <div id="rozelle" class="option-block">
                    	<div id="rozelle-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="rozelle/login.php" title="Admin Users" >Rozelle Order</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/labour.jpg" width="99.9%" >
                        <div class="option-title">Rozelle Order</div>
                    </div>
					
					<div id="mepdoc" class="option-block">
                    	<div id="mepdoc-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="mepdoc/index.php" title="MEP USER" >Images/MEP Documents</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/doc.png" width="99.9%" >
                        <div class="option-title">Images/MEP Documents</div>
                    </div>
					<div id="mepEmp" class="option-block">
                    	<div id="mepEmp-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="mepemp/index.php" title="MEP Employee" >Employee</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/doc.png" width="99.9%" >
                        <div class="option-title">Employee</div>
                    </div>
					
				<!--	 <div id="labour" class="option-block">
                    	<div id="labour-dropdown" class="option-dropdown">
                        	<ul>
                            	<li><a href="admin_user.php" title="Admin Users" >Labour</a></li>
                            </ul>
                        </div>
                    	<img src="images/icon/labour.jpg" width="99.9%" >
                        <div class="option-title">Labour</div>
                    </div>    --->
					
					
                    
                    <div class="cl"></div>
                </div>
      <!--   <div class="miscellaneous">-->
                	<!--<h3>Recently Added Pages</h3>-->
                	<?php 
					/*$statIds		= $static->getCurrentStaticId('added_on', 'DESC');
					if(count($statIds) > 0)
					{
						if(count($statIds) > 4)
						{
							$statIds 	= array($statIds[0], $statIds[1], $statIds[2], $statIds[3]);
							foreach($statIds as $s)
							{
								$statDtl		= $static->getStaticData($s);
								?>
                                <div align="center">
                                <?php ?><a href="../content.php?seo_url=<?php echo $statDtl[14]  ?>" target="_blank"><?php echo $statDtl[1] ?><br/> </a><?php ?>
                                </div>
								<?php 
							}
						}
					}*/
					?>
      <!--  </div>-->
                
            </div>
            <!-- eof Main section-->
            <div class="cl"></div>
		
        </div>  
    </div>
    <!-- eof Container -->
    
    <!-- Footer -->
	<?php //require_once('footer.inc.php'); ?>
</body>
</html>