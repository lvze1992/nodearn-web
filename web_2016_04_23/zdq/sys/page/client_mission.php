<?php
$apptitle="商户关注推广任务";
include ('includes/head.html');//包含头部
include ('mission_state.php');
require('../../../mysql_connect.php');
/*刷商户推广任务列表*/
$type="13";//商户推广任务
$user_id=1;//用户主键id
$sql="select client_mission_title,client_mission_intro,cm.mission_id,cm.mission_type,logo_small,join_n,repeat_c,mt.mission_title,state from client_mission as cm inner join client_mission_wetalk using(mission_id) inner join mission_type as mt on cm.mission_type=mt.mission_type where state=1 and mt.mission_type='$type' or state=2 and mt.mission_type='$type' order by order_v desc,state asc";
/*
- client_mission_title 任务标题  - logo_small 小图标
- client_mission_intro 任务介绍	- join_n 参与人数，成功领取任务1次则加1
- cm.mission_id,cm.mission_type 任务id和任务类型	- repeat_c 是否可以重复领取，可重复领取返回冷却时间
- state 任务状态 0：审核中，不显示 1：正常 2：暂停任务 3：审核未通过
- 只有状态为1或2的任务会在此页面中显示
*/
$r=mysql_query($sql);
/************************表格*****************************/
	echo "<h3>封面示例（把可重复领取的任务，右上角再提示下）</h3>";
	echo "<img src='includes/cover.JPG'/>";
	echo "<h3>商户关注推广任务 - 封面包含的信息</h3><table width='80%'>";
	echo "<tr><th>任务标题</th><th>任务介绍</th><th>图标/LOGO</th><th>模式(0不可重复，1可重复)</th><th>任务类型</th><th>mission_type</th><th>mission_id</th><th>任务状态</th><th>参与人数</th><th>按钮</th></tr>";
while(@$row=mysql_fetch_array($r)){
	echo "<tr><td>$row[0]</td><td>$row[1]</td><td><img src='../../admin/client/$row[4]'/></td><td>$row[6]</td><td>$row[7]</td><td>$row[3]</td><td>$row[2]</td><td>$row[8]</td><td>$row[5]</td>";
	echo "<td id='m$row[2]'>";
	init_Btn($user_id,$row[2],$row[3]);
	echo "</td></tr>";
}
	echo "</table>";
/************************表格-END*****************************/
include ('includes/footer.html');//包含尾部
?>

<script>
function mission_go(user_id,id,type,um_state){
var xmlhttp;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
	    document.getElementById("m"+id).innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET","mission.php?mission_type="+type+"&mission_id="+id+"&um_state="+um_state+"&user_id="+user_id,true);
xmlhttp.send();
}
</script>
