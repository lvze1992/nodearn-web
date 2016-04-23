<?php 
include('head.html'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>赚点钱-实名认证</title>
</head>

<body>
<?php
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['identify'])){
	$items=array();
	$error=array();
	$items[]=$_POST['l_name'];
	$items[]=$_POST['f_name'];
	$items[]=$_POST['id_number'];
  if(strlen($items[0])>30||strlen($items[0])<3) 	$error[]="姓氏长度须在3-30字符之间（1-10个汉字）";
  if(strlen($items[1])>30||strlen($items[1])<3) 	$error[]="名字长度须在3-30字符之间（1-10个汉字）";
	$chars="/^([0-9A-Z]{18})$/";
	if(!preg_match($chars,$items[2])){
			$error[]="仅支持18位身份证号码，若有字母，请以大写形式填入";
	}
	if(empty($error)){

		$sql="update admin set first_name='".$items[1]."',last_name='$items[0]',id_number='$items[2]' where admin_id=".$_SESSION['zdq_admin_s']." limit 1";
		if(mysql_query($sql)){
				echo "<h2 style='text-align:center;padding-top:40px'>实名认证成功！</h2>";
				echo "<p style='text-align:center'><a href='home.php' style='text-decoration: none;'>返回</a></p>";
				exit;

			}
		}
	else{
  		foreach($error as $msg){
			echo "- $msg<br/>";
			}
	}
}
?>
<form action="" method="post" id="register_form">
  <p class="r"><span>姓:</span>
    <input type="text" name="l_name" value="<?php echo $_POST['l_name'];?>"/>
  </p>
  <p class="r"><span>名:</span>
    <input type="text" name="f_name" value="<?php echo $_POST['f_name'];?>"/>
  </p>
  <p class="r"><span>身份证号:</span>
    <input type="text" name="id_number" value="<?php echo $_POST['id_number'];?>"/>
  </p>
  <p class="r">
    <input type="submit" value="进行认证" name="identify"/>
    <a href="home.php">我已认证</a></p>
</form>

</body>
</html>