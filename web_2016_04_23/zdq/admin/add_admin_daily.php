<?php
session_start();
if(!isset($_SESSION["zdq_admin_s"])){ //判断当前会话变量是否注册
   if(!isset($_COOKIE["zdq_admin_c"]))//查cookie
   {
    header("location: login.php?page=aad");//session和cookie都没有记录
   }
}
//已经注册session 则使用当前session
$mission_type=2;//系统每日任务 admin_mission_daily
$table="admin_mission_daily";
$id="mission_id";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加系统每日任务</title>
<link rel="stylesheet" type="text/css" href="timepicker/css/jquery-ui.css" />
<style type="text/css">
body{height:100%; font:12px/18px Tahoma, Helvetica, Arial, Verdana, "\5b8b\4f53", sans-serif; color:#51555C;}
img{
border:none;}
a{
text-decoration:none;}
.error {
font-weight: bold;
color: #C00;
}

</style>
<script type="text/javascript" charset="utf-8" src="js/function.js"></script>
<script type="text/javascript" src="timepicker/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="timepicker/js/jquery-ui.js"></script>
<script type="text/javascript" src="timepicker/js/jquery-ui-slide.min.js"></script>
<script type="text/javascript" src="timepicker/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(function(){
	$('#example_1').datetimepicker();
		$('#example_2').datetimepicker();

});
</script>
</head>

<body>
<?php
 # Script 11.2 - upload_image

// Check if the form has been submitted:
if (isset($_POST['add-resource'])&&$_SERVER['REQUEST_METHOD'] == 'POST') {

	// Check for an uploaded file:
	if (isset($_FILES['upload'])) {
		
		// Validate the type. Should be JPEG or PNG.
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png','text/plain');
		if (in_array($_FILES['upload']['type'], $allowed)) {
		
			// Move the file over.
			$type=$_GET['type'];
			$id=$_GET['id'];
			$dir1='../../uploads/'.$type;
			$dir2='../../uploads/'.$type.'/'.$id;
			$pathinfo = pathinfo($_FILES['upload']['name']);
			$file_dir=$dir2.'/'.time().rand(1000,9999).".".$pathinfo['extension'];
			$file_exit=0;
			if(!is_dir($dir1)){
				if(mkdir($dir1)){
					if(!is_dir($dir2)){
						if(mkdir($dir2)){$file_exit=1;}
					}
				}
			}
			else{
				if(!is_dir($dir2)){
					if(mkdir($dir2)){$file_exit=1;}
				}
				else{$file_exit=1;
				}

			}
			if($file_exit==1){	
				require('../../mysql_connect.php');
	
				$sql="select resource_id from resource where resource_url='$file_dir'";
				$r=mysql_query($sql);
				if(mysql_num_rows($r)==0){
					if (move_uploaded_file ($_FILES['upload']['tmp_name'], $file_dir)) {
						//insert into sql
						$sql="select from_table from mission_type where mission_type='$type'";
						$r=mysql_query($sql);
						$row=mysql_fetch_array($r);
						$table=$row[0];
						mysql_query("START TRANSACTION");
						$sql="insert into resource(mission_id,mission_type,resource_type,resource_url) values($id,'$type','img','$file_dir')";
						if(mysql_query($sql)){
							$sql="update $table set resource_amount=resource_amount+1 where mission_type='$type' and mission_id=$id limit 1";
							if(mysql_query($sql)){
								mysql_query("COMMIT");
							}
						}
						echo '<p><em>文件上传成功！</em></p>';
					} // End of move... IF.
				}
				else{
					echo '<p class="error">存在同名文件，上传失败。</p>';
				}
			}
			else{
				echo '<p class="error">服务器端创建文件失败。</p>';
			}
		} else { // Invalid type.
		echo $_FILES['upload']['type'];
			echo '<p class="error">请选择JPEG或PNG文件上传。</p>';
		}

	} // End of isset($_FILES['upload']) IF.
	
	// Check for an error:
	if ($_FILES['upload']['error'] > 0) {
		echo '<p class="error">由于以下原因，文件无法上传: <strong>';
	
		// Print a message based upon the error.
		switch ($_FILES['upload']['error']) {
			case 1:
				print 'The file exceeds the upload_max_filesize setting in php.ini.';
				break;
			case 2:
				print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
				break;
			case 3:
				print 'The file was only partially uploaded.';
				break;
			case 4:
				print 'No file was uploaded.';
				break;
			case 6:
				print 'No temporary folder was available.';
				break;
			case 7:
				print 'Unable to write to the disk.';
				break;
			case 8:
				print 'File upload stopped.';
				break;
			default:
				print 'A system error occurred.';
				break;
		} // End of switch.
		
		print '</strong></p>';
	
	} // End of error IF.
	
	// Delete the file if it still exists:
	if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
		unlink ($_FILES['upload']['tmp_name']);
	}
			
} // End of the submitted conditional.


