<?php 
include('head.html'); 
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/user_style.css" type="text/css" rel="stylesheet"/>

</head><body>
<?php
$admin_id= $_SESSION['zdq_admin_s'];
$sql="select username,CONCAT(last_name,first_name),telephone,reg_time,last_logintime from admin where admin_id=$admin_id limit 1";
$r=mysql_query($sql);
$row=@mysql_fetch_array($r);
?>
<div class="margin-top">
  <div class="pull-left">
  <p><img ng-src="img/3.jpg" src="img/3.jpg" width="120" height="120"></p><p class="avatar-txt-margin"><a>修改头像</a>
  </p>
</div>
<div class="summary">
  <p><span>登录账号</span> <span>：</span> 
  <?php /*echo preg_replace("/^([a-zA-Z0-9_-]+)([a-zA-Z0-9_-]){4}@([a-zA-Z0-9_-]+).([a-zA-Z0-9_-]+)$/", "\${1}****@\$3.\$4", "972010603@qq.com");
  */
  echo $row[0];
  ?></p>
  <p><span>姓名</span> <span>：</span> 
  <?php 
  if($row[1]==""){ 
  echo "(<span class='margin-left' style='color:#F90'>您未通过实名认证</span>)";
  echo "<a href='identify.php?a=".$_SESSION['zdq_admin_s']."' target='_blank' style='text-decoration: none;'> 实名认证</a></p>";
  }
  else
  echo htmlspecialchars($row[1])."(<span class='margin-left' style='color:#F90'>您已通过实名认证</span>)";
  ?> 
  <p><span>电话</span> <span>：</span> <?php echo preg_replace("/(1\d{1,2})\d\d\d\d(\d{3,5})/", "\$1****\$2", $row[2]);?><a href="#"> 修改</a></p>
  <p><span>注册时间</span> <span>：</span> <?php echo $row[3];?></p>
  <p><span>上次登录</span> <span>：</span> <?php echo $row[4];?></p>
</div>
</div><!--margin-top-->
<div class="clear"></div>
<div style="display:table; content:" ";">&nbsp;</div>
</body>
</html>