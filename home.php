<?php 

$host = $_SERVER["HTTP_HOST"];
$host_user = $_SERVER['REMOTE_ADDR'];
echo $host;
echo "<br>";
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <br> 
    <script language="JavaScript"> function GetLocalIPAddr(){ var oSetting = null; var ip = null; try{ oSetting = new ActiveXObject("rcbdyctl.Setting"); ip = oSetting.GetIPAddress; if (ip.length == 0){ return "Not connected Internet"; } oSetting = null; }catch(e){ return ip; } return ip; } document.write(GetLocalIPAddr()+"<br/>") </script> 

    </body>
</html>