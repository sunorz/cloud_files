<?php
/*
Code by Sunplace
Website:https://jsunplace.com
Date:18/12/17
Update:18/12/20
*/
//字典初始化（用来处理php处理不了的中文）
//Read JSON custom pinyin dictionary
$json_string = file_get_contents('../assets/js/dict.json');
$data = json_decode($json_string,true);
$seed = $_POST["filter"];
//var_dump($data); 
//遍历本地文件
//Traverse local files in a custom folder
function ls($dir,$filter){

	$files = array();
	for ($x = ord('A'); $x <= ord('Z'); $x++){
  		$files[chr($x)]=array();//初始化26个数组
	}
	$files["#"]=array();//初始化"#"
$suffix='';
	if(@$handle = opendir($dir)){
	//注意这里要加一个@，不然会有warning错误提示：）
 		while(($file = readdir($handle)) !== false){
 			if($file != ".." && $file != "."){ //排除根目录；
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
<p class="text-center">目前没有<code>'.$filter.'</code>文件。</p>
<p class="text-center"><small>Nothing.</small></p>
</div>';}
			foreach($files as $keys=>$vals){
				if(count($files[$keys])>0)
				{
					echo '<h3>'.$keys.'</h3><ul>';
					foreach($files[$keys] as $vals2){

						echo '<li><a href="../src/'.$vals2.'" target="_blank"><img class="ft-'.fticon(substr($vals2, strrpos($vals2, '.')+1)).'"/>'.

							$vals2.'</a></li>';
						echo '</ul>';
	
					}
				}

			}
}


 		closedir($handle);
 	}
	
}

//根据文件名返回首字母index
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
ls('../src',$seed);
?>