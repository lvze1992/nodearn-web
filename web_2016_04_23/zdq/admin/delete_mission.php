<?php
$type=$_GET['type'];
$id=$_GET['id'];
$dmwrong=1;
if($type!=NULL&&$id!=NULL){
require('../../mysql_connect.php');
$sql="select from_table from mission_type where mission_type='$type'";
if($result=mysql_query($sql)){
$row=mysql_fetch_array($result);
$table=$row[0];
mysql_query("START TRANSACTION");
$sql="delete from $table where mission_id=$id and mission_type='$type' limit 1";
if(mysql_query($sql)){
$sql="delete from admin_mission where mission_id=$id and mission_type='$type' limit 1";
if(mysql_query($sql)){

if(mysql_query("COMMIT")){

$state="<font color='#666666'><b>已删除</b></font>";
$dmwrong=0;
    echo $state;
}
}
}


}
}
if($dmwrong==1){
$state="<font color='#666666'><b>删除失败</b></font>";
    echo $state;

}
?>