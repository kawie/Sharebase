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
    <span style="color:#56a015;">Share</span><span style="color:#868686;">base <span style="font-style:italic;font-size:17pt;">Installation 75%</span></span>
   </div>
  </div>
  <div id="progress_frame"><div id="progress_content" style="width:75%;"></div></div>
  <br />
  <?php
  include("../config.php");
  mysql_connect("$database_server", "$database_username" , "$database_password") or die("Verbindung zur Datenbank konnte nicht hergestellt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");
  	mysql_select_db("$database_name") or die ("Datenbank konnte nicht ausgew&auml;hlt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");
  ?>
  Gib hier bitte die Daten ein, mit denen Du dich gleich in der Sharebase anmelden willst. Du wirst der erste Benutzer und verf&uuml;gst &uuml;ber Administrationsrechte.<br /><br />
  <?php
  	 $username = $_POST["username"]; 
     $password = $_POST["password"];
     $password1 = md5($password); 
     $password2 = $_POST["password2"];
     $mail = $_POST["mail"];
     $submitted = $_POST["submitted"];
  ?>
   <form action="reg.php" method="post">
   <form action="admin.php" method="post">
    Benutzername<br>
    <input type="text" name="username" placeholder="Benutzername" value="<?php echo $username; ?>"><br /><br />
    Passwort<br>
    <input type="password" name="password" placeholder="Passwort"><br />
    <input type="password" name="password2" placeholder="Passwort wiederholen"><br /><br />
    E-Mail Adresse<br />
    <input type="email" name="mail" placeholder="E-Mail Adresse" value="<?php echo $mail; ?>"><br /><br />
    <input type="hidden" value="submitted" name="submitted" />
   <input type="submit" class="green" value="Registrieren!">
  </form>
<?php
     if(!empty($submitted)) {
	     if(!empty($username) AND !empty($password1) AND !empty($password2) AND !empty($mail)) {
		     if(strlen($password) > 7 AND preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $mail)) {
			     if($password1 == md5($password2)) {
				     mysql_query('INSERT INTO sharebase_user (`username`, `password`, `status`, `mail`, `filesize_unit`) VALUES ("'.$username.'", "'.$password1.'", "2", "'.$mail.'", "KB")');
				     echo '<br />Benutzer <span class="highlight">'.$username.'</span> wurde erstellt.<br /><br /><a href="isf.php"><button class="green">Fertigstellen</button></a>';
			     } else {
				     echo 'Die Passw&ouml;rter stimmen nicht &uuml;berein.';
			     }
		     } elseif(strlen($password) < 8) {
			     echo 'Das Passwort muss mindestens 8 Zeichen lang sein.';
		     } elseif(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $mail) !== true) {
			     echo 'Bitte gib eine richtige E-Mail-Adresse ein.';
		     }
	     } elseif(empty($username) OR empty($password1) OR empty($password2) OR empty($mail)) {
		     echo 'Bitte f&uuml;lle alle Felder aus.';
	     }
     }
     ?> 
  <br /><br />
 </div>
</body>
</html>