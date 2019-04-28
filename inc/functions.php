<?php
/*
Copyright by Sunplace
CT:2018/12/17
MT:2019/4/28
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
12) initconfigp - 初始化数据库（私密）。
13) ck - 用户认证。
14) is_empty_dir - 文件夹判空。
15）init_dir - 如果文件夹有修改，则返回1。
*/
if($_SERVER['PHP_SELF']=='/inc/functions.php'){

header('Location: /404.html');

}
define('__ROOT__', substr(dirname(__FILE__), 0, -4));
//字典初始化（用来处理php处理不了的中文）
//Read JSON custom pinyin dictionary
$json_string = file_get_contents(__ROOT__.'/assets/js/dict.json');
$data = json_decode($json_string,true);
//var_dump($data); 
/*1) 遍历文件夹文件，返回一个带索引的二维数组。*/
//Traverse local files in a custom folder
function ls($dir,$filter){
	if(init_dir()==1){initconfig();}
	//如果src文件夹不存在，就创建。（可能会报Permission denied）
	//if(!is_dir($dir)){mkdir($dir);}
	$files = array();
	for ($x = ord('A'); $x <= ord('Z'); $x++){
  		$files[chr($x)]=array();//初始化26个数组
	}
	$files["#"]=array();//初始化"#"
	$suffix='';
	require(__ROOT__."/inc/conn.php");
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
						if(isset($files[getfirstchar($temp)]))
						array_push($files[getfirstchar($temp)],$row[1]);
					}
					else{
					$suffix=substr($row[1],strrpos($row[1],'.')+1);
					if($filter==fticon($suffix))array_push($files[getfirstchar($temp)],$row[1]);
					}
	}

					



