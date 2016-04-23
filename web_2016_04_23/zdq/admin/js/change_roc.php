<?php
require('../../../mysql_connect.php');
$name=$_GET['name'];
$roc=$_GET['roc'];
$type=$_GET['type'];
$id=$_GET['id'];
$del=$_GET['del'];

if($del==1){
	$sql="select from_table from mission_type where mission_type='$type'";
	if($result=mysql_query($sql)){
	$row=mysql_fetch_array($result);
	$table=$row[0];
	$sql="select resource_url from resource where resource_id=$name";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$file="../".$row[0];
		if(unlink($file)){

			mysql_query("START TRANSACTION");
			$sql="delete from resource where resource_id=$name limit 1";
			if(mysql_query($sql)){
				$sql="update $table set resource_amount=resource_amount-1 where mission_id=$id and mission_type='$type' limit 1";
				if(mysql_query($sql)){
					mysql_query("COMMIT");
					echo "<em>已删除</em>";
				}
			}
		}
		else{
					echo "<em>删除失败</em>";
		}
	}
}
else if($del==-1){
	if(substr($name,0,5)=='class'){
	$name=substr($name,6);
	$sql="update resource set class='$roc' where resource_id=$name limit 1";
	if(mysql_query($sql)){
		echo "<em>一类修改为$roc</em>";
		}
	}
	else{
	$name=substr($name,6);
	$sql="update resource set order_v='$roc' where resource_id=$name limit 1";
	if(mysql_query($sql)){
		echo "<em>二序修改为$roc</em>";
		}
	}
}
?>