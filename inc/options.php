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
MT:2019/5/27 */
require('functions.php');
session_start();
if(isset($_SESSION['name'])){
	if(isset($_POST['fopt'])){
		$fopt = $_POST["fopt"];
		$path ='';
			$files = '';
			$query = "select * from flinfo where fn='".$_POST['fname']."'";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
		if($fopt=="d"){
			//删除
			
			if($row['md5fn']==0){
				$path = 'src';
				$files = $_POST['fname'];				
			}
			else{
				$path = 'srcp';
				$files = $row['md5fn'];				
			}
			unlink(__ROOT__."/".$path."/".$files);
			mysql_query('delete from flinfo where fn="'.$_POST['fname'].'"');
			
			
	
		}
		else{
			//保存
			if($_POST['fname']!=$_POST['fnew']){
				$fnews = $_POST['fnew'];
				$fnews = str_replace(['/','\\',':','*','"','<','>','|','?','{','}'],'',$fnews);
				mysql_query("set names utf8");
				mysql_query("update flinfo set fn='".$fnews."' where fn='".$_POST['fname']."'");
				if($row['md5fn']==0){
				rename(iconv('UTF-8','GBK',"../src/".$_POST['fname']), iconv('UTF-8','GBK',"../src/".$fnews));
			}			


			}			
		}
	}
}
else{
	echo 'failed';
}
?>