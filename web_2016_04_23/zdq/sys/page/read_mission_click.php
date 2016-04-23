<?php
$user_id=$_GET['user_id'];
$id=$_GET['mission_id'];
$type='15';
$table='client_mission_read';
$article_url_id=$_GET['article_url_id'];
if($user_id==""){
	$url_jump="";
}
else{
/****************************用户app内点击***************************/
	if($article_url_id==""){
		require('../../../mysql_connect.php');
		$check_mission=checkMission($id,$type,$table);
		if($check_mission!='1'){	
			$url_jump="";
		}
		else if($check_mission=='1'){	
			$sql="select n,r_n,user_mission_id from user_mission where user_id=$user_id and mission_id=$id and mission_type='$type'";
			$r1=mysql_query($sql);
			if(@mysql_num_rows($r1)==0){	
					mysql_query("START TRANSACTION");
					$sql="insert into user_mission(user_id,mission_id,mission_type,take_time,state,n) values($user_id,$id,'$type',NOW(),'2',1)";
					if(mysql_query($sql)){
					$sql="update $table set profit_rest=profit_rest-profit,join_n=join_n+1 where mission_type='$type' and mission_id=$id limit 1";
						if(mysql_query($sql)){
							$sql="select profit,article_url from $table where mission_type='$type' and mission_id=$id limit 1";
							$r=mysql_query($sql);
							$row=mysql_fetch_array($r);
							$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values(last_insert_id(),$user_id,'$row[0]',NOW())";
							if(mysql_query($sql)){
								//echo $url_jump."555";

							mysql_query("COMMIT");
							$url_jump=$row[1];
							}
						}
					}

			}
			else{	
					mysql_query("START TRANSACTION");
					$sql="update user_mission set n=n+1,hand_time=NOW() where user_id=$user_id and mission_id=$id and mission_type='$type'";
					if(mysql_query($sql)){
							$sql="select profit,profit_limit,article_url,r_profit from $table where mission_type='$type' and mission_id=$id limit 1;";
							$r=mysql_query($sql);
							$row=mysql_fetch_array($r);
							$row1=mysql_fetch_array($r1);
							$profit=$row[0];
							$r_profit=$row[3];
							$profit_limit=$row[1];
							$n=$row1[0]+1;
							$r_n=$row1[1];
							if(($n*$profit+$r_n*$r_profit)<=$profit_limit){
								$sql="update $table set profit_rest=profit_rest-profit,join_n=join_n+1 where mission_type='$type' and mission_id=$id limit 1";
									if(mysql_query($sql)){
										$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values($row1[2],$user_id,'$row[0]',NOW())";
										if(mysql_query($sql)){
											//echo $url_jump."333";

										mysql_query("COMMIT");
										$url_jump=$row[2];

										}
									}
							}
							else{	
									  $sql="update $table set join_n=join_n+1 where mission_type='$type' and mission_id=$id limit 1";
											  if(mysql_query($sql)){
												 // echo $url_jump."222";

											  mysql_query("COMMIT");
											  $url_jump=$row[2];

											  }
							
							}//if($n*$profit<=$profit_limit)
					}

				
			}//if(@mysql_num_rows($r)==0)
		}//if($check_mission==true)
		

	}//if($id!="")
	else if($article_url_id!=""){
		require('../../../mysql_connect.php');
		$check_mission=checkMission($id,$type,$table);
		if($check_mission!='1'){	
			$url_jump="";
		}
		else if($check_mission=='1'){	
			$sql="select n,r_n,user_mission_id from user_mission where user_id=$user_id and mission_id=$id and mission_type='$type'";
			echo "1";
			$r1=mysql_query($sql);
			if(@mysql_num_rows($r1)==0){	
					mysql_query("START TRANSACTION");
					echo "2";
					$sql="insert into user_mission(user_id,mission_id,mission_type,take_time,state,r_n) values($user_id,$id,'$type',NOW(),'2',1)";
					if(mysql_query($sql)){
						echo "3";
					$sql="update $table set profit_rest=profit_rest-r_profit,r_join_n=r_join_n+1 where mission_type='$type' and mission_id=$id limit 1";
						if(mysql_query($sql)){
							echo "4";
							$sql="select r_profit,article_url from $table where article_url_id=$article_url_id limit 1";
							$r=mysql_query($sql);
							$row=mysql_fetch_array($r);
							$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values(last_insert_id(),$user_id,'$row[0]',NOW())";
							if(mysql_query($sql)){
								//echo $url_jump."555";
							echo "5";
							mysql_query("COMMIT");
							$url_jump=$row[1];
							}
						}
					}

			}
			else{	
			echo "6";
					mysql_query("START TRANSACTION");
					$sql="update user_mission set r_n=r_n+1 where user_id=$user_id and mission_id=$id and mission_type='$type'";
					if(mysql_query($sql)){
							$sql="select profit,profit_limit,article_url,r_profit from $table where article_url_id=$article_url_id limit 1;";
							$r=mysql_query($sql);
							$row=mysql_fetch_array($r);
							$row1=mysql_fetch_array($r1);
							$profit=$row[0];
							$r_profit=$row[3];
							$profit_limit=$row[1];
							$n=$row1[0];
							$r_n=$row1[1]+1;
							if(($n*$profit+$r_n*$r_profit)<=$profit_limit){
								$sql="update $table set profit_rest=profit_rest-r_profit,r_join_n=r_join_n+1 where article_url_id=$article_url_id limit 1";
									if(mysql_query($sql)){
										$sql="insert into user_earning(user_mission_id,user_id,profit,update_time) values($row1[2],$user_id,'$row[3]',NOW())";
										if(mysql_query($sql)){
											//echo $url_jump."333";

										mysql_query("COMMIT");
										$url_jump=$row[2];

										}
									}
							}
							else{	
									  $sql="update $table set r_join_n=r_join_n+1 where article_url_id=$article_url_id limit 1";
											  if(mysql_query($sql)){
												 // echo $url_jump."222";

											  mysql_query("COMMIT");
											  $url_jump=$row[2];

											  }
							
							}//if($n*$profit<=$profit_limit)
					}

				
			}//if(@mysql_num_rows($r)==0)
		}//if($check_mission==true)
		
	}
/****************************END-用户app内点击***************************/
}
//echo $url_jump."111";
if($url_jump!=""){
echo "<script language='javascript' type='text/javascript'>";  
echo "window.location.href='$url_jump'";  
echo "</script>";
exit;	

}
else{	
echo "<script language='javascript' type='text/javascript'>";  
echo "window.location.href='includes/default.html?error=05x'";  
echo "</script>";
exit;	
}


/*******************function checkMission($id,$type,$table)********************/
function checkMission($id,$type,$table){	
$sql="select state,profit_rest,profit from $table where mission_type='$type' and mission_id=$id";
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
	}//查余额
	else{
	  return "1";
	}
	
}//m_state=1

}
/*******************END-function checkMission($id,$type,$table)********************/

?>