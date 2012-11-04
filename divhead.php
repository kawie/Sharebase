  <div id="head">
   <div id="logo">
    <a href="./"><span class="logo-share">Share</span><span class="logo-base">base</span>&nbsp;</a><a href="javascript:location.reload(true);"><img src="sources/img/reload.png" alt="Aktualisieren"/></a>
   </div>
   <div id="menu">
        <?php
         if(isset($_COOKIE['error']) and $_COOKIE['error'] == "filesize"){
        ?>
        <div class="error message">
         <script type="text/javascript">
          showNotification({
           message: "Deine Datei ist zu gro&szlig;! Das Maximum liegt bei <?php echo $filesize; ?> MB.",
           type: "error",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }elseif(isset($_COOKIE['uploaded']) and $_COOKIE['uploaded'] == "true"){
        ?>
        <div class="success message">
         <script type="text/javascript">
          showNotification({
           message: "Deine Datei wurde erfolgreich hochgeladen!",
           type: "success",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }elseif(isset($_COOKIE['error']) and $_COOKIE['error'] == "nofile"){
        ?> 
        <div class="error message">
         <script type="text/javascript">
          showNotification({
           message: "Bitte w&auml;hle eine Datei aus!",
           type: "error",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }elseif(isset($_COOKIE['error']) and $_COOKIE['error'] == "extension"){
        ?>
        <div class="error message">
         <script type="text/javascript">
          showNotification({
           message: "Diese Dateiendung ist verboten.",
           type: "error",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }elseif(isset($_COOKIE['error']) and $_COOKIE['error'] == "fileexists"){
        ?>
        <div class="error message">
         <script type="text/javascript">
          showNotification({
           message: "Eine Datei mit diesem Namen existiert bereits!",
           type: "error",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }elseif(isset($_COOKIE['error']) and $_COOKIE['error'] == "filename"){
        ?>
        <div class="error message">
         <script type="text/javascript">
          showNotification({
           message: "Der Dateiname darf nur aus Buchstaben und Zahlen bestehen. Umlaute sind nicht erlaubt!",
           type: "error",
           autoClose: true,
           duration: 2
          });
         </script>
        </div>
        <?
         }
        ?>
    <ul>
     <li><a href="login.php?action=logout"><button class="greenq"><img src="sources/img/logout.png" alt="Logout"/></button></a></li>
    <?php
     if($_SESSION['status'] == 2) {
      echo '<li><a href="admin.php"><button class="greenq"><img src="sources/img/admin.png" alt=""/></button></a></li>';
     }
     else {
      echo '<li><a href="profile.php"><button class="greenq"><img src="sources/img/admin.png" alt=""/></button></a></li>';
     }
    ?>
     <li><a href="help.php"><button class="green">Hilfe</button></a></li>
     <li><a href="manage.php"><button class="green">Dateien verwalten</button></a></li>
     <li><a href="create.php"><button class="green">Datei anlegen</button></a></li>
     <li>
      <a id="upload-trigger" href="#"><button class="green">Datei hochladen</button></a>  
       <div id="upload-content">
        <div class="column1">
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=upload" method="post" enctype="multipart/form-data"> 
          <span class="highlight">1. Datei ausw&auml;hlen</span><br />
          <input type="file" name="datei" style="background:none;"><br>
          <span style="color:#868686;font-size:10pt;">Deine Datei darf nicht gr&ouml;&szlig;er als <?php echo $filesize; ?> MB sein!</span><br />
         </div>
         <div class="column2">
          <span class="highlight">2. Dateioptionen</span><br />
          <input id="invisible" type="checkbox" name="visibility_option" value="invisible" <?php print $visibility_option; ?> /> <label for="invisible"> Datei unsichtbar</label><br />
          <input type="text" name="custom_name" placeholder="Dateiname"/>
          <span style="color:#868686;font-size:10pt;">F&uuml;r Originalnamen freilassen</span>
         </div>
         <div class="column3">
         <span class="highlight">3. Datei hochladen</span><br />
         <input type="submit" value="Hochladen!" class="green" ><br />
         </div>
          </form>
       </div>
      </li>
    </ul>
   </div>
  </div>