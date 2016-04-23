<?php
$type=$_GET['type'];
$id=$_GET['id'];
$state=$_GET['state'];
if($type!=NULL&&$id!=NULL&&$state!=NULL){
require('../../../mysql_connect.php');
$sql="select from_table from mission_type where mission_type='$type'";
if($result=mysql_query($sql)){
$row=mysql_fetch_array($result);
$table=$row[0];
$sql="update $table set state='$state' where mission_id=$id and mission_type=$type limit 1";
if(mysql_query($sql)){

$state=str_replace("1","<font color='green'>正常</font>",$state);
$state=str_replace("3","<font color='red'><b>审核未通过</b></font>",$state);
//$state=str_replace("2","<font color='red'>暂停</font",$state);

    echo $state;
}
}


}
?>