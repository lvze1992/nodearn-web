<?php 
include('head.html'); 
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/client_style.css" type="text/css" rel="stylesheet"/>
<link href="css/table_style.css" type="text/css" rel="stylesheet"/>

</head>

<body>
<div class="register-width promotion-tip"> <img class="vertical-middle margin-left-10" src="img/liwu.png"> <span class="vertical-middle">所有新添加的商户都将获得专属<span style="color:red !important;">代金券</span>或<span style="color:red !important;">折扣券</span>！</span> </div>
<div style="margin:10px auto;">
<table class="table-style" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="border-left">任务标题</th><th>任务介绍</th><th width="50px">添加时间</th><th width="85px">任务类型</th><th width="60px">操作</th><th class="border-right" width="40px">预览</th>
</tr>
</thead>
<tbody>
<?php 
$sql="select client_id,company,CONCAT(last_name,first_name) from client where admin_id=".$_SESSION['zdq_admin_s']." order by reg_time desc";
$r=mysql_query($sql);
while(@$row=mysql_fetch_array($r)){
	echo "<tr><td colspan='6' style='color:black; background-color:#b9e8fb'><b>$row[2] $row[1]</b></td></tr>";
	$sql="select mission_id,client_mission_title,client_mission_intro,add_time,mission_title,mission_type from client_mission inner join mission_type using(mission_type) where client_id=$row[0]";
	$r2=mysql_query($sql);
	if(@mysql_num_rows($r2)==0){	
		echo "<tr><td colspan='6' style='color:red;'>该商户未发布任务 <a href='follow.php'>添加</a></td></tr>";	
	}
	else{
	  while(@$row2=mysql_fetch_array($r2)){
		  		$mission_type=$row2['mission_type'];
				$mission_id=$row2['mission_id'];
				$sql="select from_table from mission_type where mission_type='$mission_type'";
				$r3=mysql_query($sql);
				$row3=mysql_fetch_array($r3);
				$table=$row3[0];
  				$sql="select state from $table where mission_type='$mission_type' and mission_id=$mission_id";
				$r3=mysql_query($sql);
				$row3=mysql_fetch_array($r3);
		  		if($row3['state']=='0') $operation="<span style='color:green'>审核中</span>";
				else if($row3['state']=='1') $operation="<a>暂停</a>";
				else if($row3['state']=='2') $operation="<a>重启</a>";
				else if($row3['state']=='3') $operation="<span style='color:red'>审核未通过</span>";
				else $operation="任务出错";
			  echo "<tr><td class='border-left border-bottom'>".htmlspecialchars($row2[1])."</td><td class='border-bottom'>".htmlspecialchars($row2[2])."</td><td class='border-bottom'>".htmlspecialchars($row2[3])."</td><td class='border-bottom'>".htmlspecialchars($row2[4])."</td><td class='border-bottom'>$operation</td><td class='border-right  border-bottom'>预览</td></tr>";
	  }
	}
}
?>
</tbody>
</table>
</div>
<div style="clear:both; display:table; content:'';">&nbsp;</div>
</body>
</html>