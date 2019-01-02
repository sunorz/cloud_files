<?php
/*
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/17
Update:18/12/30
function index：
1) ls - 遍历文件夹文件，返回一个带索引首字母的二维数组。
2) getfirstchar - 根据文件名返回索引首字母。
3) fticon - 输入文件类型，输出聚合类型（".jpg"->"img"）,用作class值。
4) ftname - 输入聚合类型，输出易读的中文（"img"->"图像"）。
5) array_null - 输入数组，判断值是否空。
6) pub - 输入文件的code，输出对应的文件名。call initconfig.
7) getcode - 输入文件的sha1，输出code。
8) trans_byte - 将文件大小的字节转换为易读的大小。
9) initconfig - 数据库初始化。
10) pri - 私密文件下载。call readconfig.
11) readconfig - 读取数据库（私密）。
12) initconfigp - 初始化私密数据库。
*/
//字典初始化（用来处理php处理不了的中文）
//Read JSON custom pinyin dictionary
$json_string = file_get_contents('../assets/js/dict.json');
$data = json_decode($json_string,true);
//var_dump($data); 
/*1) 遍历文件夹文件，返回一个带索引的二维数组。*/
//Traverse local files in a custom folder
function ls($dir,$filter){
	initconfig();
	//如果src文件夹不存在，就创建。（可能会报Permission denied）
	//if(!is_dir($dir)){mkdir($dir);}
	$files = array();
	for ($x = ord('A'); $x <= ord('Z'); $x++){
  		$files[chr($x)]=array();//初始化26个数组
	}
	$files["#"]=array();//初始化"#"
	$suffix='';
	require("../inc/conn.php");
	$query="select shcd,fn from flinfo where md5fn='0'";
	global $data;

	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_row($result)){
			$temp=$row[1];
		foreach($data as $key=>$val){
			foreach($val as $val2){
				if(substr($row[1],0,3)==$val2){
							//把首个汉字替换为拼音，例如：钛->tai
							$temp=$key;
							break;
							}
			}
		}
							//筛选
					if($filter==null){
						array_push($files[getfirstchar($temp)],$row[1]);
					}
					else{
					$suffix=substr($row[1],strrpos($row[1],'.')+1);
					if($filter==fticon($suffix))array_push($files[getfirstchar($temp)],$row[1]);
					}
	}

					



if(count($files)>0){
if(array_null($files)){echo '<div class="bg-warning" style="padding:1em;margin-top:1em;">
<p class="text-center">没有'.ftname($filter).'。</p>
<p class="text-center"><small>Nothing.</small></p>
</div>';}
			foreach($files as $keys=>$vals){
				if(!array_null($files[$keys]))
				{
					echo '<h3>'.$keys.'</h3><ul>';
					foreach($files[$keys] as $vals2){
						if(file_exists("../src/".$vals2)){
						echo '<li><a href="../src/'.$vals2.'" target="_blank"><img class="ft-'.fticon(substr($vals2, strrpos($vals2, '.')+1)).'"/>'.

							$vals2.'</a>&nbsp;<a href="/s/'.getcode(sha1_file("../src/".$vals2),0).'" target="_blank"><i class="fa fa-chain"></i></a></li>';
						echo '</ul>';
					}
						else{
							//文件不存在，删除数据库中对应的内容
							$query_del="delete from flinfo where fn like '".$vals2."' and md5fn='0'";
							mysqli_query($con,$query_del);					
						}
	
					}
				}

			}
}


 	
	
}

