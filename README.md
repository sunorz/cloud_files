# 私人云盘  
*通过网页来分享你的文件。*    
`表 flinfo`

|字段名|数据类型|备注|
|:---:|:---:|:---:|
|shcd|varchar(8)|分享码|
|md5fn|varchar(20)|加密后的文件名|
|fn|text|原始文件名|

`表 user`  

|字段名|数据类型|备注|
|:---:|:---:|:---:|
|coln|varchar(50)|登录账户|
|colp|varchar(32)|密码|

**inc/conn.php**   
连接数据库。    
**inc/index.php**    
用于列出私密文件的下载地址。  
访问格式：  
`/cpanel/index.php?key=value`  
**inc/functions.php** *pri* 里的 `$key = 'value';` 要和**inc/ll.php** 里的 `$key = 'value';`一致。
**index.php**
42行的`CONFUSED_STRING`可以替换为其它，注意数据库中user表里的colp也要同时更新。
默认值：
用户名：admin
密码：admin
`md5($.md5('password').'CONFUSED_STRING')`
需要 **PHP** 和 **MySQL**。    
`Copyright by Sunplace`    
本文档最后更新*2019/4/24* 