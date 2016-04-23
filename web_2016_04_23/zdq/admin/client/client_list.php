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
<th class="border-left"  width="100px">商户名称</th><th width="250px">商户地址</th><th>责任人</th><th>联系电话</th><th>email</th><th width="45px">删除</th><th class="border-right" width="45px">预览</th>
</tr>
</thead>
<tbody>
<?php 
$sql="select company,address,CONCAT(last_name,first_name),telephone,email from client where admin_id=".$_SESSION['zdq_admin_s']." order by reg_time desc";
$r=mysql_query($sql);
while(@$row=mysql_fetch_array($r)){

	echo "<tr><td class='border-left border-bottom'>".htmlspecialchars($row[0])."</td><td class='border-bottom'>".htmlspecialchars($row[1])."</td><td class='border-bottom'>".htmlspecialchars($row[2])."</td><td class='border-bottom'>".htmlspecialchars($row[3])."</td><td class='border-bottom'>".htmlspecialchars($row[4])."</td><td class='border-bottom'><a>删除</a></td><td class='border-right  border-bottom'>预览</td></tr>";
	}
?>
</tbody>
</table>
</div>
<div style="clear:both; display:table; content:'';">&nbsp;</div>
</body>
</html>