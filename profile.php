<?php 
session_start(1); 
if(!isset($_SESSION["username"])) 
   { 
   echo '<html><head><meta http-equiv="refresh" content="0; URL=./login.php">'; 
   exit; 
   } 
 include 'head.php';
$oldname = $_SESSION["username"];
?>
</head>
<body>
 <div id="container">
 <?php include 'divhead.php'; ?>
  <div id="db">
  <?php
   if($_SESSION['status'] == 2) {
    echo '<div id="comment"><a href="admin.php"><button class="green">Administration</button></a><a href="log.php"><button class="green">Log einsehen</button></a></div>';
   }
  ?>
   <div class="box-template" id="edituser_box">
   <div class="box-title">Benutzernamen &auml;ndern</div>
   <div class="box-container">
    <?php
     $echosuccess = 0;
     $echoerror = 0;
     $newname = $_POST['newname'];
     $existing_user_query = mysql_query("SELECT id FROM sharebase_user WHERE username LIKE '$newname'"); 
     $existing_user = mysql_num_rows($existing_user_query);
     if(!empty($newname) AND $existing_user == 0) {
      mysql_query('UPDATE  sharebase_user SET  username =  "'.$newname.'" WHERE  username ="'.$oldname.'";');
      mysql_query('UPDATE  sharebase_files SET  owner =  "'.$newname.'" WHERE  owner ="'.$oldname.'";');
      writelog("".$owner." has changed his/her name to '".$newname."'");
      $echosuccess = 1;
      $_SESSION["username"] = $newname;
     }
     elseif($existing_user != 0) {
      $echoerror = 1;
     }
     $oldname = $_SESSION["username"];
    ?>
    <form action="profile.php" method="post">
     <span>Neuer Benutzername</span>
     <?php echo'<input type="text" name="newname" placeholder="'.$oldname.'">' ?><br /><br />
     <input type="submit" class="green" value="&Uuml;bernehmen"><br /><br />
    </form>
    <?php
     if($echosuccess == 1) {
	     echo 'Du hei&szlig;t jetzt <span style="color:#56a015;">'.$newname.'</span>!<br /><br />';
     }
     if($echoerror == 1) {
	     echo 'Der Name <span style="color:#56a015;">'.$newname.'</span> ist leider schon vergeben.';
     }
    ?>
   </div>
   </div>
   <div id="edituser_box" class="box-template">
    <div class="box-title">Passwort &auml;ndern</div>
    <div class="box-container">
    <form action="profile.php" method="post">
     <span>Altes Passwort</span>
     <input type="password" name="oldpass"><br /><br />
     <span>Neues Passwort</span>
     <input type="password" name="newpass1"><br />
     <span>Passwort wiederholen</span>
     <input type="password" name="newpass2"><br /><br/>
     <input type="submit" class="green" value="&Uuml;bernehmen"><br /><br />
    </form>
   <?php
     $oldpass = $_POST['oldpass'];
     $oldpass = md5($oldpass);
     $newpass1 = $_POST['newpass1'];
     $newpass2 = $_POST['newpass2'];
     
     $result_pass = mysql_query("SELECT password FROM sharebase_user WHERE username = '".$oldname."'");
     $row = mysql_fetch_array($result_pass);
     $pass = $row['password'];
     
     if(!empty($oldpass) AND !empty($newpass1) AND !empty($newpass2) AND $newpass1 == $newpass2 AND $oldpass == $pass) {
      $newpassword = md5($newpass1);
      mysql_query('UPDATE sharebase_user SET password = "'.$newpassword.'" WHERE username ="'.$oldname.'";');
      echo 'Dein Passwort wurde ge&auml;ndert.<br /> Logge dich beim n&auml;chsten Mal mit dem neuen Passwort ein.';
     }
   ?>
    </div>
   </div>
   <div class="box-template" id="edituser_box">
   <div class="box-title">Pers&ouml;nliche Einstellungen</div>
   <div class="box-container">
   <?php
   	$filesize_unit_kb = 'unchecked';
   	$filesize_unit_mb = 'unchecked';
   	$filesize_unit = $_POST['filesize_unit'];
   	if(!empty($filesize_unit)) {
	   	mysql_query('UPDATE sharebase_user SET `filesize_unit` = "'.$filesize_unit.'" WHERE `username` = "'.$oldname.'";');
   	}
   	$current_filesize_unit_query = mysql_query('SELECT `filesize_unit` FROM sharebase_user WHERE `username` = "'.$oldname.'";');
   	$current_filesize_unit_result = mysql_fetch_array($current_filesize_unit_query);
   	$current_filesize_unit = $current_filesize_unit_result['filesize_unit'];
   	
   ?>
    <form action="profile.php" method="post">
     Dateigr&ouml;&szlig;e anzeigen als:<br />
     <input type="radio" name="filesize_unit" value="KB" id="kb" <?php if($current_filesize_unit == 'KB') { echo 'checked'; } ?> <?php print $filesize_unit_kb ?> /><label for="kb">KB</label><br />
     <input type="radio" name="filesize_unit" value="MB" id="mb" <?php if($current_filesize_unit == 'MB') { echo 'checked'; } ?> <?php print $filesize_unit_mb ?> /><label for="mb">MB</label><br /><br />
     <input type="submit" class="green" value="&Uuml;bernehmen"><br /><br />
    </form>
   </div>
   </div>
  </div>
 </div>
</body>
</html>