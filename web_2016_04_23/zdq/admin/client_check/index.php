<?php
$title="商户推广任务审核";
include('includes/head.html');
?>
<p><a  href="?release=true">发布的任务</a>|<a  href="?release=false">待审核</a>|<a href="login.php?doLogout=true">注销</a>|<a href="index_readmission.php">提升文章阅读审核</a></p>
<?php
if ((isset($_GET['release'])) &&($_GET['release']=="true")){
	$sql="select client_mission_title,client_mission_intro,cm.mission_id,cm.mission_type,logo_small,repeat_c,mt.mission_title,state from client_mission as cm inner join client_mission_wetalk using(mission_id) inner join mission_type as mt on cm.mission_type=mt.mission_type where state=1 or state=2 order by order_v desc,state asc";
$tab="-审核通过/发布";

}
else{
$sql="select client_mission_title,client_mission_intro,cm.mission_id,cm.mission_type,logo_small,repeat_c,mt.mission_title,state from client_mission as cm inner join client_mission_wetalk using(mission_id) inner join mission_type as mt on cm.mission_type=mt.mission_type where state!=1 and state!=2 order by order_v desc,state asc";
$tab="-审核通过-未通过-状态异常";
}
?>
<h3>商户推广任务审核 <span style="font-size:12px"><?php echo $tab;?></span></h3>
<table cellpadding="0" cellspacing="0" width="80%" class="table-style">
<thead>
<tr><th>任务标题</th><th>任务介绍</th><th>图标/LOGO</th><th>模式</th><th>任务类型</th><th>任务状态</th><th>审核通过/发布</th><th>审核不通过</th></tr>
</thead>
<tbody>
<?php 
$r=mysql_query($sql);
while($row=mysql_fetch_array($r)){
$row[7]=str_replace("0","<font color='blue'><b>待审核</b></font>",$row[7]);
$row[7]=str_replace("3","<font color='red'><b>审核未通过</b></font>",$row[7]);
$row[7]=str_replace("1","<font color='green'>正常</font>",$row[7]);
$row[7]=str_replace("2","<font color='black'>暂停</font>",$row[7]);
$row[5]=str_replace("0","不可重复",$row[5]);
$row[5]=str_replace("1","可重复",$row[5]);
echo "<tr><td>$row[0]</td><td>$row[1]</td><td><img src='../client/$row[4]'/></td><td>$row[5]</td><td>$row[6]</td><td id='m$row[2]'>$row[7]</td><td><a href='javascript:StateChange($row[3],$row[2],1)'>通过</a></td><td><a href='javascript:StateChange($row[3],$row[2],3)'>不通过</a></td></tr>";
//echo "<tr><td><a href='javascript:Revise($mission_type,$row[0])'>$row[1]</a></td><td id='m$row[0]'>$row[2]</td><td><a href='javascript:StateChange($mission_type,$row[0],0)'><img src='icon/stop.png' /></a></td><td><a href='javascript:StateChange($mission_type,$row[0],2)'><img src='icon/pause.png'/></a></td><td><a href='javascript:StateChange($mission_type,$row[0],1)'><img src='icon/run.png'/></a></td><td><a href='javascript:Delete($mission_type,$row[0])'><img src='icon/delete.png'/></a></td></tr>";

}

?>
</tbody>
</table>
<div id="pre" style="display:none"></div>
<?php
include('includes/foot.html');
?>
<script>
function StateChange(type,id,state){
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
xmlhttp.open("GET","change_state.php?type="+type+"&id="+id+"&state="+state,true);
xmlhttp.send();
}

</script>