if(count($files)>0){
if(array_null($files)){echo '<div class="red-text" style="padding:1em;margin-top:1em;">
<p class="text-center">没有'.ftname($filter).'。</p>
<p class="text-center"><small>Nothing.</small></p>
</div>';}

			foreach($files as $keys=>$vals){
				if(!array_null($files[$keys]))
				{
					echo '<ul class="collection with-header"><li class="collection-header"><a class="btn-floating btn waves-effect waves-light blue lighten-3">'.$keys.'</a></li>';
					foreach($files[$keys] as $vals2){
						if(file_exists(__ROOT__."/src/".$vals2)){
						echo '<li class="collection-item"><a href="/src/'.$vals2.'" download="'.$vals2.'" class="truncate"><img class="ft-'.fticon(substr($vals2, strrpos($vals2, '.')+1)).'"/>'.$vals2.'</a><a href="/s/'.getcode(sha1_file(__ROOT__."/src/".$vals2),0).'" target="_blank" class="secondary-content"><i class="material-icons open" title="前往文件明细">open_in_new</i></a></li>';

					}
						else{
							//文件不存在，删除数据库中对应的内容
							$query_del="delete from flinfo where fn like '".$vals2."' and md5fn='0'";
							mysqli_query($con,$query_del);					
						}
												
	
					}
					echo '</ul>';
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
if(!file_exists(__ROOT__."/assets/imgs/ft-".$ft.".svg")){return "unknown";}
return $ft;
}

/*4) 输入聚合类型，输出易读的中文（"img"->"图像"）。*/
function ftname($ft){
	if($ft==null&&$ft==''){
		return '任何公开的文件';
	};
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

/*6) 输入文件的code，和配置文件src/config.txt的内的code比较，输出对应的文件名。*/
//public
function pub($str){
	require("../inc/conn.php");	
	if(init_dir()==1){initconfig();}
	$query_s="select * from flinfo where md5fn='0'";
	$result_s=mysqli_query($con,$query_s);
 while ($row = mysqli_fetch_row($result_s)) {
	$gstr=substr($row[0],0,2).substr($row[0],3,2).substr($row[0],6);
        if($gstr==$str&&file_exists("../src/".$row[2]))
{
$file=$row[2];

			$url='../src/'.$file;
			$ext=substr($file,strrpos($file,'.')+1);//后缀名
echo '<div class="row z-depth-2" style="padding: 1em;margin: 2em 0;"><div class="col s12"><h4 style="word-break: break-all;">'.$file.'</h4><center><img class="ftl-'.fticon($ext).'"/></center>';
echo '<p style="word-break: break-all;"><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../src/'.$file).'</p>';
echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../src/'.$file)).'</p>';
echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../src/'.$file)).'</p>';
echo '<center><a href="'.$url.'" type="button" class="waves-effect waves-light btn blue" download="'.$file.'"><i class="material-icons left">file_download</i>&nbsp;Download</a></center></div></div>';
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
				if(($i+1)%5==0){//从第10位，间隔5位取数
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
	set_time_limit(0);
	$fa = array();
	if(@$handle = opendir(__ROOT__."/src")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
				
				//$str=getcode(sha1_file(__ROOT__.'/src/'.$file),0);
				//$fa[substr($str,0,2).substr($str,3,2).substr($str,6)]=$file;//sha1：6位
				array_push($fa,$file);
					
			}
		}
	}
	//echo "<pre>fa=";print_r($fa);echo "<pre>";
require(__ROOT__."/inc/conn.php");
$query_sel ="select shcd,fn from flinfo where md5fn='0'";
$result_sel = mysqli_query($con,$query_sel);
$fb=array();
while($row= mysqli_fetch_row($result_sel)){
	//$fb[substr($row[0],0,2).substr($row[0],3,2).substr($row[0],6)]=$row[1];
	if (in_array($row[1], $fa))
	{
		array_push($fb,$row[1]);
		//update
	}
	else
	{
		mysqli_query($con,"delete from flinfo where fn='".$row[1]."'");
		//delete
	}		
}
$gti=array_diff($fa,$fb);
	foreach($gti as $gk=>$gv)
	{
		$query_ins="insert into flinfo values ('".getcode(sha1_file(__ROOT__."/src/".$gv),0)."','0','".$gv."')";
		mysqli_query($con,$query_ins);
	}
	//echo "<pre>fb=";print_r($fb);echo "<pre>";
	//echo "<pre>fa-fb=";print_r(array_diff($fa,$fb));echo "<pre>";
	
		}




/*10) 输入文件的code，查询数据库，输出对应信息。*/
//private
function pri($str){
	require("../inc/conn.php");
	if(init_dir()==1){initconfigp();}
	$query_s="select * from flinfo where md5fn<>'0'";
	$result_s=mysqli_query($con,$query_s);
 while ($row = mysqli_fetch_row($result_s)) {
	$gstr=substr($row[0],0,2).substr($row[0],3,2).substr($row[0],6);
        if($gstr==$str&&file_exists("../srcp/".$row[1]))
{
$file=$row[1];

			$url='../srcp/'.$file;
			$ext=substr($file,strrpos($file,'.')+1);//后缀名
			
echo '<div class="row z-depth-2" style="padding: 1em;margin: 2em 0;"><div class="col s12"><h4 style="word-break: break-all;">'.$row[2].'</h4><center><img class="ftl-'.fticon($ext).'"/></center>';
echo '<p style="word-break: break-all;"><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../srcp/'.$file).'</p>';
echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../srcp/'.$file)).'</p>';
echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../srcp/'.$file)).'</p>';
$key = 'CONFUSED_STRING'; //秘钥 ，非常重要，不参与url传输、秘钥泄露将导致token验证失效
$data['pcode'] = $row[0];
$data['token']= md5( md5($key) . md5(date("Y-m-d-H",time())) );
echo '<center><a href="//'.$_SERVER['HTTP_HOST'].'/inc/ll.php?'.http_build_query($data).'"  type="button" class="waves-effect waves-light btn blue"><i class="material-icons left">file_download</i>Download</a></center></div>';
			return;
}

    }

}

/*11) 读取数据库，输出文件名。*/
function readconfig(){
require("../inc/conn.php");
$query="select * from flinfo where md5fn<>'0'";
$result=mysqli_query($con,$query);
	if(!is_empty_dir("../srcp")&&mysqli_num_rows($result)>0){
		echo '<ul class="collection with-header"><li class="collection-header"><a class="btn-floating btn waves-effect waves-light red lighten-3"><i class="material-icons">lock</i></a></li>';
	while($row=mysqli_fetch_row($result)){
		if(file_exists("../srcp/".$row[1])){
		echo '<li class="collection-item"><a href="//'.$_SERVER['HTTP_HOST'].'/s/'.$row[0].'" class="truncate"><img class="ft-'.fticon(substr($row[1], strrpos($row[1], '.')+1)).'">'.$row[2].'</a><a href="//'.$_SERVER['HTTP_HOST'].'/s/'.$row[0].'" target="_blank" class="secondary-content"><i class="material-icons open" title="前往文件明细">open_in_new</i></a></li>';
		}
		else{
			$query_del="delete from flinfo where md5fn='".$row[1]."'";
			mysqli_query($con,$query_del);
		}
		
	}
		echo '</ul>';
	}
	else{
		echo '<div class="red-text" style="padding:1em;margin-top:1em;">
<p class="text-center">没有文件。</p>
<p class="text-center"><small>Nothing.</small></p>
</div>';
	}
}
/*12) 初始化数据库（私密）。*/
function initconfigp(){	
require("../inc/conn.php");
//if(file_exists("../srcp/"))
//mkdir("../srcp");
if(@$handle = opendir("../srcp")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
 				if(!is_dir("../srcp/".$file)){					
				//重命名
				if(strrpos($file,".tar.gz")==strlen($file)-7){
					$fdname=substr($file,0,strlen($file)-7);
					$ext='.tar.gz';//后缀名带.				
				}
				else
				{					
					$ext=substr($file,strrpos($file,"."));//后缀名带.
					$fdname=substr($file,0,0-strlen($ext));
				}
					$oldfile=$file;//旧的文件名
					$newfile=substr(md5($file),0,8).$ext;
					$select1="select md5fn,fn from flinfo where md5fn<>0";
					$result1=mysqli_query($con,$select1);
					while($rows1=mysqli_fetch_row($result1)){
						if($rows1[1]==$file){
						/*
						如果$file在fn字段
						rname
						update md5fn
						*/
						$update="update flinfo set md5fn='".$newfile."' where fn like binary '".$oldfile."'";
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfile));
						mysqli_query($con,$update);
						}	
						}
						/*
					    如果$file不在以上字段
						rname
						insert
					    */
						$select2="select md5fn,fn from flinfo where md5fn='".$oldfile."' or fn like binary '".$oldfile."'";
						$result2=mysqli_query($con,$select2);
						if(mysqli_num_rows($result2)==0){	
						$insert="insert into flinfo (shcd,md5fn,fn) values ('".getcode(sha1_file('../srcp/'.$file),1)."','".$newfile."','".$oldfile."')";
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfile));
						mysqli_query($con,$insert);
					}			
				}
			}
		}
}



