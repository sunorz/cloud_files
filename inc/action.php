<?php
/*
Copyright by Sunplace
CT:2019/1/11
MT:2019/4/24
*/
session_start();
if(isset($_POST['username'])&&isset($_POST['password'])){
	require("functions.php");
	if(ck($_POST['username'],md5($_POST['password'].'CONFUSED_STRING'))){
	$_SESSION['name']=$_POST['username'];
	$_SESSION['password']=$_POST['password'];
		echo 'success';
	}
else
{ 
echo 'failed';	
}

}
else
{
if((isset($_SESSION['name'])||isset($_SESSION['password']))&&$_POST['action']=='logout'){
	$_SESSION = array();
	session_destroy();
	echo "success";
}
	else
	{
		echo 'failed';
	}

	
}
?>