if(isset($_POST['submit'])&&$_SERVER['REQUEST_METHOD']=='POST'){
$arr[]=$_POST['title'];//title 0
$arr[]=$_POST['intro'];//intro
$arr[]=$_POST['repeat_c'];//repeat_c
$arr[]=$_POST['interval_i'];//interval_i     num
$arr[]=$_POST['start_time'];//start_time
$arr[]=$_POST['end_time'];//end_time 5
$arr[]=$_POST['profit'];//profit             num
$arr[]=$_POST['total_profit'];//total_profit      num
$arr[]=$_POST['state'];//state
$arr[]=$_POST['order_v'];//order_v          num
$arr[]=$_COOKIE['zdq_admin_c'];//admin_id 10
$arr[]=$mission_type;//mission_type
$wrong=0;
print_r($arr);//输出上传的信息
for($i=0;$i<count($arr);$i++){
if($arr[$i]==NULL) $wrong=1;break;
}
if($wrong!=1){
if(!is_numeric($arr[3])||!is_numeric($arr[6])||!is_numeric($arr[7])||!is_numeric($arr[9])){$wrong=1;}
}
if($wrong!=1){
require('../../mysql_connect.php');
$sql="select * from admin_mission where ad_mission_title='$arr[0]' limit 1";
$result=mysql_query($sql);
if(mysql_num_rows($result)==0){
mysql_query("START TRANSACTION");
$sql="insert into admin_mission(ad_mission_title,ad_mission_intro,admin_id,mission_type,order_v) values('$arr[0]','$arr[1]',$arr[10],'$arr[11]','$arr[9]')";
if(mysql_query($sql)){
$sql="insert into admin_mission_daily(mission_id,mission_type,repeat_c,interval_i,start_time,end_time,profit,total_profit,profit_rest,state) values(last_insert_id(),'$arr[11]','$arr[2]',$arr[3],'$arr[4]','$arr[5]','$arr[6]','$arr[7]','$arr[7]','$arr[8]')";
if(mysql_query($sql)){
mysql_query("COMMIT");echo "<b>任务添加成功！</b>";
}else echo "<b>任务添加失败01！</b>";
}else echo "<b>任务添加失败02！</b>";
}
else
echo "<b>该类任务中已存在同名任务！</b>";

}
else{
echo "<b>请将信息输入完整！并确保输入正确！</b>";
}

}

if(isset($_POST['revise'])&&$_SERVER['REQUEST_METHOD']=='POST'){
$arr[]=$_POST['title'];//title 0
$arr[]=$_POST['intro'];//intro
$arr[]=$_POST['repeat_c'];//repeat_c  2
$arr[]=$_POST['interval_i'];//interval_i     num
$arr[]=$_POST['start_time'];//start_time
$arr[]=$_POST['end_time'];//end_time 5
$arr[]=$_POST['profit'];//profit             num
$arr[]=$_POST['total_profit'];//total_profit      num
$arr[]=$_POST['state'];//state
$arr[]=$_POST['order_v'];//order_v          num
$arr[]=$_COOKIE['zdq_admin_c'];//admin_id 10
$arr[]=$mission_type;//mission_type
$arr[]=$_POST['profit_rest'];//profit_rest
$arr[]=$_POST['mission_id'];//mission_id  13
$wrong=0;
print_r($arr);
for($i=0;$i<count($arr);$i++){
if($arr[$i]==NULL) $wrong=1;
}
if(!is_numeric($arr[3])||!is_numeric($arr[6])||!is_numeric($arr[7])||!is_numeric($arr[9])||!is_numeric($arr[12])){$wrong=1;}
if($wrong!=1){
require('../../mysql_connect.php');

mysql_query("START TRANSACTION");
$sql="update admin_mission set ad_mission_title='$arr[0]',ad_mission_intro='$arr[1]',order_v='$arr[9]' where $id=$arr[13] and mission_type=$arr[11] limit 1";
if(mysql_query($sql)){
$sql="update admin_mission_daily set repeat_c='$arr[2]',interval_i=$arr[3],start_time='$arr[4]',end_time='$arr[5]',profit='$arr[6]',total_profit='$arr[7]',profit_rest='$arr[12]',state='$arr[8]' where $id=$arr[13] and mission_type=$arr[11] limit 1";
if(mysql_query($sql)){
mysql_query("COMMIT"); echo "<b>任务修改成功！</b>";
}else echo "<b>任务修改失败01！</b>";
}else echo "<b>任务修改失败02！</b>";


}
else{
echo "<b>请将信息输入完整！并确保输入正确！</b>";
}

}

