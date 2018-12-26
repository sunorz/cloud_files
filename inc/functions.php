<?php
/*
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/17
Update:18/12/26
function index：
1) ls - 遍历文件夹文件，返回一个带索引首字母的二维数组。
2) getfirstchar - 根据文件名返回索引首字母。
3) fticon - 输入文件类型，输出聚合类型（".jpg"->"img"）,用作class值。
4) ftname - 输入聚合类型，输出易读的中文（"img"->"图像"）。
5) array_null - 输入数组，判断值是否空。
6) pub - 输入文件的code，和配置文件config.txt的内的code比较，输出对应的文件名。call initconfig.
7) getcode - 输入文件的sha1，输出code。
8) trans_byte - 将文件大小的字节转换为易读的大小。
9) initconfig - 生成配置文件src/config.txt，该文件用来存储code和文件名。
10) pri - 生成配置文件src/config.txt，该文件用来存储code和文件名。call readconfig.
11) readconfig - 输入文件的sha1和配置文件inc/data.php的内的sha1比较，输出文件名。
*/
//字典初始化（用来处理php处理不了的中文）
//Read JSON custom pinyin dictionary
$json_string = file_get_contents('../assets/js/dict.json');
$data = json_decode($json_string,true);
//var_dump($data); 
/*1) 遍历文件夹文件，返回一个带索引的二维数组。*/
//Traverse local files in a custom folder
function ls($dir,$filter){
	//如果src文件夹不存在，就创建。（可能会报Permission denied）
	//if(!is_dir($dir)){mkdir($dir);}
	$files = array();
	for ($x = ord('A'); $x <= ord('Z'); $x++){
  		$files[chr($x)]=array();//初始化26个数组
	}
	$files["#"]=array();//初始化"#"
$suffix='';
	if(@$handle = opendir($dir)){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "." && $file!="config.txt"){ //排除根目录；
 				if(!is_dir($dir."/".$file)){
				//不然就将文件的名字存入数组
				//存入数组前先去查json
				//Check dictionary before saving it to the array
					global $data;
					$temp=$file;
					foreach($data as $key=>$val){
	  					foreach($val as $val2){
						//在utf-8中的汉字是3个字符
							if(substr($file,0,3)==$val2){
							//把首个汉字替换为拼音，例如：钛->tai
							$temp=$key;
							}
     					}
					}
					//筛选
					if($filter==null){
						array_push($files[getfirstchar($temp)],$file);
					}
					else{
					$suffix=substr($file,strrpos($file,'.')+1);
					if($filter==fticon($suffix))array_push($files[getfirstchar($temp)],$file);
					}

					
				}//end of else
 			} 

 		}//end of while
		if(count($files)>0){
if(array_null($files)){echo '<div class="bg-warning" style="padding:1em;margin-top:1em;">
<p class="text-center">没有'.ftname($filter).'。</p>
<p class="text-center"><small>Nothing.</small></p>
</div>';}
			foreach($files as $keys=>$vals){
				if(count($files[$keys])>0)
				{
					echo '<h3>'.$keys.'</h3><ul>';
					foreach($files[$keys] as $vals2){

						echo '<li><a href="../src/'.$vals2.'" target="_blank"><img class="ft-'.fticon(substr($vals2, strrpos($vals2, '.')+1)).'"/>'.

							$vals2.'</a>&nbsp;<a href="/s/'.getcode(sha1_file("../src/".$vals2),0).'" target="_blank"><i class="fa fa-chain"></i></a></li>';
						echo '</ul>';
	
					}
				}

			}
}


 		closedir($handle);
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

/*6) 输入文件的code，和配置文件src/config.txt的内的code比较，输出对应的文件名。*/
//public
function pub($str){
if(!file_exists("../src/config.txt"))
	initconfig();
$array=file("../src/config.txt");
	for($i=0;$i<count($array);$i++){
		$gstr=substr($array[$i],0,2).substr($array[$i],3,2).substr($array[$i],6,2);
		if($str==$gstr){
			$file=substr($array[$i],9);
			$file=substr($file,0,strlen($file)-3);//去掉分号,t,n
			$url='../src/'.$file;
			$ext=substr($file,strrpos($file,'.')+1);//后缀名
echo '<h1>'.$file.'</h1><center><img class="ftl-'.fticon($ext).'"/></center>';
echo '<p><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../src/'.$file).'</p>';
echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../src/'.$file)).'</p>';
echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../src/'.$file)).'</p>';
echo '<a href="'.$url.'" type="button" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Download</a>';
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

/*9) 生成配置文件src/config.txt，该文件用来存储code和文件名。*/
function initconfig(){	
$config="";
if(@$handle = opendir("../src")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
 				if(!is_dir("../src/".$file)){
					$config.=getcode(sha1_file("../src/".$file),0).",".$file.";\r\n";
				}
			}
		}
}
$myfile = fopen("../src/config.txt", "w") or die("Unable to open file!");
fwrite($myfile,$config);
fclose($myfile);
}

/*10) 输入文件的code，和配置文件inc/data.php的内的code比较，输出对应信息。*/
//private
function pri($str){
if(@$handle = opendir("../srcp")){
	//注意这里要加一个@，不然会有warning错误提示:)
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
				//重命名
				if(strrpos($file,".tar.gz")==strlen($file)-7){
					//格式为tar.gz的要另外处理
					$newfilename=substr(md5($file),0,8).".tar.gz";
					if(date('H:i:s',time())=="00:00:00"||preg_match('/^[0-9a-f]{8}$/',substr($file,0,strrpos($file,".",-7)),$mc)==0)
					{					
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfilename));
						$file=$newfilename;
					}			
					
				}
				else
				{
					$ext=substr($file,strrpos($file,"."));//后缀名带.
					$newfilename=substr(md5($file),0,8).$ext;
					if(date('H:i:s',time())=="00:00:00"||preg_match('/^[0-9a-f]{8}$/',substr($file,0,strrpos($file,".")),$mc)==0)
					{					
						rename(iconv('UTF-8','GBK',"../srcp/".$file), iconv('UTF-8','GBK',"../srcp/".$newfilename));
						$file=$newfilename;
					}					
				}
				//End of 重命名				
				$bstr=getcode(sha1_file("../srcp/".$file),1);
				$bstr=substr($bstr,0,2).substr($bstr,3,2).substr($bstr,6);
				if($str==$bstr)
				{
					//var_dump($mc);
					echo '<h1>';
					if(readconfig(sha1_file("../srcp/".$file))==-1){
						echo $file;
					}
					else
					{
						echo readconfig(sha1_file("../srcp/".$file));
					}
				
					echo '</h1><center><img class="ftl-'.fticon(substr($file,strrpos($file,".")+1)).'"/></center>';
					echo '<p><strong>SHA1</strong>&nbsp;&nbsp;'.sha1_file('../srcp/'.$file).'</p>';
					echo '<p><strong>size</strong>&nbsp;&nbsp;'.trans_byte(filesize('../srcp/'.$file)).'</p>';
					echo '<p><strong>最后修改时间：</strong>&nbsp;&nbsp;'.date('Y-m-d H:i:s',filemtime('../srcp/'.$file)).'</p>';
					echo '<a href="../srcp/'.$file.'" type="button" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Download</a>';
				}
			}
		}
}

}

/*11) 输入文件的sha1和配置文件inc/data.php的内的sha1比较，输出文件名。*/
function readconfig($sha1){
	$config = file("../inc/data.php");
	for($i=2;$i<count($config)-2;$i++)
	{
		$val = strtolower($config[$i]);
		if($sha1==substr($val,0,40)){
			return substr($val,strpos($val,",")+1);//文件名
		}
	}
	return -1;
}
?>