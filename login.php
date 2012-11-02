<?php
error_reporting(0);
include 'config.php';
session_start();
  if ($_GET["action"] == "logout") {
   session_destroy();   
   echo '<html><head><meta http-equiv="refresh" content="0; URL=./login.php">';
  }
  
function writelog($logfile_action) {
 $logfile_date = date("(d.m.y - H:i:s)");
 $logfile_action = $logfile_action. " \n";
 $string = $logfile_date.' '.$logfile_action;
 $newlogfilename = md5($logfile_date);
 $newlogfilename = $newlogfilename . ".txt";
 $oldlogfilename_query = mysql_query("SELECT value FROM `sharebase_settings` WHERE `option` = 'logfilename'");
 $oldlogfilename_row = mysql_fetch_array($oldlogfilename_query);
 $oldlogfilename = $oldlogfilename_row['value'];
 rename($oldlogfilename, $newlogfilename);
 mysql_query("UPDATE `sharebase_settings` SET `value` = '".$newlogfilename."' WHERE `value` = '".$oldlogfilename."'");
 $logfile_handle = fopen($newlogfilename, 'a+');
 fwrite($logfile_handle, $string);
 fclose($logfile_handle);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<title>Anmeldung</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="shortcut icon" href="sources/img/favicon.ico" />
<link rel="stylesheet" href="sources/login-style.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
</head>
<body>
  <div id="login">
  <?php $sent = $_POST['sent']; ?>
   <form action="login.php" method="post">
   <h1>Sharebase Login</h1>
   <div id="status">
    <?php 
    if(is_dir('install') AND !is_file('upload/danke.pdf')) {
	    echo '<html><head><meta http-equiv="refresh" content="0; URL=install/">';
	    exit;
    }
    mysql_connect("$database_server", "$database_username" , "$database_password") or die("Verbindung zur Datenbank konnte nicht hergestellt werden.");
    mysql_select_db("$database_name") or die ("Datenbank konnte nicht ausgewählt werden.");
    
    if(is_dir('install')) {
     $dir = 'install';
     $handle = opendir($dir);
     while($file = readdir($handle)) {
      unlink('install/'.$file.'');
     }
     rmdir('install');
     echo 'Melde Dich mit dem vorhin angelegten Benutzer an.';
     writelog("Sharebase installation completed");
    }
    
    $username = trim($_POST["username"]);
    $password = md5($_POST["password"]); 
    $query = mysql_query("SELECT username, password, status FROM sharebase_user WHERE username LIKE '$username' LIMIT 1");
    $row = mysql_fetch_array($query);
    $rightpwd = $row['password'];
    $dbusr = $row['username'];
    
    if(!empty($username) AND !empty($password) AND $rightpwd == $password) {
	    $_SESSION['status'] = $row['status'];
	    $_SESSION['username'] = $row['username'];
	    echo '<img src="sources/img/door.png"> Login erfolgreich. Du wirst nun weitergeleitet. <html><head><meta http-equiv="refresh" content="1; URL=./">';
    } elseif(empty($username) AND $sent == 1 OR $password == 'd41d8cd98f00b204e9800998ecf8427e' AND $sent == 1) {
    	echo '<img src="sources/img/bolt.png"> Bitte f&uuml;lle beide Felder aus.';
    } elseif($rightpwd != $password AND $sent == 1) {
    	echo '<img src="sources/img/bolt.png"> Benutzername und / oder Passwort falsch.';
    }
    ?>
   </div>
    <div id="inputs">
     <input id="input" type="text" size="24" maxlength="50" name="username" placeholder="Benutzername" value="<?php echo $_POST["username"]; ?>"><br><br>
     <input id="input" input="input" type="password" size="24" maxlength="50" name="password" placeholder="Passwort" <?php  if($sent == 1) { echo 'autofocus="autofocus"'; } ?>><br>
     <input type="hidden" name="sent" value="1" />
     <input id="button" type="submit" value="Login">
    </div>
   </form>
   <span class="foot">(cc) 2012 Sharebase &nbsp;&middot;&nbsp; <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/de/">Lizenz: CC BY-NC-SA 3.0</a></span>
 </div>
</body>
</html>