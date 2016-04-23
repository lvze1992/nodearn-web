<?php require_once('../../../wamp.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['zdq_admin_s'] = NULL;
  $_SESSION['zdq_admin_group'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['zdq_admin_s']);
  unset($_SESSION['zdq_admin_group']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['userpass'];
  $MM_fldUserAuthorization = "admin_type";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_wamp, $wamp);
  	
  $LoginRS__query=sprintf("SELECT admin_id, userpass, admin_type FROM `admin` WHERE username=%s AND userpass=SHA1(%s)",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $wamp) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'admin_type');
    $loginUserid  = mysql_result($LoginRS,0,'admin_id');
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['zdq_admin_group'] = $loginStrGroup;	      
	if($_SESSION['zdq_admin_group']==1){
	  $_SESSION['zdq_admin_s'] = $loginUserid;

	  if (isset($_SESSION['PrevUrl']) && true) {
		$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
	  }
	  header("Location: " . $MM_redirectLoginSuccess );
	}
	else{
		echo "- 【登录失败】您的账号权限不足";
	}

  }
  else {
		echo "- 【登录失败】用户名或密码错误";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>赚点钱-登录</title>
<link href="css/log_reg.css" type="text/css" rel="stylesheet"/>

</head>

<body>
<?php
if($_SESSION['zdq_admin_s']==""||$_SESSION['zdq_admin_group']==""){
	if($_GET['force']=="home"){
		echo "<h2>您没有登录该页面的权限。</h2>";
	}
?>
<form id="login_form" action="<?php echo $loginFormAction; ?>" method="POST">
<p class="r"><span>

用户名：</span><input name="username" type="text"/></p>
<p class="r"><span>密码：</span><input type="password" name="userpass"/></p>
<p class="r"><input type="submit" name="login" value="登录"/><a href="register.php">注册</a>
</p>

</form>
<?php
}
else{
	echo "<h4 style='text-align:center;'>- 您已登录</h4>";
	echo "<p style='text-align:center;'>点击“跳转”登录<a href='home.php'>跳转</a><br/>";
?>
<a href="<?php echo $logoutAction ?>">注销</a></p>
<?php
}
?>
</body>
</html>