?>
<h2>系统日常任务添加</h2>

<!--**************************************form1*******************************************-->

<form action="" method="post" id="form1">
任务标题：<input name="title" type="text"/><br/>
任务介绍：<textarea  name="intro" ><?php if(isset($_POST['submit'])) echo $_POST['intro']?></textarea><br/>
是否可重复领取：
否：<input type="radio" name="repeat_c" value="0" checked="checked">
是:<input type="radio" name="repeat_c" value="1" <?php if($_POST['repeat_c']==1&&isset($_POST['submit'])) echo "checked='checked'";?>><br/>
重复领取间隔时间（时）：<input name="interval_i" type="text"  value="<?php if(isset($_POST['submit'])) echo $_POST['interval_i']?>"/><br/>
任务发布时间：<input name="start_time" type="text"  value="<?php if($_POST['start_time']!=NULL&&isset($_POST['submit'])) echo $_POST['start_time']; else echo '0000-00-00 00:00:00';?>" id="example_1" readonly="readonly"/><br/>
任务结束时间：<input name="end_time" type="text"  value="<?php if($_POST['end_time']!=NULL&&isset($_POST['submit'])) echo $_POST['end_time']; else echo '0000-00-00 00:00:00';?>"  id="example_2" readonly="readonly"/><br/>
完成任务收益（元）：<input name="profit" type="text"  value="<?php if(isset($_POST['submit'])) echo $_POST['profit']?>"/><br/>
投入总金额（元）：<input name="total_profit" type="text"  value="<?php if(isset($_POST['submit'])) echo $_POST['total_profit']?>"/><br/>
任务初始状态：不发布：<input type="radio" name="state" value="0" checked="checked">
直接发布：<input type="radio" name="state" value="1"  <?php if($_POST['state']==1&&isset($_POST['submit'])) echo "checked='checked'";?>><br/>

任务权重（同级任务排序）：<input name="order_v" type="text"  value="<?php if(isset($_POST['submit'])) echo $_POST['order_v']?>"/><br/>
<input value="添加" name="submit" type="submit"/><input type="reset" name="reset" value="清空" />
</form>

<!--**************************************form2*******************************************-->


<form action="" method="post" id="form2" style="display:none">
</form>
<div id="form-add"  style="display:none">
</div>




<?php
require('../../mysql_connect.php');
$sql="select am.mission_id,ad_mission_title,state from admin_mission as am left join $table USING(mission_id) order by order_v desc";
//echo $sql."<br/>";
$result=mysql_query($sql);
?>
<table>
<thead>
<tr><th>任务标题</th><th>任务状态</th><th>结束任务</th><th>暂停任务</th><th>继续任务</th><th>删除</th></tr>
</thead>
<tbody>
<?php 
while($row=mysql_fetch_array($result)){
$row[2]=str_replace("1","<font color='green'><b>进行中</b></font>",$row[2]);
$row[2]=str_replace("0","<font color='blue'>终止</font",$row[2]);
$row[2]=str_replace("2","<font color='red'>暂停</font",$row[2]);

echo "<tr><td><a href='javascript:Revise($mission_type,$row[0])'>$row[1]</a></td><td id='m$row[0]'>$row[2]</td><td><a href='javascript:StateChange($mission_type,$row[0],0)'><img src='icon/stop.png' /></a></td><td><a href='javascript:StateChange($mission_type,$row[0],2)'><img src='icon/pause.png'/></a></td><td><a href='javascript:StateChange($mission_type,$row[0],1)'><img src='icon/run.png'/></a></td><td><a href='javascript:Delete($mission_type,$row[0])'><img src='icon/delete.png'/></a></td></tr>";

}

