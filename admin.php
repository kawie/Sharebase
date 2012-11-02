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
  <?php
	  if($_SESSION['status'] != 2) {
		  echo 'Sorry, aber der Adminbereich ist nichts f&uuml;r dich, Sterblicher! Begebe dich doch einfach auf die <a href="./">Startseite</a> zur&uuml;ck.';
		  exit;
	  }
  ?>
  <div id="comment"><a href="profile.php"><button class="green">Benutzerprofil &auml;ndern</button></a><a href="log.php"><button class="green">Log einsehen</button></a></div>
 <div id="newuser" class="box-template">
   <div class="box-title">Neuen Benutzer eintragen</div>
   <div class="box-container">
   <form action="admin.php" method="post">
    Benutzername<br>
    <input type="text" name="username" placeholder="Benutzername"><br /><br />
    Passwort<br>
    <input type="password" name="password" placeholder="Passwort"><br />
    <input type="password" name="password2" placeholder="Passwort wiederholen"><br /><br />
    E-Mail Adresse<br />
    <input type="email" name="mail" placeholder="E-Mail Adresse"><br /><br />
    <input id="checkboxuser" type="radio" name="radio_status" checked value="user" <?php print $radio_user; ?>> <label for="checkboxuser">User</label><br />
    <input id="checkboxmod" type="radio" name="radio_status" value="mod" <?php print $radio_mod; ?>> <label for="checkboxmod">Moderator</label><br />
    <input id="checkboxadmin" type="radio" name="radio_status" value="admin" <?php print $radio_admin; ?>> <label for="checkboxadmin">Admin</label><br />
    <br />
    <input type="hidden" value="sent" name="sent" />
    <input class="green" type="submit" value="Benutzer erstellen">
   </form>
   <?php
   	 $sent = $_POST['sent'];
   
     $radio_user = 'unchecked';
     $radio_mod = 'unchecked';
     $radio_admin = 'unchecked';
    
     $newuser_username = $_POST["username"];
     $password = $_POST["password"]; 
     $password1 = md5($password);
     $password2 = $_POST["password2"];
     $mail = $_POST["mail"];

     $radio_selected = $_POST['radio_status'];
     if($radio_selected == 'user') {
      $newuser_status = '0';
     }
     elseif($radio_selected == 'mod') {
      $newuser_status = '1';
     } 
     elseif($radio_selected == 'admin') {
      $newuser_status = '2';
     }

     if(!empty($newuser_username) AND !empty($password) AND !empty($password2) AND !empty($mail) AND strlen($password) > 7) {
	     $newuser_username_query = mysql_query('SELECT username FROM sharebase_user WHERE `username` = "'.$newuser_username.'"');
	     $taken_usernames = mysql_num_rows($newuser_username_query);
	     if($taken_usernames == 0 AND $password1 == md5($password2) AND preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $mail)) {
		     mysql_query('INSERT INTO sharebase_user (`username`, `password`, `status`, `mail`, `filesize_unit`) VALUES ("'.$newuser_username.'", "'.$password1.'", "'.$newuser_status.'", "'.$mail.'", "KB")');
		     writelog("".$owner." has added a new user: '".$newuser_username."'");
		     echo '<br /><span class="highlight">'.$newuser_username.'</span> wurde erstellt.';
	     } elseif($password1 != $password2) {
		     echo 'Die Passw&ouml;rter stimmen nicht &uuml;berein.'; 
	     } elseif(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $mail) !== true) {
		     echo 'Bitte gib eine richtige E-Mail-Adresse ein.';
	     } elseif(strlen($password) < 8) {
	     	echo 'Das Passwort muss mindestens 8 Zeichen haben!';
	     } elseif(!empty($sent)) {
	     	if(empty($newuser_username) OR empty($password) OR empty($password2) OR empty($mail)) {
		    	echo 'Bitte f&uuml;lle alle Felder aus.';
		    }
	     }
     }
   ?>
   </div>
   </div>
   <div id="userlist" class="box-template">
    <div class="box-title">Mitgliederliste</div>
    <div class="box-container">
    <ul class="title">
     <li class="id">ID</li>
     <li class="username">Benutzername</li>
     <li class="status">Status</li>
     <li class="delete"></li>
    </ul>
    <?php
	 $editname = $_POST['editname'];
	 $editname_oldname = $_POST['editname_oldname'];
	 $editname_newname = $_POST['editname_newname'];
	 
	 $editstatus = $_POST['editstatus_username'];
	 $editstatus_username = $_POST['editstatus_username'];
	 $editstatus_newstatus = $_POST['editstatus_newstatus'];
	 
	 $deluser = $_POST['deluser'];
	 $deluser_name = $_POST['deluser_name'];
	 $deluser_status = $_POST['deluser_status'];
	 
	 $confirmed = $_POST['confirm'];

	 //Edit name
	 if(!empty($editname)) {
		 echo '<form action="admin.php" method="post"><div id="confirm">Neuer Name f&uuml;r <span class="highlight">'.$editname.'</span>: <input type="text" name="editname_newname" />&nbsp;&nbsp;&nbsp;<input type="image" name="confirm" value="editname" src="sources/img/yes_dark.png" />&nbsp;&nbsp;&nbsp;<a href="admin.php"><img src="sources/img/no_dark.png" /></a></div><input type="hidden" name="editname_oldname" value="'.$editname.'" /></form>';
	 }
	 if($confirmed == 'editname' AND !empty($editname_newname)) {
	 	 $editname_check = mysql_query('SELECT `username` FROM `sharebase_user` WHERE `username` LIKE "'.$editname_newname.'"');
	 	 $editname_check_result = mysql_num_rows($editname_check);
		 if($editname_check_result == 0) {
			 mysql_query('UPDATE `sharebase_user` SET `username` = "'.$editname_newname.'" WHERE `username` = "'.$editname_oldname.'"');
			 mysql_query('UPDATE `sharebase_files` SET `owner` = "'.$editname_newname.'" WHERE `owner` = "'.$editname_oldname.'"');
			 writelog("".$owner." has renamed a user: from '".$editname_oldname."' to '".$editname_newname."'");
			 $_SESSION["username"] = $editname_newname;
			 echo '<div id="confirm"><span class="highlight">'.$editname_oldname.'</span> wurde umbenannt in <span class="highlight">'.$editname_newname.'</span>.</div>';
		 } else {
			 echo '<div id="confirm"><span class="highlight">'.$editname_newname.'</span> ist schon vergeben.</div>';
		 }
     }
	 
	 //Edit status
	 if(!empty($editstatus) AND !isset($editstatus_newstatus)) {
		 echo '<form action="admin.php" method="post"><div id="confirm">Neuer Rang f&uuml;r <span class="highlight">'.$editstatus_username.'</span>:  <select name="editstatus_newstatus"><option value="0">User</option><option value="1">Moderator</option><option value="2">Admin</option></select>&nbsp;&nbsp;&nbsp;<input type="image" name="confirm" value="editstatus" src="sources/img/yes_dark.png" />&nbsp;&nbsp;&nbsp;<a href="admin.php"><img src="sources/img/no_dark.png" /></a></div><input type="hidden" name="editstatus_username" value="'.$editstatus_username.'" /></form>';
	 }
	 if($confirmed == 'editstatus') {
		 mysql_query('UPDATE `sharebase_user`  SET `status` = "'.$editstatus_newstatus.'" WHERE `username` = "'.$editstatus_username.'"');
		 if($editstatus_newstatus == 0) {
			 $editstatus_newstatus_word = 'user';
		 } elseif($editstatus_newstatus == 1) {
			 $editstatus_newstatus_word = 'moderator';
		 } elseif($editstatus_newstatus == 2) {
			 $editstatus_newstatus_word = 'administrator';
		 }
		 writelog("".$owner." has changed the status of a user: '".$editstatus_username."' is now ".$editstatus_newstatus_word."");
	 }
	 
	 //Delete user
	 if(!empty($deluser) AND $deluser_status != 'Admin') {
		 echo '<form action="admin.php" method="post"><div id="confirm">M&ouml;chtest Du <span class="highlight">'.$deluser.'</span> wirklich l&ouml;schen?&nbsp;&nbsp;&nbsp;<input type="image" name="confirm" value="deluser" src="sources/img/yes_dark.png" />&nbsp;&nbsp;&nbsp;<a href="admin.php"><img src="sources/img/no_dark.png" /></a></div><input type="hidden" name="deluser_name" value="'.$deluser.'" /></form>';
	 } elseif(!empty($deluser) AND $deluser_status == 'Admin') {
		 echo '<div id="confirm">Admins d&uuml;rfen nicht gel&ouml;scht werden, sorry.&nbsp;&nbsp;&nbsp;<a href="admin.php"><img src="sources/img/no_dark.png" /></a></div>';
	 }
	 if($confirmed == 'deluser' AND !empty($deluser_name)) {
		 mysql_query('DELETE FROM `sharebase_user` WHERE `username` = "'.$deluser_name.'"');
		 $nextid_query = mysql_query('SELECT `id` FROM `sharebase_user` ORDER BY `id` DESC LIMIT 1');
		 writelog("".$owner." has deleted a user: R.I.P '".$deluser_name."'");
		 $nextid_result = mysql_fetch_array($nextid_query);
		 $nextid = $nextid_result['id'] + 1;
		 mysql_query('ALTER TABLE sharebase_user AUTO_INCREMENT ='.$nextid.'');
		 echo '<div id="confirm">R.I.P. <span class="highlight">'.$deluser_name.'</span>.</div>';
	 }
     $result_userlist = mysql_query("SELECT * FROM sharebase_user ORDER BY id");
     
     //Userlist
     if($result_userlist) {
      echo '<ul class="users">';
      while($row = mysql_fetch_array($result_userlist)) {
       $id = $row['id'];
       $username_user = $row['username'];
       $userlist_status = $row['status'];
       if($userlist_status == 2) {
        $userlist_status = 'Admin';
       } elseif($userlist_status == 1) {
        $userlist_status = 'Moderator';
       } elseif($userlist_status == 0) {
        $userlist_status = 'User';
       }
       echo '<li class="id">'.$id.'</li>';
       echo '<form action="admin.php" method="post"><li class="username"><input type="submit" class="hidden" name="editname" value="'.$username_user.'" /></li></form>';
       echo '<form action="admin.php" method="post"><li class="status"><input type="hidden" name="editstatus_username" value="'.$username_user.'" /><input type="submit" class="hidden" name="editstatus" value="'.$userlist_status.'" /></li></form>';
       echo '<form action="admin.php" method="post"><li class="delete"><input type="hidden" value="'.$username_user.'" name ="deluser" /><input type="hidden" value="'.$userlist_status.'" name="deluser_status" /><input type="submit" class="action_delete" value="" /></li></form>';
      }
      echo '</ul>';
     }
    ?>
    </div>
   </div>
   <div id="settings" class="box-template">
    <?php
     if(isset($_POST['filesize']) AND is_numeric($_POST['filesize'])) {
      $filesize = $_POST['filesize'];
      mysql_query("UPDATE `sharebase_settings` SET `value` = '".$filesize."' WHERE `option` = 'filesizelimit';");
     }
     
     $settings = mysql_query("SELECT value FROM `sharebase_settings` WHERE `option` = 'filesizelimit';");
     $row = mysql_fetch_array($settings);
     $oldfilesize = $row['value'];
     
    ?>
    <div class="box-title">Einstellungen</div>
    <div class="box-container">
    <form action="admin.php" method="post">
     <span>Maximale Dateigr&ouml;&szlig;e</span><br />
      <?php echo '<input type="text" name="filesize" value="'.$oldfilesize.'">' ?> MB<br /><br />
     <br /><input class="green" type="submit" value="&Uuml;bernehmen">
    </form>
    </div>
   </div>
   <div id="fileextensions" class="box-template">
    <?php
     $new_extension = $_POST['new_extension'];
     $existing_extension_query = mysql_query("SELECT * FROM sharebase_fileextensions WHERE extension LIKE '$new_extension'"); 
     $existing_extension = mysql_num_rows($existing_extension_query);
     
     if(!empty($new_extension) AND $existing_extension == 0) {
      mysql_query("INSERT INTO sharebase_fileextensions (extension) VALUES ('$new_extension')");
     }
    ?>
    <div class="box-title">Erlaubte Dateitypen</div>
    <div class="box-container">
    <form action="admin.php" method="post">
     <span>Neuer Dateityp</span><br />
      datei.<input type="text" name="new_extension"><br /><span style="color:#868686; font-size:10pt;">Ohne Punkt schreiben (z.B: psd)</span><br />
      <input type="submit" class="green" value="Hinzuf&uuml;gen"><br /><br />
      <span>Derzeit erlaubte Dateitypen</span><br />
      <span style="color:#868686; font-size:10pt;">(Alphabetische Liste zum Scrollen)</span>
    </form>
    </div>
      <?php
       $selected_extension = $_POST['extension_delete'];
       if(!empty($selected_extension)) {
        mysql_query("DELETE FROM sharebase_fileextensions WHERE extension = '$selected_extension'");
       }
       
       $registered_file_extensions = mysql_query("SELECT * FROM sharebase_fileextensions ORDER BY extension");
       $registered_file_extensions_count = mysql_num_rows($registered_file_extensions);
       $registered_file_extensions_count_up = 0;
       if($registered_file_extensions) {
        echo '<ul>';
        while($registered_file_extensions_row = mysql_fetch_array($registered_file_extensions)) {
         $registered_extension = $registered_file_extensions_row['extension'];
         $registered_file_extensions_count_up++;
         if($registered_file_extensions_count_up == $registered_file_extensions_count) {
	         echo '<li style="border:none;">.'.$registered_extension.'<span style="float:right;padding-right:15px;"><input type="submit" class="action_delete" value="" /><form action="admin.php" method="post"><input type="hidden" name="extension_delete" value="'.$registered_extension.'" /></form></span></li>';
         } else {
	         echo '<li>.'.$registered_extension.'<span style="float:right;padding-right:15px;"><form action="admin.php" method="post"><input type="hidden" name="extension_delete" value="'.$registered_extension.'" /><input type="submit" class="action_delete" value="" /></form></span></li>';
         }
        }
        echo '</ul>';
       }
      ?>
   </div>
  </div>
 </div>
</body>
</html>