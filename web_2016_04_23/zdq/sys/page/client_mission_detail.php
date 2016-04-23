<?php
$apptitle="商户关注推广任务";
include ('includes/head.html');//包含头部
include ('mission_state.php');
require('../../../mysql_connect.php');
$id=16;//$_GET['mission_id']
$type="13";//商户推广任$_GET['mission_type']务
$user_id=1;//用户主键id $_GET['user_id']
$sql="select client_mission_title,client_mission_intro,logo_big,join_n,profit,repeat_c,mt.mission_title,state,intro_flow from client_mission as cm inner join client_mission_wetalk using(mission_id) inner join mission_type as mt on cm.mission_type=mt.mission_type where cm.mission_id=$id and cm.mission_type='$type'";
$r=mysql_query($sql);
$sql="select resource_type,resource_url,resource_txt from resource where mission_id=$id and mission_type='$type' order by order_v asc";
$r2=mysql_query($sql);
/************************输出内容表格*****************************/
	echo "<div style='width:45%;float:left'><h3>详情页示例<br/>（把可重复领取的任务，选择合适的地方提示下，例如标题旁）</h3>";
	echo "<img src='includes/detail.jpg'/></div>";
	echo "<div style='width:55%;float:left'><h3>商户关注推广任务 - 详细内容包含的信息</h3>";
	echo "</h3><table width='90%'>";
	echo "<tr><th>项目</th><th>数据库名</th><th>内容</th></tr>";
	
@$row=mysql_fetch_array($r);
	echo "<tr><td>任务标题</td><td>client_mission_title</td><td>$row[0]</td></tr>";
	echo "<tr><td>参与人数</td><td>join_n</td><td>$row[3]</td></tr>";
	echo "<tr><td>任务介绍</td><td>client_mission_intro</td><td>$row[1]</td></tr>";
	echo "<tr><td>返利金额</td><td>profit</td><td>$row[4]</td></tr>";
	echo "<tr><td>任务大图标</td><td>logo_big</td><td>$row[2]</td></tr>";
	echo "<tr><td>是否可重复（0不可；1可）</td><td>repeat_c</td><td>$row[5]</td></tr>";
	echo "<tr><td>任务类型</td><td>mission_title</td><td>$row[6]</td></tr>";
	echo "<tr><td>任务状态</td><td>state</td><td>$row[7]</td></tr>";
	echo "<tr><td>任务流程提示</td><td>intro_flow</td><td>$row[8]</td></tr>";
	echo "<tr><td>按钮/文字</td><td></td><td id='m$id'>";
	init_Btn($user_id,$id,$type);
	echo "</td></tr>";
	
/************************资源图片文字*****************************/
	echo "<tr><th>资源类型</th><th colspan='2'>资源内容</th></tr>";
while(@$row2=mysql_fetch_array($r2)){	
	if($row2[0]=='txt')
		echo "<tr><td>$row2[0]</td><td colspan='2'>$row2[2]</td></tr>";
	else if($row2[0]=='img')
		echo "<tr><td>$row2[0]</td><td colspan='2'>$row2[1]</td></tr>";	
}
/************************END-资源图片文字*****************************/	
	echo "</table></div>";
	
/************************END-输出内容表格*****************************/
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
