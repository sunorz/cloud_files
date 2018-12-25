<?php
/*
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/25
Update:18/12/25
*/
//首页ajax的目标文件
$seed = null;
require("functions.php");
if(isset($_POST["filter"]))
$seed = $_POST["filter"];
ls('../src',$seed);
?>