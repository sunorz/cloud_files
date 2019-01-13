<?php
/*
Copyright by Sunplace
CT:2018/12/25
MT:2018/12/30
*/
if(isset($_GET["pcode"])&&isset($_GET["token"])){
	//SQL防止注入
	if(preg_match('/^[0-9a-z]{8}$/',$_GET["pcode"],$mc)==0)die("???");
	//下载私密文件
	$key = 'AJJkendie0772'; //秘钥 ，非常重要，不参与url传输、秘钥泄露将导致token验证失效
	$data['pcode'] = $_GET["pcode"];
	$data['token']= md5( md5($key) . md5(date("Y-m-d-H",time())) );
	if($data['token']==$_GET["token"]){
		require("../inc/conn.php");
		$query="select * from flinfo where shcd='".$data['pcode']."' and md5fn<>'0'";
		$result=mysqli_query($con,$query);
		if(mysqli_num_rows($result)>0){	
			while($row=mysqli_fetch_row($result)){

				if(file_exists("../srcp/".$row[1])){
				header('Accept-Ranges: bytes');
				header('Accept-Length: '.filesize("../srcp/".$row[1]));
				header('Content-Transfer-Encoding: binary');
				header('Content-type: application/octet-stream');
				header('Content-Disposition: attachment; filename=' . $row[2]);
				header('Content-Type: application/octet-stream; name=' . $row[2]);
				if(is_file("../srcp/".$row[1]) && is_readable("../srcp/".$row[1])){
				$file = fopen("../srcp/".$row[1], "r");
				echo fread($file, filesize("../srcp/".$row[1]));
				fclose($file);

				}
				}
				else{
				$query_del="delete from flinfo where md5fn='".$row[1]."'";
				mysqli_query($con,$query_del);
				echo "文件不存在。";
				}
			}

		}
	}
	else{echo "文件不存在。";}
	}
else{
	//首页ajax的目标文件
	$seed = null;
	//SQL防止注入
	if($_POST["filter"]!=null&&preg_match('/^[0-9a-z]{1,8}$/',$_POST["filter"],$mc)==0)die("非法操作~");
	require("../inc/functions.php");
	if(isset($_POST["filter"]))
	$seed = $_POST["filter"];
	ls('../src',$seed);
}
?>