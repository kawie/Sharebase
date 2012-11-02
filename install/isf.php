<!DOCTYPE html>
<?php error_reporting(0); ?>
<html lang="de">
<head>
<title>Sharebase Installation</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="shortcut icon" href="../sources/img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="../sources/style.css">
<link rel="stylesheet" type="text/css" href="install.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
</head>
<body>
 <div id="container">
  <div id="head">
   <div id="logo">
    <span style="color:#56a015;">Share</span><span style="color:#868686;">base <span style="font-style:italic;font-size:17pt;">Installation 100%</span></span>
   </div>
  </div>
  <div id="progress_frame"><div id="progress_content" style="width:100%;"></div></div>
  <br />
  <?php
  include '../config.php';
  	mysql_connect("$database_server", "$database_username" , "$database_password") or die("Verbindung zur Datenbank konnte nicht hergestellt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");
  	mysql_select_db("$database_name") or die ("Datenbank konnte nicht ausgew&auml;hlt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");
  	
  	$registered_user = mysql_query("SELECT username FROM sharebase_user WHERE id = 1");
    $owner_row = mysql_fetch_array($registered_user);
    $owner = $owner_row['username'];
    $size = filesize('danke.pdf');
    mkdir("../upload", 0777);
    chmod("../upload", 0777);
    $oldthx = 'danke.pdf';
    $newthx = '../upload/danke.pdf';
    if (copy($oldthx, $newthx)) {
     mysql_query("INSERT INTO sharebase_files (name, owner, size, visible) VALUES ('danke.pdf', '$owner', '$size', 1);");
    }
  ?>
  
  Die Installation wurde erfolgreich abgeschlossen.<br />
  Wir (<a href="https://twitter.com/janh97">Jan</a>, <a href="https://twitter.com/Der_Hutt">Jannis</a> und <a href="https://twitter.com/KaWie">Kai</a>) w&uuml;nschen Dir viel Spa&szlig; mit der Sharebase!<br /><br />
  Um Dich anzumelden, klicke einfach auf den Button:
  <br /><br />
  <a href="../login.php"><button class="green">Anmelden</button></a>
 </div>
</body>
</html>