/*2) 根据文件名返回索引首字母。*/
//Returns the first letter index based on the file name
function getfirstchar($s0){      
    $fchar = ord($s0{0});
    if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
    if(ord(substr($s0,0,1))>=48 && ord(substr($s0,0,1))<=57){
		//如果是数字开头
    	return "#";
	}  
if(ord(substr($s0,0,1))>=160)  {
$s=iconv("UTF-8","gb2312", $s0); //转码
$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if($asc < -20319 or $asc > -10247) return "#";//如果其他语言字符或者符号开头 
    if($asc >= -20319 and $asc <= -20284) return "A";
    if($asc >= -20283 and $asc <= -19776) return "B";
    if($asc >= -19775 and $asc <= -19219) return "C";
    if($asc >= -19218 and $asc <= -18711) return "D";
    if($asc >= -18710 and $asc <= -18527) return "E";
    if($asc >= -18526 and $asc <= -18240) return "F";
    if($asc >= -18239 and $asc <= -17923) return "G";
    if($asc >= -17922 and $asc <= -17418) return "H";
    if($asc >= -17922 and $asc <= -17418) return "I";
    if($asc >= -17417 and $asc <= -16475) return "J";
    if($asc >= -16474 and $asc <= -16213) return "K";
    if($asc >= -16212 and $asc <= -15641) return "L";
    if($asc >= -15640 and $asc <= -15166) return "M";
    if($asc >= -15165 and $asc <= -14923) return "N";
    if($asc >= -14922 and $asc <= -14915) return "O";


    if($asc >= -14914 and $asc <= -14631) return "P";
    if($asc >= -14630 and $asc <= -14150) return "Q";
    if($asc >= -14149 and $asc <= -14091) return "R";
    if($asc >= -14090 and $asc <= -13319) return "S";
    if($asc >= -13318 and $asc <= -12839) return "T";
    if($asc >= -12838 and $asc <= -12557) return "W";
    if($asc >= -12556 and $asc <= -11848) return "X";
    if($asc >= -11847 and $asc <= -11056) return "Y";
    if($asc >= -11055 and $asc <= -10247) return "Z";
}
    return NULL;

}

/*3) 输入文件类型，输出聚合类型（".jpg"->"img"）,用作class值。*/
function fticon($ft){
$ft=strtolower($ft);
if($ft=="jpg"||$ft=="gif"||$ft=="bmp"||$ft=="png"||$ft=="ico"||$ft=="svg")//图片
return "img";
if($ft=="mp4"||$ft=="avi"||$ft=="rmvb"||$ft=="mkv"||$ft=="mov"||$ft=="rm")//视频
return "video";
if($ft=="doc"||$ft=="docx"||$ft=="rtf")//doc
return "doc";
if($ft=="ppt"||$ft=="pptx")//ppt
return "ppt";
if($ft=="xls"||$ft=="xlsx")//xls
return "xls";
if($ft=="7z"||$ft=="tar"||$ft=="gz")//压缩包
return "zip";
//不存在
if(!file_exists("../assets/imgs/ft-".$ft.".svg")){return "unknown";}
return $ft;
}

/*4) 输入聚合类型，输出易读的中文（"img"->"图像"）。*/
function ftname($ft){
if($ft=="apk")return "apk文件";
if($ft=="zip")return "压缩文件";
if($ft=="img")return "图像";
if($ft=="video")return "视频";
if($ft=="doc")return "Word文档";
if($ft=="ppt")return "PowerPoint幻灯片";
if($ft=="xls")return "Excel文档";
if($ft=="pdf")return "pdf文档";
if($ft=="txt")return "纯文本文件";
return '后缀名未知的文件';

if($ft=="doc"||$ft=="docx"||$ft=="rtf")//doc
return "doc";
if($ft=="ppt"||$ft=="pptx")//ppt
return "ppt";
if($ft=="xls"||$ft=="xlsx")//xls
return "xls";
if($ft=="7z"||$ft=="tar"||$ft=="gz")//压缩包
return "zip";
//不存在
if(!file_exists("../assets/imgs/ft-".$ft.".svg")){return "unknown";}
return $ft;
}

/*5) 输入数组，判断值是否空。*/
function array_null($arr){
    if(is_array($arr)){
     foreach($arr as $k=>$v){
      if($v&&!is_array($v)){
        return false;
      }
       $t=array_null($v);
       if(!$t){
         return false;
       }
     }
     return true;
     }else{
       if(!$arr){
         return true;
       }
       return false;
     }
  }

