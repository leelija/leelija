<?php
session_start(); 
require_once("../_config/connect.php"); 

require_once("../includes/constant.inc.php");

include_once('../classes/encrypt.inc.php'); 
include_once('../classes/adminLogin.class.php'); 
include_once('../classes/employee.class.php'); 

require_once("../classes/utility.class.php");
require_once("../classes/utilityMesg.class.php"); 

//instantiating classes 
$adminLogin 	= new adminLogin();
$employee 		= new Employee();
$utility		= new Utility();
$uMesg 			= new MesgUtility();

########################################################################################################################

//declare vars
$typeM		= $utility->returnGetVar('typeM','');

if(isset($_POST['btnLogin']))
{
	$login = $_POST['txtLogin']; 
	$password = $_POST['txtPass'];
	
	if(($login == '') || ($password == ''))
	{
		header("Location: ".$_SERVER['PHP_SELF']."?msg=invalid Aadhar No. or password");
	}
	else
	{
		
		$employee->validEmployee($login, $password, 'adhar_no', 'password', 'employee');
	}
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Moni EnterPrises | Log in Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Moni</b>EnterPrises</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

	<div class="mesg"><?php $uMesg->dispMessage($typeM, '../images/icon/', 'blackLarge');?></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="txtLogin" class="form-control" placeholder="Aadhar No.">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="txtPass" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	 
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="btnLogin" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#">I forgot my password</a><br>
    <a href="../employee" class="text-center"> Register for a new employee </a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
