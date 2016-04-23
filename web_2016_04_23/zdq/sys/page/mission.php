<?php
$user_id=$_GET['user_id'];
$id=$_GET['mission_id'];
$type=$_GET['mission_type'];
$um_state=$_GET['um_state'];
if($user_id==""||$id==""||$type==""){
	echo "参数异常";
}
else{
	
require('../../../mysql_connect.php');
$sql="select from_table from mission_type where mission_type='$type'";
$r=mysql_query($sql);
$row=mysql_fetch_array($r);
$table=$row[0];
$check_mission=checkMission($id,$type,$table);
if($check_mission!='1'){	
	echo $check_mission;
}
else if($check_mission=='1'){
if($um_state==NULL){
	mysql_query("START TRANSACTION");
	$sql="select vertification from $table where mission_type='$type' and mission_id=$id";
	//vert_id vertification
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$vert_ids=$row[0];
	$vert_sub=explode(';',$vert_ids);
	$vert_id=$vert_sub[array_rand($vert_sub,1)];
	$sql="insert into user_mission(user_id,mission_id,mission_type,take_time,vert_id,state) values($user_id,$id,'$type',NOW(),'$vert_id','1')";
	if(mysql_query($sql)){
	$sql="update $table set profit_rest=profit_rest-profit,join_n=join_n+1 where mission_type='$type' and mission_id=$id limit 1";
		if(mysql_query($sql)){
			mysql_query("COMMIT");
						$um_state='1';
?>
<input type="button" value="打开红包00" onclick="mission_go(<?php echo "$user_id,$id,'$type','$um_state'"?>)"/>
<?php
		}
	}

}
else if($um_state=='0'){
	mysql_query("START TRANSACTION");
	$sql="select vertification from $table where mission_type='$type' and mission_id=$id";
	//vert_id vertification
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$vert_ids=$row[0];
	$vert_sub=explode(';',$vert_ids);
	$vert_id=$vert_sub[array_rand($vert_sub,1)];
	$sql="update user_mission set take_time=NOW(),vert_id='$vert_id',state='1' where mission_type='$type' and mission_id=$id and user_id=$user_id limit 1";
	if(mysql_query($sql)){
	$sql="update $table set profit_rest=profit_rest-profit,join_n=join_n+1 where mission_type='$type' and mission_id=$id limit 1";
		if(mysql_query($sql)){
			mysql_query("COMMIT");
			$um_state='1';
?>
<input type="button" value="打开红包07" onclick="mission_go(<?php echo "$user_id,$id,'$type','$um_state'"?>)"/>
<?php
		}
	}

}
else if($um_state=='1'){

$sql="select vert_id from user_mission where mission_type='$type' and mission_id=$id and user_id=$user_id";
$r=mysql_query($sql);
$row=mysql_fetch_array($r);
$vert_id=$row[0];
if($vert_id==0){//vert_id if 0 
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
				echo $profit."<br/>";
				echo "已领取08";
			}

		}

	}

}
else{//vert_id if !=0
	$sql="select vertification_question from vertification where vert_id=$vert_id";
	$r=mysql_query($sql);
	$row=@mysql_fetch_array($r);
	echo "问题：$row[0]<br/>问题id：$vert_id<br/>用户id：$user_id<br/>mission_id：$id<br/>mission_type：$type";
}
}
}
}/********************END-if($user_id==""||$id==""||$type=="")*********/
/*******************function checkMission($id,$type,$table)********************/
function checkMission($id,$type,$table){	
$sql="select state,profit_rest,profit,repeat_c from $table where mission_type='$type' and mission_id=$id";
$r=mysql_query($sql);
$row=@mysql_fetch_array($r);
$m_state=$row[0];
if($m_state=='0'){
return "任务已结束10";
}
else if($m_state=='2'){
return "任务维护中20";
}
else if($m_state=='1'){

	if($row[1]==0||$row[1]<$row[2]){//查余额
	$sql="update $table set state='0' where mission_type='$type' and mission_id=$id limit 1";
	mysql_query($sql);
	return "红包抢完啦";

	}
	else{
	    $sql="select if((end_time-NOW())*(start_time-NOW())<0,'1','0') from $table where mission_type='$type' and mission_id=$id";
		$r=mysql_query($sql);
		$row2=mysql_fetch_array($r);
		if($row2[0]=='1'){//查期限
		//任务检查可用
		return "1";
		}
		else if($row2[0]=='0'){
			$sql="select if((start_time-NOW())<0,'0','1') from $table where mission_type='$type' and mission_id=$id";
			$r=mysql_query($sql);
			$row=mysql_fetch_array($r);
			if($row[0]=='1')
				return "一大波红包接近中...";
			else{
				$sql="update $table set state='0' where mission_type='$type' and mission_id=$id limit 1";
				mysql_query($sql);
				return "任务结束，下次来早点哦";

			}
		}//查期限
	}//查余额
	
	
}//m_state=1

}
/*******************END-function checkMission($id,$type,$table)********************/
?>