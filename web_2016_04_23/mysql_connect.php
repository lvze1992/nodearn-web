<?php
$db_host="localhost";     //服务器名
$db_user="root";         //用户名
$db_pass="";        //密码
$db_name="zdq";        //数据库名
$link=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
mysql_select_db($db_name,$link);
mysql_query("SET NAMES UTF8");

?>