# FILES CLOUD
*Share your files through the web.*  

`TABLE flinfo` 

|FILED NAME|TYPE|REMARKS|
|:---:|:---:|:---:|
|shcd|varchar(8)|Share code|
|md5fn|varchar(20)|Encrypted file name|
|fn|text|Original file name|

`TABLE user`  

|FILED NAME|TYPE|REMARKS|
|:---:|:---:|:---:|
|coln|varchar(50)|Login name|
|colp|varchar(32)|Password|

**inc/conn.php** 
Connect to the database.  
**cpanel/index.php**  
Used to list the download address of a private file.  
Access format:  
`/cpanel/index.php?key=value`  
**inc/functions.php** `$key = 'value';` in *pri* is the same as `$key = 'value';` in **inc/ll.php**.  
Requires **PHP** and **MySQL**.  
`Copyright by Sunplace`  
*2019/1/13*  
[中文版](README_zh-CN.md)
