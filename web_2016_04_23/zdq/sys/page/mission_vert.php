<?php
$user_id=$_GET['user_id'];
$id=$_GET['mission_id'];
$type=$_GET['mission_type'];
$vert_id=$_GET['vert_id'];
$answer=$_GET['answer'];
if($user==""||$id==""||$type==""||$vert_id==""){
	$error=1;//参数异常
}
else{
	if($answer==""){
		$error=2;//您没有输入问题答案
	}
	else{//$answer!=""
	  require('../../../mysql_connect.php');
	  $sql="select vertification_answer from vertification where vert_id='$vert_id'";
	  $r=mysql_query($sql);
	  $row=mysql_fetch_array($r);
	  if($answer==$row[0]){	//答案验证通过
	  		mysql_query("START TRANSACTION");
			$sql="update user_mission set hand_time=NOW(),state='2',n=n+1 where mission_type='$type' and mission_id=$id and user_id=$user_id limit 1";
			if(mysql_query($sql)){
				$sql="select user_mission_id from user_mission where mission_type='$type' and mission_id=$id and user_id=$user_id limit 1";
				$r=mysql_query($sql);
				$row=mysql_fetch_array($r);
				$um_id=$row[0];
				$sql="select profit from $table where mission_type='$type' and mission_id=$id";
				$r=mysql_query($sql);
				$row=mysql_fetch_array($r);
				$profit=$row[0];
				$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values($um_id,$user_id,$profit,NOW())";
				if(mysql_query($sql)){
					$sql="update user set used_times=used_times+1 where user_id=$user_id";
					if(mysql_query($sql)){
						mysql_query("COMMIT");
						$error=0;

					}
		
				}
		
			}
	  	
	  }//END-答案验证通过
	}//END-$answer!=""
}/*************************END-if($user_id==""||$id==""||$type=="")***************************/
if($error!=""){
	switch($error){
		case 0: echo $profit."<br/>已领取08";break;
		case 1: echo "参数异常";break;
		case 2: echo "您没有输入问题答案";break;
		default:echo "参数异常：03";break;
	}	
}
?>