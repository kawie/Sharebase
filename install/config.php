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
    <span style="color:#56a015;">Share</span><span style="color:#868686;">base <span style="font-style:italic;font-size:17pt;">Installation 25%</span></span>
   </div>
  </div>
  <div id="progress_frame"><div id="progress_content" style="width:25%;"></div></div>
  <br />
  <?php
  	if(is_file("../config.php")) {
	  	unlink("../config.php");
  	}
  	
  	$database_server = $_POST["database_server"];
  	$database_username = $_POST["database_username"];
  	$database_password = $_POST["database_password"];
  	$database_name = $_POST["database_name"];
  	
  	touch("../config.php");
  	$config_file = fopen("../config.php", "a");
  	fwrite($config_file, "<?php
//Configuration file for Sharebase
//Just edit the values (\$var = 'edit me'; for example)
\$database_server = '".$database_server."'; //Your MySQL-Server (mostly 'localhost')
\$database_username = '".$database_username."'; //Enter the username for your MySQL-Connection
\$database_password = '".$database_password."'; //Enter the password for the MySQL-Connection
\$database_name = '".$database_name."'; //Enter the database name of your MySQL-Connection
?>");
	fclose($config_file);
	if(!empty($database_server)) {
		echo '<html><head><meta http-equiv="refresh" content="0; URL=sql.php">';
	}
  ?>
  <span class="question">Trage in den folgenden Feldern bitte deine Informationen f&uuml;r die Datenbank ein.</span><br /><br />
  <form action="config.php" method="post">
  Datenbankserver*: <input type="text" placeholder="Datenbankserver" value="localhost" name="database_server" /><br />
  Benutzername: <input type="text" placeholder="Benutzername" name="database_username" /><br />
  Passwort: <input type="password" placeholder="Passwort" name="database_password" /><br />
  Datenbankname**: <input type="text" placeholder="Datenbankname" value="sharebase" name="database_name" /><br /><br />
 <span class="answer" style="font-size: 9pt;">* In den meisten F&auml;llen ist der Datenbankserver "localhost"<br />
  ** Frei w&auml;hlbar, aber "sharebase" wird empfohlen. Die Datenbank muss existieren.</span><br /><br />
  <input class="green" type="submit" value="Fortfahren" />
  </form>
 </div>
</body>
</html>