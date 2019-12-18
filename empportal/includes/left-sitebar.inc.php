<?php
include_once('../classes/employee.class.php'); 

//echo $_SESSION[STAFF_SESS];exit;
$empData =  $employee->showEmployeeAdhar($_SESSION[STAFF_SESS]);

?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../employee/images/photos/<?php echo $empData[12];?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $empData[2];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="product-dtls.php" method="POST" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="keyword" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="btnSearch" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
	  
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
          </a>
        </li>
		<li class="active treeview">
          <a href="product-stat.php">
            <i class="fa fa-rebel"></i> <span>My Design</span> 
          </a>
        </li>
		<li class="treeview">
          <a href="top-product.php">
            <i class="fa fa-rebel"></i> <span>Top Design</span> 
          </a>
        </li>
		<li class="treeview">
          <a href="report.php">
            <i class="fa fa-rebel"></i> <span>Report</span> 
          </a>
        </li>
		
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Notice</span>
            <span class="label label-primary pull-right">4</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
       
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Notification</span>
            <small class="label pull-right bg-yellow">12</small>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>