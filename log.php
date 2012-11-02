<?php
session_start(1); 
if(!isset($_SESSION["username"])) 
   { 
   echo '<html><head><meta http-equiv="refresh" content="0; URL=./login.php">'; 
   exit; 
   }
 include 'head.php';
?>
</head>
<body>
 <div style="font-family:Courier,sans-serif;font-size:10pt;padding:10px;">
  <?php
   $logfilename_query = mysql_query("SELECT value FROM `sharebase_settings` WHERE `option` = 'logfilename'");
   $logfilename_row = mysql_fetch_array($logfilename_query);
   $logfilename = $logfilename_row['value'];
   echo nl2br(file_get_contents($logfilename));
  ?>
 </div>
</body>
</html>