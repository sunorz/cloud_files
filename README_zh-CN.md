# 私人云盘  
*通过网页来分享你的文件。*    
**src/config.txt**  
用于检索公开的文件，自动生成。  
格式：  
`[分享码],[文件名（带后缀）];\t\n`  
**inc/data.php**  
用于检索私密的文件，手动配置。  
格式：  
`//[文件SHA1散列值],[文件名（带后缀）]`  
**inc/index.html**  
用于查询私密文件SHA1对应的分享码（链接）。  
需要 **PHP** 运行环境。    
`Copyright by Sunplace`    
*2018/12/17*    
[English](README.md) 
