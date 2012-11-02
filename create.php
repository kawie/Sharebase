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
   $character = '#^[a-z0-9]+$#i';
   $name = $_POST['filename'];
   $content = $_POST['content'];
                $suchen   = array( 'ä', 'ö', 'ü', 'ß', 'Ä', 'Ö', 'Ü', '§' );
                $ersetzen = array( '&auml;', '&ouml;', '&uuml;', '&szlig;', '&Auml;', '&Ouml;', '&Uuml;', '&sect;' );
                $content = str_replace( $suchen, $ersetzen, trim($content) );
   include_once("sources/markdown.php");
   $md_text = Markdown($content);
  ?>
  <form action="create.php" method="post">
   <span style="color:#868686;">Dateiname:</span><br />
   <?php echo '<input name="filename" type="text" placeholder="Dateiname" value="'.$name.'"/>' ?>.md<br /><br />
   <span style="color:#868686;">Inhalt der Datei:</span><br />
   <textarea name="content" cols="97" rows="20"><?php echo $content; ?></textarea><br /><br />
   <input class="green" type="submit" value="Datei erstellen"/>&nbsp;&nbsp;&nbsp;
   <?php
    $owner = $_SESSION['username'];
    if(file_exists('upload/'.$name.'.md')) {
     echo 'Eine Datei unter dem Namen "'.$name.'.md" existiert bereits. Bitte w&auml;hle einen anderen!';
    }
    elseif(empty($name)) {
     echo '';
    }
    elseif(empty($name)) {
     echo 'Gib deiner Datei bitte einen Namen!';
    }
    elseif(empty($md_text)) {
     echo 'Willst du etwa nichts schreiben?';
    }
    elseif(preg_match($character, $name)) {
     touch('upload/'.$name.'.md');
     $datei = fopen('upload/'.$name.'.md', 'r+');
     fwrite($datei, $md_text);
     fclose($datei);
     echo 'Die Datei "'.$name.'.md" wurde erfolgreich erstellt!<html><head><meta http-equiv="refresh" content="1; URL=./">';
     $size = filesize('upload/'.$name.'.md');
     mysql_query("INSERT INTO sharebase_files (name, owner, size, visible) VALUES ('$name.md', '$owner', '$size', '1');");
     writelog("".$owner." has written a new text: '".$name.".md'");
    }
    else {
     echo 'Der Dateiname darf nur aus Buchstaben und Zahlen bestehen. Umlaute sind nicht erlaubt!';
    }
   ?>
  </form>
 </div>
</body>
</html>