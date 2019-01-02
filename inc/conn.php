<?php 
if (!session_id()) session_start();
date_default_timezone_set('Asia/Shanghai'); //set timezone
$con = mysqli_connect("127.0.0.1","db_user","db_password","dbname");//连接数据库服务器
if (!$con)
  {
  die('无法连接数据库: ' . mysql_error());
  }
 
mysqli_set_charset($con,'utf8');
		return $con;
		?>