/*6) 输入文件的code，输出对应的文件名。call initconfig.*/
//public
function pub($str){
	require("../inc/conn.php");	
	initconfig();
	$query_s="select * from flinfo where md5fn='0'";
	$result_s=mysqli_query($con,$query_s);
 while ($row = mysqli_fetch_row($result_s)) {
	$gstr=substr($row[0],0,2).substr($row[0],3,2).substr($row[0],6);
        if($gstr==$str&&file_exists("../src/".$row[2]))
{
$file=$row[2];

			$url='../src/'.$file;
			$ext=substr($file,strrpos($file,'.')+1);//后缀名
echo '<h1>'.$file.'</h1><center><img class="ftl-'.fticon($ext).'"/></center>';
echo '<p><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../src/'.$file).'</p>';
echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../src/'.$file)).'</p>';
echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../src/'.$file)).'</p>';
echo '<a href="'.$url.'" type="button" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Download</a>';
			return;
}

    }

}

/*7) 输入文件的sha1，输出code。*/
function getcode($str,$tag){
		$str2="";
		if(strlen($str)==40){
			for($i=10;$i<40;$i++)
			{
				if($i%5==0){//从第10位，间隔5位取数
					$str2.=substr($str,$i,1);
				}
			}
		}	
	if($tag==0){$a=array("g","h","i","j","k","l","m","n","o","p");}
	else{$a=array("q","r","s","t","u","v","w","x","y","z");}
	
		
		$keys=array_rand($a,1);
		$keys2=array_rand($a,1);
		$str2=substr($str2,0,2).$a[$keys].substr($str2,2,2).$a[$keys2].substr($str2,4);
	if(strlen($str2)==2)$str2="";
		return $str2;
	}

/*8) 将文件大小的字节转换为易读的大小。*/
function trans_byte($byte)
{

    $KB = 1024;

    $MB = 1024 * $KB;

    $GB = 1024 * $MB;

    $TB = 1024 * $GB;

    if ($byte < $KB) {

        return $byte . "B";

    } elseif ($byte < $MB) {

        return round($byte / $KB, 2) . "KB";

    } elseif ($byte < $GB) {

        return round($byte / $MB, 2) . "MB";

    } elseif ($byte < $TB) {

        return round($byte / $GB, 2) . "GB";

    } else {

        return round($byte / $TB, 2) . "TB";

    }

}

/*9) 数据库初始化。*/
function initconfig(){
require("../inc/conn.php");

if(@$handle = opendir("../src")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
 				if(!is_dir("../src/".$file)){
					//查询数据库
					$query_sel = "select fn from flinfo where md5fn='0'";
					$result_sel = mysqli_query($con,$query_sel);
					$flag=0;
					while($row_sel=mysqli_fetch_row($result_sel))
					{
						if($row_sel[0]==$file){
							mysqli_query($con,"update flinfo set shcd='".getcode(sha1_file("../src/".$file),0)."' where fn='".$file."'");
							$flag=1;
							break;
						}
					}
					if($flag==0)
					{
					$query='insert into flinfo values ("'.getcode(sha1_file("../src/".$file),0).'","0","'.$file.'")';

					mysqli_query($con,$query);
					}

				}
			}
		}
}

}

/*10) 私密文件下载。call readconfig.*/
//private
function pri($str){
	require("../inc/conn.php");
	initconfigp();
	$query_s="select * from flinfo where md5fn<>'0'";
	$result_s=mysqli_query($con,$query_s);
 while ($row = mysqli_fetch_row($result_s)) {
	$gstr=substr($row[0],0,2).substr($row[0],3,2).substr($row[0],6);
        if($gstr==$str&&file_exists("../srcp/".$row[1]))
{
$file=$row[1];

			$url='../srcp/'.$file;
			$ext=substr($file,strrpos($file,'.')+1);//后缀名
			
echo '<h1>'.$row[2].'</h1><center><img class="ftl-'.fticon($ext).'"/></center>';
echo '<p><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../srcp/'.$file).'</p>';
echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../srcp/'.$file)).'</p>';
echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../srcp/'.$file)).'</p>';
$key = 'key'; //秘钥 ，非常重要，不参与url传输、秘钥泄露将导致token验证失效
$data['pcode'] = $row[0];
$data['token']= md5( md5($key) . md5(date("Y-m-d-H",time())) );
echo '<a href="http://'.$_SERVER['HTTP_HOST'].'/inc/ll.php?'.http_build_query($data).'"  type="button" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Download</a>';
			return;
}

    }

}

