# 私人云盘  
*通过网页来分享你的文件。*    
`表flinfo`
<div>
    <table border="0">
      <tr>
        <th>字段名</th>
        <th>数据类型</th>
        <th>备注</th>
      </tr>
      <tr>
        <td>shcd</td>
        <td>varchar(8)</td>
        <td>分享码</td>
      </tr>
            <tr>
        <td>md5fn</td>
        <td>varchar(20)</td>
        <td>加密后的文件名</td>
      </tr>
            <tr>
        <td>fn</td>
        <td>text</td>
        <td>原始文件名</td>
      </tr>
    </table>
</div>

`表user` 
<div>
    <table border="0">
      <tr>
        <th>字段名</th>
        <th>数据类型</th>
        <th>备注</th>
      </tr>
      <tr>
        <td>uname</td>
        <td>varchar(50)</td>
        <td>用户名</td>
      </tr>           
    </table>
</div>

**inc/conn.php**   
连接数据库。    
**inc/index.php**    
用于列出私密文件的下载地址。  
访问格式：  
`/inc/index.php?key=value`  
**inc/functions.php** *pri* 里的 `$key = 'value';` 要和**inc/ll.php** 里的 `$key = 'value';`一致。  
需要 **PHP** 和 **MySQL**。    
`Copyright by Sunplace`    
*2019/1/2*    
[English](README.md) 
