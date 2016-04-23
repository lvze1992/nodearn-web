<?php
function init_Btn($user,$id,$type){
require('../../../mysql_connect.php');
$sql="select from_table from mission_type where mission_type='$type'";
$r=mysql_query($sql);
$row=@mysql_fetch_array($r);
$table=$row[0];
$sql="select state,profit_rest,profit,repeat_c from $table where mission_type='$type' and mission_id=$id";
$r=mysql_query($sql);
$row=@mysql_fetch_array($r);
$m_state=$row[0];
if($m_state=='0'){
echo "<input type='button' value='任务结束10'/>";
}
else if($m_state=='2'){
echo "<input type='button' value='任务维护20'/>";
}
else if($m_state=='1'){

	if($row[1]==0||$row[1]<$row[2]){//查余额
	echo "<input type='button' value='任务结束3'/>";
	$sql="update $table set state='0' where mission_type='$type' and mission_id=$id limit 1";
	mysql_query($sql);
	}
	else{
	    $sql="select if((end_time-NOW())*(start_time-NOW())<0,'1','0') from $table where mission_type='$type' and mission_id=$id";
		$r=mysql_query($sql);
		$row2=mysql_fetch_array($r);
		if($row2[0]=='1'){//查期限
		//查用户任务状态
			$sql="select state from user_mission where mission_type='$type' and mission_id=$id and user_id=$user";
			$r=mysql_query($sql);
			$row1=mysql_fetch_array($r);
			$um_state=$row1[0];
			if($um_state=='0'||$um_state==NULL){
			// 查用户可领取次数
			$sql="select if(available_times-used_times+more_times>0,'1','0') from user where user_id=$user";	
			$r=mysql_query($sql);
			$row=mysql_fetch_array($r);
			if($row[0]=='0'){
				echo "<input type='button' value='领取次数耗尽50'  style='font-size:12px'/>";
			}
			else if($row[0]=='1'){
?>
<input type="button" value="领取任务60" onclick="mission_go(<?php echo "$user,$id,'$type','$um_state'"?>)"/>
<?php
			}
			
			}
			else if($um_state=='2'){//查用户任务状态
				if($row[3]=='0'){//任务不可重复
								echo "<input type='button' value='已领取96'/>";
				}
				else{//任务可重复领取
					$sql="select take_time,NOW() from user_mission where mission_type='$type' and mission_id=$id and user_id=$user";
					$r=mysql_query($sql);
					$row=mysql_fetch_array($r);
					$take_time=strtotime($row[0]);
					$now=strtotime($row[1]);							
					$sql="select if($now-$take_time>interval_i*60*60,'1','0') from $table where mission_type='$type' and mission_id=$id";
					$r=mysql_query($sql);
					$row=mysql_fetch_array($r);
						if($row[0]=='1'){
							$sql="update user_mission set state='0' where mission_type='$type' and mission_id=$id and user_id=$user limit 1";
							if(mysql_query($sql))
							init_Btn($user,$id,$type);
							
						}
						else if($row[0]=='0'){
							echo "<input type='button' value='冷却中90'/>";
	$sql="select take_time from user_mission where mission_type='$type' and mission_id=$id and user_id=$user";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$take_time=$row[0];
	$sql="select interval_i from $table where mission_id=$id and mission_type='$type'";
	$r=mysql_query($sql);
	$row=mysql_fetch_array($r);
	$interval_i=$row[0];
	$a=strtotime($take_time)+$interval_i*60*60;
	$date=date("m/d/Y H:i:s",$a);
	echo "<input type='text' value='$date' id='time'  disabled='disabled'/>";

						}
				}
			}
			else if($um_state=='1'){//查用户任务状态
?>
<input type="button" value="打开红包11" onclick="mission_go(<?php echo "$user,$id,'$type','$um_state'"?>)"/>
<?php
			}

			
		}//查用户任务状态
		else if($row2[0]=='0'){
			$sql="select if((start_time-NOW())<0,'0','1') from $table where mission_type='$type' and mission_id=$id";
			$r=mysql_query($sql);
			$row=mysql_fetch_array($r);
			if($row[0]=='1')
				echo "<input type='button' value='即将开放0'/>";
			else
				echo "<input type='button' value='任务过期90'/>";
		}//查期限
	}//查余额
	
	
}//m_state=1


}

?>