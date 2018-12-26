# FILES CLOUD
*Share your files through the web.*   
**src/config.txt**  
Used to retrieve public files and generate them automatically.  
format:  
`[Share code], [file name (with suffix)]; \t\n`  
**inc/data.php**  
Used to retrieve private files and configure them manually.  
format:  
`//[File SHA1 hash value], [file name (with suffix)]`  
**inc/index.html**  
Used to query the share code (link) corresponding to the private file SHA1.  
Requires **PHP** runtime environment.  
`Copyright by Sunplace`  
*2018/12/17*  
[中文版](README_zh-CN.md)
