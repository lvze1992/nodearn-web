<?php
$db_host="localhost";     //��������
$db_user="root";         //�û���
$db_pass="";        //����
$db_name="zdq";        //���ݿ���
$link=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
mysql_select_db($db_name,$link);
mysql_query("SET NAMES UTF8");

?>