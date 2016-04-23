<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$type=$_GET['type'];
$id=$_GET['id'];
require('../../mysql_connect.php');
$sql="select from_table from mission_type where mission_type='$type'";
if($result=mysql_query($sql)){
$row=mysql_fetch_array($result);
$table=$row[0];
$sql="select * from admin_mission as am inner join $table using(mission_id) where am.mission_id=$id and am.mission_type=$type";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
//print_r($row);
}
?>


<input name="mission_id" type="hidden" value="<?php echo $row[0];?>"/>
任务标题：<input name="title" type="text" value="<?php echo $row[1];?>"/><br/>
任务介绍：<textarea  name="intro" ><?php echo $row[2];?></textarea><br/>
是否可重复领取：
否：<input type="radio" name="repeat_c" value="0" checked="checked">
是:<input type="radio" name="repeat_c" value="1" <?php if($row[9]==1) echo "checked='checked'";?>><br/>
重复领取间隔时间（时）：<input name="interval_i" type="text"  value="<?php echo $row[10];?>"/><br/>
任务发布时间：<input name="start_time" type="text"  value="<?php echo $row[11]; ?>" id="example_1" readonly="readonly"/><br/>
任务结束时间：<input name="end_time" type="text"  value="<?php echo $row[12]; ?>"  id="example_2" readonly="readonly"/><br/>
完成任务收益（元）：<input name="profit" type="text"  value="<?php echo $row[13];?>"/><br/>
投入总金额（元）：<input name="total_profit" type="text"  value="<?php echo $row[14];?>"/><br/>
剩余金额（元）：<input name="profit_rest" type="text"  value="<?php echo $row[15];?>"/><br/>
任务初始状态：不发布：<input type="radio" name="state" value="0" checked="checked">
直接发布：<input type="radio" name="state" value="1"  <?php if($row[16]==1) echo "checked='checked'";?>><br/>

任务权重（同级任务排序）：<input name="order_v" type="text"  value="<?php echo $row[6];?>"/><br/>
<input value="修改" name="revise" type="submit"/><input value="返回任务添加" name="return" onclick="Return()" type="button"/>
<?php 
echo "<a href='javascript:AddResource($type,$id)' title='添加资源'><img src='icon/add.png'/></a>";
echo "&nbsp;";
echo "<a href='javascript:PreviewPage($type,$id)' title='任务页面预览'><img src='icon/eye.png'/></a>";
?>