return true;
}
/*13) 用户认证。*/
function ck($n,$p){
	require(__ROOT__."/inc/conn.php");
	$q="select coln from user where coln='".$n."' and colp='".$p."'";
	if(mysqli_num_rows(mysqli_query($con,$q))>0){
	
		return true;
	}
	else{
	return false;
	}
	
}
/*14) 文件夹判空*/
function is_empty_dir($fp)
{
    if (!is_dir($fp)) {
        return false;
    }
    $H = @opendir($fp);
    while($file = readdir($H)){
        if(!($file == "." || $file == "..")){
            return false;
        }
    }
    return true;
}

/*15) 如果文件夹有修改，则返回1。*/
function init_dir(){
$flag=0;
date_default_timezone_set('PRC');
$json_string = file_get_contents(__ROOT__.'/assets/js/dirmtime.json');
$data = json_decode($json_string,true);
foreach($data as $key=>$val){
			if($val==0){
			$data[$key]=filemtime("../".$key);
			$json_string = json_encode($data);
            file_put_contents(__ROOT__.'/assets/js/dirmtime.json',$json_string);//写入

			}
			else{
				if($val!=filemtime("../".$key))
				{
			$data[$key]=filemtime("../".$key);
			$json_string = json_encode($data);
            file_put_contents(__ROOT__.'/assets/js/dirmtime.json',$json_string);//写入
			$flag=1;
				}
			}

}
return $flag;
}
?>