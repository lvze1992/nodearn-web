<?php
session_start();
$user_name=$_POST['name'];
$user_pass=$_POST['pass'];
$submit=$_POST['submit'];
$page=$_GET['page'];//abb
if($user_name&&$user_pass){
require('../../mysql_connect.php');
$sql="select * from admin where username='".$user_name."' && userpass=SHA1('".$user_pass."') limit 1";
$result=mysql_query($sql);
   if(@mysql_num_rows($result)!=0){
       $row=mysql_fetch_array($result);
       session_unset();//删除会话
       session_destroy();
	   $_SESSION["zdq_admin_s"]=$row[0];
	   setcookie("zdq_admin_c",$row[0],(time()+28800),"/");//保存8个小时
	   if($page=="aad") 	  
	       header("location: add_admin_daily.php");//session和cookie都没有记录
       else
	       header("location: add_admin_daily.php");//session和cookie都没有记录

   }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
</head>

<body>
<form action="login.php?page=<?php echo $page;?>" method="post">
<input name="name" type="text"/>
<input name="pass" type="password"/>
<input name="submit" value="登录" type="submit"/>
</form>
</body>
</html>
