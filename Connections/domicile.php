<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_domicile = "localhost";
$database_domicile = "domicile";
$username_domicile = "root";
$password_domicile = "apple";
$domicile = mysql_pconnect($hostname_domicile, $username_domicile, $password_domicile) or trigger_error(mysql_error(),E_USER_ERROR); 
?>