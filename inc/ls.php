<?php
/*
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/17
Update:18/12/26
*/
require_once("functions.php");
if(isset($_POST["sha1"])&&$_POST["sha1"]!=""){
	$str = getcode($_POST["sha1"],1);
	if($str!="")
	{
	echo '<center><code>https://'.$_SERVER['HTTP_HOST'].'/s/'.$str.'</code>';
	echo '&nbsp;<a href="/s/'.$str.'" target="_blank"><i class="fa fa-chain"></i></a></center>';
	}
}?>