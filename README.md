# FILES CLOUD
*Share your files through the web.*  

`TABLE flinfo`  
<div>
    <table border="0">
      <tr>
        <th>FILED NAME</th>
        <th>TYPE</th>
        <th>REMARKS</th>
      </tr>
      <tr>
        <td>shcd</td>
        <td>varchar(8)</td>
        <td>Share code</td>
      </tr>
            <tr>
        <td>md5fn</td>
        <td>varchar(20)</td>
        <td>Encrypted file name</td>
      </tr>
            <tr>
        <td>fn</td>
        <td>text</td>
        <td>original file name</td>
      </tr>
    </table>
</div>

`TABLE user`  
<div>
    <table border="0">
      <tr>
        <th>FILED NAME</th>
        <th>TYPE</th>
        <th>REMARKS</th>
      </tr>
      <tr>
        <td>uname</td>
        <td>varchar(50)</td>
        <td>username</td>
      </tr>
    </table>
</div>

**inc/conn.php** 
Connect to the database.  
**inc/index.php**  
Used to list the download address of a private file.  
Access format:  
`/inc/index.php?key=value`  
**inc/functions.php** `$key = 'value';` in *pri* is the same as `$key = 'value';` in **inc/ll.php**.  
Requires **PHP** and **MySQL**.  
`Copyright by Sunplace`  
*2019/1/2*  
[中文版](README_zh-CN.md)
