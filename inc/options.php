<?php
/* 用来接收文件操作命令
参数：
fname - 文件名（实际）
fnew - 新文件名[null - 删除操作时，此值为null]
fopt - 文件操作[s - 保存 ,d - 删除]
例如：
{fname:"file.zip",fnew:"newfile.zip",fopt:"s"} - 更新file.zip为newfile.zip
{fname:"file.zip",fopt:"d"} - 删除file.zip
Copyright by Sunplace
CT:2019/5/23
MT:2019/6/6
*/
require('conn.php');
session_start();
if(isset($_SESSION['name'])){
if(isset($_POST['fopt'])){
	$opt = $_POST['fopt'];
		switch($opt){
			case "d": 
			if(isset($_POST['fname'])){
				$fn = $_POST['fname'];
				if(is_array($fn)){
						foreach($fn as $value){ 
							unlink("../src/".$value);
						} 
					}
				else{
					unlink("../src/".$fn);
				}
				}		
			break;
			case "s": 
			mysqli_query($con,"set names utf8");
		$query = "update flinfo set fn = '".$_POST['fnew']."' where fn like '".$_POST['fname']."'";
		rename(iconv('UTF-8','GBK',"../src/".$_POST['fname']), iconv('UTF-8','GBK',"../src/".$_POST['fnew']));
		mysqli_query($con,$query);
			break;
		default:break;
			}
	}
}
else{
	echo 'failed';
}
?>