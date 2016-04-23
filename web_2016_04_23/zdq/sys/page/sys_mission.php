<?php
$apptitle="系统任务";
include ('includes/head.html');
include ('mission_state.php');

require('../../../mysql_connect.php');
$id="mission_id";
$type="2";//系统日常任务
$user_id=1;//用户主键id
$sql="select * from admin_mission where mission_type='$type' order by order_v desc";
$result=mysql_query($sql);
echo "<ul>";
while($row=mysql_fetch_array($result)){
    echo "<li>";
	$sql="select resource_url from resource where mission_type='$row[mission_type]' and mission_id=$row[mission_id] and class='0' order by order_v desc limit 1";
	$r=mysql_query($sql);
	$row2=@mysql_fetch_array($r);
	echo $row2[0];//背景图片路径
	$sql="select profit from admin_mission_daily where mission_id=$row[mission_id]";
	$r=mysql_query($sql);
	$row3=@mysql_fetch_array($r);
	echo "<br/>可获得".$row3[0]."元";//显示该任务收益

	echo "<h3>$row[1]</h3><h6>$row[2]</h6><div id='m$row[mission_id]'>";
	init_Btn($user_id,$row[mission_id],$row[mission_type]);
	echo "</div></li>";
}
echo "</ul>";
?>
<?php
include ('includes/footer.html');
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
