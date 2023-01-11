<?php 
/*
Copyright by Sunplace
CT:2018/12/27
MT:2019/4/28
*/
if($_SERVER['PHP_SELF']=='/inc/conn.php'){

header('Location: /404.html');

}
if (!session_id()) session_start();
date_default_timezone_set('Asia/Shanghai'); //set timezone
$con = mysqli_connect("host","user","password","database");//连接数据库服务器
if (!$con)
  {
  die('无法连接数据库: ' . mysql_error());
  }
 
mysqli_set_charset($con,'utf8');
		return $con;
		?>