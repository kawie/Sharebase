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
 <div id="container">
 <?php include 'divhead.php'; ?>
  <div id="db">
  	<div id="error">Die Anleitung f&uuml;r Markdown folgt leider erst in sp&auml;teren Sharebase-Versionen.<br /><a href="help.php">Zur&uuml;ck zur Hilfe</a></div>
  </div>
 </div>
</body>
</html>