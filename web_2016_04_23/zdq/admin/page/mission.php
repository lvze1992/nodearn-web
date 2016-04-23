<?php
$user_id=$_GET['user_id'];
$id=$_GET['mission_id'];
$type=$_GET['mission_type'];
$um_state=$_GET['um_state'];
	require('../../../mysql_connect.php');
if($um_state==NULL){
	mysql_query("START TRANSACTION");
	$sql="select from_table from mission_type where mission_type='$type'";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$table=$row[0];
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
	$sql="select from_table from mission_type where mission_type='$type'";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$table=$row[0];
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
		$sql="select from_table from mission_type where mission_type='$type'";
		$r=mysql_query($sql);
		$row=mysql_fetch_array($r);
		$table=$row[0];
		$sql="select profit from $table where mission_type='$type' and mission_id=$id";
		$r=mysql_query($sql);
		$row=mysql_fetch_array($r);
		$profit=$row[0];
		$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values($um_id,$user_id,$profit,NOW())";
		if(mysql_query($sql)){
			$sql="update user set used_times=used_times+1 where user_id=$user_id";
			if(mysql_query($sql)){
				mysql_query("COMMIT");
				echo "<input type='hidden' value='$profit' id='profitbox'/>";
				echo "<input type='button' value='已领取08'/>";
			}

		}

	}

}
else{//vert_id if !=0
	echo "5";
}
}
?>