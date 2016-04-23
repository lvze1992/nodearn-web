<?php require_once('../../../mysql_connect.php'); 
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_POST['register'])){
  $reg_name=$_POST['reg_name'];
  $reg_userpass=$_POST['reg_userpass'];
  $reg_userpass2=$_POST['reg_userpass2'];
  $reg_tel=$_POST['reg_tel'];
  function check_reg($reg_name){
	  $chars="/^[A-Za-z0-9_]{7,20}$/";//可包括大写小写字母数字下划线，长度为7-20
	  if(preg_match($chars,$reg_name)){
	  }
	  else{
		  $msg="用户名未通过检查，可包含大写字母、小写字母、数字和下划线“_”，且长度为7到20字符";
	  }
	  return $msg;
  }
  function check_pass($pass){
	$chars="/^[A-Za-z0-9_]{7,40}$/";//可包括大写小写字母数字下划线，长度为7-40
	if(preg_match($chars,$pass)){
	}
	else{
		$msg="密码未通过检查，可包含大写字母、小写字母、数字和下划线“_”，且长度为7到40字符";
	}
	return $msg;
  }
  function check_tel($tel){
  $chars="/^[0-9]{11}$/";//可包括数字，长度为11
  if(preg_match($chars,$tel)){
  }
  else{
	  $msg="电话号码未通过检查，只支持11位数字的电话号码";
  }
  return $msg;
  }
  function check_pass_s($pass1,$pass2){
	  if($pass1!=$pass2){
		  $msg="两次输入的密码不同";
	  }
	    return $msg;

  }
	$errors=array();
	if($r=check_reg($reg_name)){
		$errors[]=$r;
	   }
		if($r=check_pass($reg_userpass)){
		$errors[]=$r;
	}
		if($r=check_tel($reg_tel)){
		$errors[]=$r;
	}
		if($r=check_pass_s($reg_userpass,$reg_userpass2)){
		$errors[]=$r;
	}
	if(empty($errors)){//写入数据库
	$sql="select username from admin where username='$reg_name' or telephone='$reg_tel'";
	$r=mysql_query($sql);
	if(@mysql_num_rows($r)==0){
		//确认写入
		$sql="insert into admin(username,userpass,telephone) values('$reg_name',SHA1('$reg_userpass'),'$reg_tel')";
		if(mysql_query($sql)){
		  $_SESSION['zdq_admin_group']=1;
		  $_SESSION['zdq_admin_s'] = $reg_name;
		}
		else{
			$errors[]="出现未知错误，造成添加失败，请重试。";
		}
	}
	else{
		while($row=mysql_fetch_array($r)){
			if($row[0]==$reg_name){
				$errors[]="用户名已被注册";}
			else{
				$errors[]="电话号码已被注册";
				}
			}
		}
	}
	
	if(empty($errors)){ echo "<h2>恭喜您，您已注册成功。</h2><p  class='r'>点击下方“跳转”链接跳转<br/>
	<a href='home.php'>跳转</a></p>";}
	else{
		echo "<h2>注册失败</h2>
		<p class='error' style='text-align:center;'><b>出现如下错误：</b><br/>";
		foreach($errors as $msg){
			if($msg!="")
			echo "- $msg<br/>";
			}
			echo "</p><p style='text-align:center;'><b>请重试！</b></p>";
		
		}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>赚点钱-注册</title>
<link href="css/client_style.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<?php
if(!isset($_POST['register']) || !empty($errors)){
?>
<div class="register-width promotion-tip"> <img class="vertical-middle margin-left-10" src="img/liwu.png"> <span class="vertical-middle">现在使用注册“赚点钱”账号，并建立“商户”，即可获得<span style="color:red !important;">代金券</span>或<span style="color:red !important;">折扣券</span>！</span> </div>
<?php 
if(!empty($errors)){
?>
<div class="register-width promotion-tip error"><span class="vertical-middle">
<p style="font-weight: 700;">出现如下错误：</p>
<p>
<?php
	  foreach($errors as $msg){
		  echo "• $msg<br/>";
		  }

?>
</p>
<p>请重试</p>
</span></div>
<?php
}
?>

<div class="form-list form-main-list">
<form action="" method="post" id="register_form">
<input type="hidden" name="flag" value="1"/>
  <div class="form-group basic-info">
    <div class="form-item"> <span class="form-label form-label-b">注册“赚点钱”管理账户</span> <span class="sub-title">请输入真实的信息</span> </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>用户名</span>
      <input autocomplete="off" class="form-text" name="reg_name" type="text" value="<?php echo $_POST['reg_name'];?>" placeholder="填写您的用户名">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>登录密码</span>
      <input autocomplete="off" class="form-text" name="reg_userpass" type="text" value="<?php echo $_POST['reg_userpass'];?>" placeholder="输入您的密码">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>确认密码</span>
      <input autocomplete="off" class="form-text" name="reg_userpass2" type="text" value="<?php echo $_POST['reg_userpass2'];?>" placeholder="再次输入您的密码">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>手机号</span>
      <div class="mobile-text"> <span class="mobile-text-code" id="J_AreaCode">+86</span>
        <input type="hidden" name="mobile_area" value="1">
        <input class="form-text mobile-text-input err-input" maxlength="20" name="reg_tel" type="text" value="<?php echo $_POST['reg_tel'];?>" placeholder="请输入手机号码">
      </div>
    </div>
    <div class="form-item">
      <input class="form-checkbox" type="checkbox" checked="" name="check-box" id="J_Agreement" style="float: left">
      <div class="agreement-content">
        <div id="J_CnAgreement">
          <p>创建商户的同时，我同意：</p>
          <p><a href="#">《赚点钱网站条款》</a>，并且我同意不发布不符合国家政策，或涉及黄赌毒、涉及诈骗的信息。</p>
          <p>同意“赚点钱”公司可通过电话 (包括语音通 话、短信、或传真) 有针对性地向我提供新的产品/服务的信息。</p>
        </div>
      </div>
    </div>
    <div class="form-item form-item-short">
      <button type="submit" class="btn btn-large" id="J_BtnInfoForm" name="register">确认</button><a href="index.php">登录</a></p>
      <div class="msg-tit"></div>
      <div class="msg-cnt"></div>
    </div>
  </div>
  </div>
</form>
</div>
<div style="clear:both; display:table; content:'';"></div>
<?php
}
else{
	echo "<p><a href='index.php'>返回登录</a></p>";
	}
?>
</body>
</html>