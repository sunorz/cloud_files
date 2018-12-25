<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DOWNLOAD</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fa/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/main.css">
<script src="../assets/js/jquery-3.1.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</head>
<body>
<!--
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/22
Update:18/12/25
-->
<div class="container">
<?php
require("../inc/functions.php");
if(!isset($_GET['fid']))exit("没有这个文件。");
$a=array("g","h","i","j","k","l","m","n","o","p");
$b=array("q","r","s","t","u","v","w","x","y","z");
if($_GET['fid']){
	if(preg_match("/[0-9a-zA-Z]/",$_GET['fid'])){
	$gstr=strtolower($_GET['fid']);
	if(in_array(substr($gstr,2,1),$a)&&in_array(substr($gstr,5,1),$a)){
		$str=substr($gstr,0,2).substr($gstr,3,2).substr($gstr,6);
		pub($str);
	}
	else if(in_array(substr($gstr,2,1),$b)&&in_array(substr($gstr,5,1),$b)){
		$str=substr($gstr,0,2).substr($gstr,3,2).substr($gstr,6);
		pri($str);
	}
	else{
		echo "没有这个文件。";
	}
	}
	else{
   	 echo "没有这个文件。";
	}
}

//private
function pri($str){echo 'pri';}
?>
</div>
<script>
$(function(){
	var str=$("img").attr("class");
	$("img").attr('src','../assets/imgs/ft-'+str.substring(str.lastIndexOf("-")+1)+'.svg');
$("button").click(function(){

});

});</script>
</body>
</html>