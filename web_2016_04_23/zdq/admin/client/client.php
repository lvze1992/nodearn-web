<?php 
include('head.html'); 
//使用该页面需要实名认证
$sql="select CONCAT(last_name,first_name) from admin where admin_id=".$_SESSION['zdq_admin_s'];
$r=mysql_query($sql);
$row=mysql_fetch_array($r);
if($row[0]==NULL){
	echo "<h2 style='text-align:center;padding-top:40px'>您未进行实名认证！</h2>";
	echo "<p style='text-align:center'><a href='identify.php?a=".$_SESSION['zdq_admin_s']."' target='_blank' style='text-decoration: none;'>即刻认证</a></p>";
?>
<div style="clear:both; display:table; content:'';"></div>
<?php
	exit;
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/client_style.css" type="text/css" rel="stylesheet"/>
<html>
<body>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['client-form'])){
	$flag=$_POST['flag'];
	if($_POST['check-box']){
		$error=array();
		$items=array();
		$items[]=$_POST['client-name'];
		$items[]=$_POST['client-addr'];
		$items[]=$_POST['client-intr'];
		$items[]=$_POST['l-name'];
		$items[]=$_POST['f-name'];
		$items[]=$_POST['email'];
		$items[]=$_POST['charge-addr'];
		$items[]=$_POST['tel'];
		$items[]=$_POST['big-pic'];
		$items[]=$_POST['small-pic'];
		if($_POST['big-pic']==""){$error[]="请选择商户的logo图片（jpg或gif）上传并完成剪切";}
		for($i=0;$i<count($items)-2;$i++){
			if($items[$i]=="") {$error[]="请将表单填写完整";break;}
		}
		if(empty($error)){
			if(strlen($items[0])>60||strlen($items[0])<6) 	$error[]="商户名称长度须在6-60字符之间（2-20个汉字）";
			if(strlen($items[1])>300||strlen($items[1])<6) 	$error[]="商户地址长度须在6-300字符之间（2-100个汉字）";
			if(strlen($items[2])>300||strlen($items[2])<6) 	$error[]="商户简介长度须在6-300字符之间（2-100个汉字）";
			if(strlen($items[3])>30||strlen($items[3])<3) 	$error[]="姓氏长度须在3-30字符之间（1-10个汉字）";
			if(strlen($items[4])>30||strlen($items[4])<3) 	$error[]="名字长度须在3-30字符之间（1-10个汉字）";
			$chars="/^([a-zA-Z0-9_-]+)@([a-zA-Z0-9_-]+).([a-zA-Z0-9_-]+)$/";
			if(!preg_match($chars,$items[5])){
				 	$error[]="邮箱格式不正确";
  			}
			if(strlen($items[5])>30||strlen($items[5])<3) 	$error[]="邮箱长度须在3-30字符之间";
			if(strlen($items[6])>300||strlen($items[6])<6) 	$error[]="负责人联系地址地址长度须在6-300字符之间（2-100个汉字）";
			$chars="/^([0-9]{11})$/";
			if(!preg_match($chars,$items[7])){
				 	$error[]="仅支持11位数字的电话号码";
  			}
		}
		//print_r($items);
	}
	else{
		$error[]="请勾选下方表单末的协议";
	}
	if(empty($error)){
		
	  $sql="insert into client(company,address,intro,last_name,first_name,email,address_charge,telephone,logo_big,logo_small,admin_id) values('$items[0]','$items[1]','$items[2]','$items[3]','$items[4]','$items[5]','$items[6]','$items[7]','$items[8]','$items[9]',".$_SESSION['zdq_admin_s'].")";
	  if(mysql_query($sql)){
	  	$flag=0;
	  }
	}
	
	
	if($flag!=$_POST['flag']){
		echo "<h2 style='text-align:center;padding-top:40px'>添加成功</h2>";
		echo "<p style='text-align:center'><a href='client.php'>继续添加</a>或<a href='client_list.php'>查看已添加</a></p>";
		exit;
		}
}
?>
<div class="register-width promotion-tip"> <img class="vertical-middle margin-left-10" src="img/liwu.png"> <span class="vertical-middle">所有新添加的商户都将获得专属<span style="color:red !important;">代金券</span>或<span style="color:red !important;">折扣券</span>！</span> </div>
<?php 
if(!empty($error)){
?>
<div class="register-width promotion-tip error"><span class="vertical-middle">
<p style="font-weight: 700;">出现如下错误：</p>
<p>
<?php
	  foreach($error as $msg){
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
<form action="" method="post" enctype="multipart/form-data" onSubmit="return checkCoords();">
<input type="hidden" name="flag" value="1"/>
  <div class="form-group account-set">
    <div class="form-item"> <span class="form-label form-label-b">商户信息</span> <span class="sub-title">请仔细填写待添加商户的信息</span> </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>公司/商铺/公众号（名称）</span>
      <input autocomplete="off" class="form-text" name="client-name" type="text" value="<?php echo $_POST['client-name'];?>" placeholder="填写商户名称">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>公司地址/商铺地址/微信号</span>
      <input class="form-text" type="text" placeholder="填写商户地址信息" name="client-addr" value="<?php echo $_POST['client-addr'];?>">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>商户简介</span>
      <textarea class="form-text" placeholder="填写商户简介信息" style="height:150px;" name="client-intr"><?php echo $_POST['client-intr'];?></textarea>
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>商户LOGO</span>
      <?php
        include("cutdemo/index.php");
		?>
    </div>
  </div>
  <div class="form-group basic-info">
    <div class="form-item"> <span class="form-label form-label-b">商户责任人信息</span> <span class="sub-title">请输入真实的信息</span> </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>姓</span>
      <input autocomplete="off" class="form-text" name="l-name" type="text" value="<?php echo $_POST['l-name'];?>" placeholder="填写您的姓氏">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>名</span>
      <input autocomplete="off" class="form-text" name="f-name" type="text" value="<?php echo $_POST['f-name'];?>" placeholder="填写您的名字">
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>邮箱</span>
      <input autocomplete="off" class="form-text" name="email" type="text" value="<?php echo $_POST['email'];?>" placeholder="填写用于联系您的邮箱">
    </div>
    <div class="form-item"> <span class="form-label tsl" ><span class="star">*</span>联系地址</span>
      <textarea class="form-text" placeholder="填写责任人的联系地址" style="height:150px;" name="charge-addr"><?php echo $_POST['charge-addr'];?></textarea>
    </div>
    <div class="form-item"> <span class="form-label"><span class="star">*</span>手机号</span>
      <div class="mobile-text"> <span class="mobile-text-code" id="J_AreaCode">+86</span>
        <input type="hidden" name="mobile_area" value="1">
        <input class="form-text mobile-text-input err-input" maxlength="20" name="tel" type="text" value="<?php echo $_POST['tel'];?>" placeholder="请输入手机号码">
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
      <button type="submit" class="btn btn-large" id="J_BtnInfoForm" name="client-form">确认</button>
      <div class="msg-tit"></div>
      <div class="msg-cnt"></div>
    </div>
  </div>
  </div>
</form>
</div>
<div style="clear:both; display:table; content:'';"></div>
</body>
</html>