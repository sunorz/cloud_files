<?php
/*
Copyright by Sunplace
CT:2018/12/30
MT:2019/4/28
*/
if($_SERVER['PHP_SELF']=='/inc/ls.php'){

header('Location: /404.html');

}
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