/*11) readconfig - 读取数据库（私密）。*/
function readconfig(){
require("../inc/conn.php");
$query="select * from flinfo where md5fn<>'0'";
$result=mysqli_query($con,$query);
	if(mysqli_num_rows($result)>0){
		echo '<ul>';
	while($row=mysqli_fetch_row($result)){
		if(file_exists("../srcp/".$row[1])){
		echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/s/'.$row[0].'" target="_blank"><img class="ft-'.fticon(substr($row[1], strrpos($row[1], '.')+1)).'">'.$row[2].'</a>&nbsp;&nbsp;<a href="http://'.$_SERVER['HTTP_HOST'].'/s/'.$row[0].'" target="_blank"><i class="fa fa-chain"></i></a></li>';
		}
		else{
			$query_del="delete from flinfo where md5fn='".$row[1]."'";
			mysqli_query($con,$query_del);
		}
		
	}
		echo '</ul>';
	}
}
/*12) 初始化私密数据库。*/
function initconfigp(){	
require("../inc/conn.php");
//if(file_exists("../srcp/"))
//mkdir("../scrp");
if(@$handle = opendir("../srcp")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
 				if(!is_dir("../srcp/".$file)){
					$ext=substr($file,strrpos($file,"."));//后缀名带.
					$oldfile=$file;//旧的文件名
					$newfilename=substr(md5($file),0,8).$ext;
				//重命名 有问题
				if(strrpos($file,".tar.gz")==strlen($file)-7){
					//格式为tar.gz的要另外处理					
					if(date('H:i:s',time())=="00:00:00"||preg_match('/^[0-9a-z]{8}$/',substr($file,0,strrpos($file,".",-7)),$mc)==0)
					{					
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfilename));
						$file=$newfilename;
					}			
					
				}
				else
				{
					if(date('H:i:s',time())=="00:00:00"||preg_match('/^[0-9a-z]{8}$/',substr($file,0,strrpos($file,".")),$mc)==0)
					{					
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfilename));
						$file=$newfilename;
					}					
				}
				//End of 重命名	
					//查询数据库
					$query_sel = "select shcd,fn from flinfo where md5fn<>'0'";
					$result_sel = mysqli_query($con,$query_sel);
					$precode=getcode(sha1_file("../srcp/".$file),1);//8:12a45b78
					$precode2=substr($precode,0,7).substr(filectime("../srcp/".$file),-1);//8:12a45b7x
					$precode=substr($precode2,0,2).substr($precode2,3,2).substr($precode2,6);//6:12457x
						if(mysqli_num_rows($result_sel)>0){
					while($row_sel=mysqli_fetch_row($result_sel))
					{		
						$dbcode=substr($row_sel[0],0,2).substr($row_sel[0],3,2).substr($row_sel[0],6);
						if($dbcode==$precode){
							$strud="update flinfo set md5fn='".$file."' where shcd='".$precode2."'";
							if(preg_match('/^[0-9a-z]{8}$/',substr($oldfile,0,strrpos($oldfile,".",-7)),$mc)==0)
							{
							$strud="update flinfo set md5fn='".$file."',fn='".$oldfile."'  where shcd='".$precode2."'";
							}
							mysqli_query($con,$strud);
						}
						else
						{
							$query_i='insert into flinfo values ("'.$precode2.'","'.$file.'","'.$oldfile.'")';
							mysqli_query($con,$query_i);
						}
					}
						}
					else
					{
						$query_i='insert into flinfo values ("'.$precode2.'","'.$file.'","'.$oldfile.'")';
							mysqli_query($con,$query_i);
					}


				}
			}
		}
}



return true;
}
?>