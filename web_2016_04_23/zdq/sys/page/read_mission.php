<?php
$apptitle="阅读咨询任务";
include ('includes/head.html');//包含头部
require('../../../mysql_connect.php');
/*刷阅读咨询任务列表*/
$type="15";//阅读咨询推广任务
$user_id=1;//用户主键id
$sql="select client_mission_title,cm.mission_id,cm.mission_type,pic1,pic2,pic3,join_n+r_join_n,mt.mission_title,state,article_url_id from client_mission as cm inner join client_mission_read using(mission_id) inner join mission_type as mt on cm.mission_type=mt.mission_type where state=1 and mt.mission_type='$type' or state=2 and mt.mission_type='$type' order by order_v desc,state asc";
/*
- client_mission_title 任务标题  - logo_small 小图标
- client_mission_intro 任务介绍	- join_n 参与人数，成功领取任务1次则加1
- cm.mission_id,cm.mission_type 任务id和任务类型	- repeat_c 是否可以重复领取，可重复领取返回冷却时间
- state 任务状态 0：审核中，不显示 1：正常 2：暂停任务 3：审核未通过
- 只有状态为1或2的任务会在此页面中显示
*/
$r=mysql_query($sql);
/************************表格*****************************/
	echo "<h3>封面示例(不同布局需判断获得的图片数，只可能为1或3)</h3>";
	echo "<img src='includes/cover1.JPG'/>";
	echo "<img src='includes/cover2.JPG'/>";
	echo "<h3>商户关注推广任务 - 封面包含的信息</h3><table width='100%'>";
	echo "<tr><th>任务标题</th><th>阅读人数</th><th>图片</th><th>图片数</th><th>任务类型</th><th>mission_type</th><th>mission_id</th><th>任务状态</th><th>转发用article_url_id</th><th>链接</th><th>转发用链接</th></tr>";
while(@$row=mysql_fetch_array($r)){
	echo "<tr><td>$row[0]</td><td>$row[6]</td><td>";
	
	if($row[4]!=null){//判断图片数  据此设置布局  只考虑1或3的情况
	echo "<img src='../../admin/client/$row[3]'/><img src='../../admin/client/$row[4]'/><img src='../../admin/client/$row[5]'/></td><td>3</td>";
	}
	else{	
		echo "<img src='../../admin/client/$row[3]'/></td><td>1</td>";
	}
	
	
	echo "<td>$row[7]</td><td>$row[2]</td><td>$row[1]</td><td>$row[8]</td><td>$row[9]</td>
	<td><a href='read_mission_click.php?user_id=$user_id&mission_id=$row[1]' target='_blank'>链接1</a></td>
	<td><a href='read_mission_click.php?user_id=$user_id&article_url_id=$row[9]&mission_id=$row[1]' target='_blank'>链接2</a></td>";
	echo "</tr>";
}
	echo "</table>";
/************************表格-END*****************************/

include ('includes/footer.html');//包含尾部
?>