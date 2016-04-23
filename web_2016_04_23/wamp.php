<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_wamp = "localhost";
$database_wamp = "zdq";
$username_wamp = "root";
$password_wamp = "";
$wamp = mysql_pconnect($hostname_wamp, $username_wamp, $password_wamp) or trigger_error(mysql_error(),E_USER_ERROR); 
?>