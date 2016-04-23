<?php  ?>
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
	
  $logoutGoTo = "index.php";
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
	require_once('../../../wamp.php');
  $loginUsername=$_POST['username'];
  $password=$_POST['userpass'];
  $MM_fldUserAuthorization = "admin_type";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "index.php";
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
		$error[]= "- 【登录失败】您的账号权限不足";
	}

  }
  else {
		$error[]= "- 【登录失败】用户名或密码错误";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>赚点钱 - 后台登录</title>

<link href="images/all.css" type="text/css" rel="stylesheet" media="all" />
<!--[if ie]><link rel="stylesheet" type="text/css" href="images/index_ie.css" media="all" /><![endif]-->
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>

<body>

<header>
<div class="head" id="login_formhead">
	<div class="wrapper">
        <div class="logo"><img src="images/logo.png"></div>
        <div class="menu">
            <a href="" id="menu1">产品中心</a>
            <span>|</span>
            <a href="" id="menu2">联系客服</a>
            <span>|</span>
            <a href="" id="menu3">关于我们</a>
            <span>|</span>
            <a href="../../index.html" target="_blank" id="menu4">点小赚APP</a>
            <span>|</span>
        </div>
    </div>
</div>
</header>


<div class="banner_area" id="banner_list">
  	<div class="main_box">
    	<div class="main_cont">
        	<div class="wrapper">
            <dl class="xl_info clearfix">
<?php
if($_SESSION['zdq_admin_s']==""||$_SESSION['zdq_admin_group']==""){
	if($_GET['force']=="home"){
		echo "<h2>您没有登录该页面的权限。</h2>";
	}
	if(!empty($error)){
		for($i=0;$i<count($error);$i++){
			echo $error[$i];
		}	
	}
?>
            
            	<form id="login_form" action="<?php echo $loginFormAction; ?>" method="POST">
                <dt class="hide">登录赚点钱</dt>
                <dd><input type="text" class="srh" name="username"></dd>
                <dd><input type="password" class="srh" name="userpass"></dd>
                <dd><input class="button white radius4 dl" type="submit" value="登录"  name="login"/></dd>
                <dd><a href="#reg_formhead"><input class="button blue radius4 shenqing" type="button" value="立即注册"/></a><input class="button blue radius4 lj" type="button" value="咨询了解" /></dd>
                </form>
<?php
}
else{
	echo "<h4 style='text-align:center;'>- 您已登录</h4>";
	echo "<p style='text-align:center;'>点击“跳转”登录<a href='home.php' style='color:blue'>跳转</a><br/>";
?>
<a href="<?php echo $logoutAction ?>">注销</a></p>
<?php
}
?>

            </dl>
            
            <!-- 分享 -->
            <div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><a title="分享到" href="http://www.bShare.cn/" id="bshare-shareto" class="bshare-more">分享到</a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
            <!-- 分享 结束 -->
            
    		</div>
            <div class="bg"></div>
		</div>

    </div>
  	<div class="banner_box banner_ui on on_delay">
    	<div class="banner_cont">
        	<div class="area">
                <p class="ban1_anim_txt">精心打造，简而未减</p>
                <div class="ban1_anim_bg"></div>
            </div>
        </div>
    </div>
    <div class="banner_box banner_logo">
    	<div class="banner_cont">
        	<div class="area">
                <p class="ban2_anim_txt">动态皮肤，随心随身</p>
                <div class="ban2_anim_bg_logo"></div>
                <div class="ban2_anim_bg_line"></div>
                <div class="ban2_icon_1"><span></span></div>
                <div class="ban2_icon_2"><span class="s1"></span><span class="s2"></span></div>
                <div class="ban2_icon_3"><span></span></div>
            </div>
        </div>
    </div>
    <div class="banner_box banner_lighting">
    	<div class="banner_cont">
        	<div class="area">
            	<div class="ban3_act_bg"></div>
                <div class="ban3_mask"></div>
                <p class="ban3_anim_txt png">极速体验，快如闪电</p>
                <div class="ban3_anim_bg_lightning"></div>
                <div class="ban3_anim_bg_boom"></div>
                <div class="ban3_anim_bg_boom_icon_l"></div>
                <div class="ban3_anim_bg_boom_icon_r"></div>
            </div>
        </div>
    </div>
  </div>
 <div class="status" id="status">
  	<span class="on"></span>
    <span></span>
    <span></span>
  </div> 
  
  
  <div class="index-bottom">
  
  	<div class="fg-line"><b></b><span>特色功能介绍（留空，软件开发完成后完善）</span><b></b></div>
   <!-- 
    <div class="clearfix part">
        <div class="text fl">
            <div class="title">
            	<span class="fl">01</span>
                <p>拥有强大的调图参数</p>
                <p class="small">POWERFUL ADJUSTMENT PARAMETERS</p>
            </div>
            <p class="nr">拥有自动曝光、数码补光、白平衡、亮度对比度、饱和度、色阶、曲线、色彩平衡等一系列非常丰富的调图参数。最新开发的版本，对UI界面进行全新设计，拥有更好的视觉享受，且操作更流畅，更简单易上手。无需PS，您也能调出完美的光影色彩。</p>
        </div>
        <div class="pic fr">
        	<img src="images/info01.jpg">
        </div>
    </div>
    
/*	------------------------------------分割线------------------------------------    
    <div class="h-line"></div>
    
    <div class="clearfix part">
        
        <div class="pic fl">
        	<img src="images/info02.jpg">
        </div>
        <div class="text fr">
            <div class="title">
            	<span class="fl">02</span>
                <p>丰富的数码暗房特效</p>
                <p class="small">DIGITAL DARKROOM EFFECTS</p>
            </div>
            <p class="nr">还在羡慕他人多变的照片风格吗？没关系，光影魔术手拥有多种丰富的数码暗房特效，如Lomo风格、背景虚化、局部上色、褪色旧相、黑白效果、冷调泛黄等，让您轻松制作出彩的照片风格，特别是反转片效果，光影魔术手最重要的功能之一，可得到专业的胶片效果。</p>
        </div>
        
    </div>
    
	------------------------------------分割线------------------------------------    
    <div class="h-line"></div>
    
    <div class="clearfix part">
        <div class="text fl">
            <div class="title">
            	<span class="fl">03</span>
                <p>海量精美边框素材</p>
                <p class="small">PHOTO FRAM MATERIAL</p>
            </div>
            <p class="nr">海量精美边框素材可给照片加上各种精美的边框，轻松制作个性化相册。除了软件精选自带的边框，更可在线即刻下载论坛光影迷们自己制作的优秀边框。
光影论坛提供海量边框下载：
轻松边框   花样边框   撕边边框   多图边框</p>
        </div>
        <div class="pic fr">
        	<img src="images/info03.jpg">
        </div>
    </div>
    
    	------------------------------------分割线------------------------------------    
    <div class="h-line"></div>
	
    
    <div class="clearfix part">
        
        <div class="pic fl">
        	<img src="images/info04.jpg">
        </div>
        <div class="text fr">
            <div class="title">
            	<span class="fl">04</span>
                <p>随心所欲的拼图</p>
                <p class="small">PUZZLE FEATURE</p>
            </div>
            <p class="nr">光影魔术手拥有自由拼图、模板拼图和图片拼接三大模块，为您提供多种拼图模板和照片边框选择。独立的拼图大窗口，将各种美好瞬间集合，与家人和朋友分享。</p>
        </div>
    </div>
    
        	------------------------------------分割线------------------------------------    
    <div class="h-line"></div>
    
    
    <div class="clearfix part">
        <div class="text fl">
            <div class="title">
            	<span class="fl">05</span>
                <p>拥有强大的调图参数</p>
                <p class="small">POWERFUL ADJUSTMENT PARAMETERS</p>
            </div>
            <p class="nr">拥有自动曝光、数码补光、白平衡、亮度对比度、饱和度、色阶、曲线、色彩平衡等一系列非常丰富的调图参数。最新开发的版本，对UI界面进行全新设计，拥有更好的视觉享受，且操作更流畅，更简单易上手。无需PS，您也能调出完美的光影色彩。</p>
        </div>
        <div class="pic fr">
        	<img src="images/info01.jpg">
        </div>
    </div>
    
	------------------------------------分割线------------------------------------    
    <div class="h-line"></div>
    
    <div class="clearfix part">
        
        <div class="pic fl">
        	<img src="images/info02.jpg">
        </div>
        <div class="text fr">
            <div class="title">
            	<span class="fl">06</span>
                <p>丰富的数码暗房特效</p>
                <p class="small">DIGITAL DARKROOM EFFECTS</p>
            </div>
            <p class="nr">还在羡慕他人多变的照片风格吗？没关系，光影魔术手拥有多种丰富的数码暗房特效，如Lomo风格、背景虚化、局部上色、褪色旧相、黑白效果、冷调泛黄等，让您轻松制作出彩的照片风格，特别是反转片效果，光影魔术手最重要的功能之一，可得到专业的胶片效果。</p>
        </div>
        
    </div>
   -->
  </div>
 <?php
if(isset($_POST['register'])){
	 require_once('../../../mysql_connect.php'); 
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
		  $sql="select last_insert_id()";
		  $r=mysql_query($sql);
		  $row=mysql_fetch_array($r);
		  //$_SESSION['zdq_admin_s'] = $reg_name;
		  $_SESSION['zdq_admin_s'] = $row[0];
		}
		else{
			echo $sql;
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
	
}
?>
<link href="css/client_style.css" type="text/css" rel="stylesheet"/>

<body>
<?php
if(isset($_POST['register'])&&empty($errors)){ echo "<h2>恭喜您，您已注册成功。</h2>";}

if(!isset($_POST['register']) || !empty($errors)){
?>
<div class="register-width promotion-tip" id="reg_formhead" style="margin: 50px auto 10px auto;"> <img class="vertical-middle margin-left-10" src="img/liwu.png"> <span class="vertical-middle">现在使用注册“赚点钱”账号，并建立“商户”，即可获得<span style="color:red !important;">代金券</span>或<span style="color:red !important;">折扣券</span>！</span> </div>
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
<form action="#reg_formhead" method="post" onSubmit="return checkCoords();"  id="register_form">
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
      <button type="submit" class="btn btn-large" id="J_BtnInfoForm" name="register">确认</button> <a href="#login_formhead"> 登录</a></p>
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
	echo "<p><a href='#login_formhead'>返回登录</a></p>";
	}
?>
 
<footer>
<div class="foot">
    <p>Copyright © 2016 Zhuandianqian. All rights reserved.</p>

</div>
</footer>
<script src="js/all.js" type="text/javascript"></script>
</body>

</html>