?>
</tbody>
</table>
<div id="pre" style="display:none"></div>
</body>
</html>
<script>
function Del_Pre(){
document.getElementById("pre").style.display="none";
}
function PreviewPage(type,id){
document.getElementById("pre").style.display="block";
var xmlhttp;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
	    document.getElementById("pre").innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET","mission_preview.php?type="+type+"&id="+id,true);
xmlhttp.send();
}

function AddResource(type,id){
document.getElementById("form-add").style.display="block";
var xmlhttp;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
	    document.getElementById("form-add").innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET","add_resource.php?type="+type+"&id="+id,true);
xmlhttp.send();
}
function Return(){
document.getElementById("form2").style.display="none";
document.getElementById("form1").style.display="block";
document.getElementById("form-add").style.display="none";
}
function Revise(type,id){
document.getElementById("form1").style.display="none";
document.getElementById("form2").style.display="block";
document.getElementById("form-add").style.display="none";

var xmlhttp;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
	    document.getElementById("form2").innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET","mission.php?type="+type+"&id="+id,true);
xmlhttp.send();

}
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
function Delete(type,id){
if(window.confirm("你真的要删除此记录吗？这将是不可逆的！！！")){
if(window.confirm("请您再次确认删除！！！")){

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
xmlhttp.open("GET","delete_mission.php?type="+type+"&id="+id,true);
xmlhttp.send();

return ture;
}}
}

function changeROC(name,m,type,id,del){
var n=0;
if(del==-1){
n=1;
var myselect=document.getElementById(name);
var index=myselect.selectedIndex;
var roc=myselect.options[index].value;
}
else{
		if(window.confirm("你真的要删除此记录吗？这将是不可逆的！！！")){
		if(window.confirm("请您再次确认删除！！！")){n=1;}
		}
}
if(n==1){
var xmlhttp;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
	    document.getElementById("span_"+m).innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET","js/change_roc.php?name="+name+"&roc="+roc+"&type="+type+"&id="+id+"&del="+del,true);
xmlhttp.send();
}
}
</script>
<script>
function dyniframesize(down){
	var Sys={};
	var ua=navigator.userAgent.toLowerCase();
	var s;
	(s=ua.match(/msie ([\d.]+)/))?Sys.ie=s[1]:
	(s=ua.match(/firefox\/([\d.]+)/))?Sys.firefox=s[1]:
	(s=ua.match(/chrome\/([\d.]+)/))?Sys.chrome=s[1]:
	(s=ua.match(/opera.([\d.]+)/))?Sys.opera=s[1]:
	(s=ua.match(/version\/([\d.]+).*safari/))?Sys.safari=s[1]:0;

	var pTar=null;
	if (document.getElementById){
		pTar=document.getElementById(down);
	}else{
		eval('pTar='+down+';');
	}
	pTar.style.display="block";
	
	if (Sys.ie){
		if(Sys.ie=='9.0'){
			pTar.height=pTar.contentWindow.document.body.offsetHeight+15+"px";
			//pTar.width=pTar.contentWindow.document.body.scrollWidth+"px";
		}else if(Sys.ie=='8.0'){
			pTar.height=pTar.Document.body.offsetHeight+15+"px";
			//pTar.width=pTar.Document.body.scrollWidth+"px";
		}else{
			pTar.height=pTar.Document.body.scrollHeight+25+"px";
			//pTar.width=pTar.Document.body.scrollWidth+"px";
		}
	}
	if (Sys.firefox){
		pTar.height=pTar.contentDocument.body.offsetHeight+15+"px";
		//pTar.width=pTar.contentDocument.body.scrollWidth+"px";
	}
	if (Sys.chrome){
		pTar.height=pTar.contentDocument.body.offsetHeight;
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}
	if (Sys.opera){
		pTar.height=pTar.contentDocument.body.offsetHeight;
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}
	if (Sys.safari){						        	
		if(pTar.contentDocument.body.offsetHeight <= '186'){
			pTar.height=pTar.contentDocument.body.offsetHeight+10;
		}else{
			pTar.height=pTar.contentDocument.body.offsetHeight;
		}
		//pTar.width=pTar.contentDocument.body.scrollWidth;
	}

}
</script>