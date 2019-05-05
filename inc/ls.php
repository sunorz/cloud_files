<?php
/*
Copyright by Sunplace
CT:2018/12/30
MT:2019/4/28
*/
if(isset($_POST['code'])&&$_POST['code']=="sunplace")
{
require("../inc/functions.php");
initconfigp();
readconfig();
}
else
{
	die("???");
}
?>