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
    	$selected_file = $_POST['selected_file'];
	    $action_rename = $_POST['rename'];
	    $action_delete = $_POST['delete'];
	    $action_visible = $_POST['visible'];
	    
	    $newname = $_POST['newname'];
	    $oldname = $_POST['oldname'];
	    $delfile = $_POST['delfile'];
	    
	    $visible_query = mysql_query('SELECT visible FROM sharebase_files WHERE name = "'.$selected_file.'"');
		$visible_result = mysql_fetch_array($visible_query);
		    
	    if(isset($action_rename)) {
		    echo '<form action="manage.php" method="post">Neuer Name f&uuml;r <span style="color:#56a015;">'.$selected_file.'</span>: <input type="text" name="newname" /> <input type="hidden" value="'.$selected_file.'" name="oldname" /><input type="submit" value="Umbennen" /></form><span>(Mit oder ohne Dateiendung)</span>';
	    }
	    if(isset($action_delete)) {
		   echo '<form action="manage.php" method="post">Soll die Datei <span style="color:#56a015;">'.$selected_file.'</span> wirklich gel&ouml;scht werden?&nbsp;&nbsp;&nbsp;<input type="hidden" value="'.$selected_file.'" name="delfile" /><input type="image" src="sources/img/yes_dark.png" />&nbsp;&nbsp;&nbsp;<a href="manage.php"><img src="sources/img/no_dark.png" /></a></form><span style="color:red;">Diese Aktion kann nicht r&uuml;ckg&auml;ngig gemacht werden.</span>';
	    }
	    if(isset($action_visible)) {
		    if($visible_result['visible'] == 1) {
			    mysql_query('UPDATE sharebase_files SET visible = 0 WHERE name = "'.$selected_file.'"');
			    echo 'Die Datei <span style="color:#56a015;">'.$selected_file.'</span> ist jetzt unsichtbar.';
			    writelog("".$owner." has changed the visibility of a file: '".$selected_file."' is now invisible");
		    } elseif($visible_result['visible'] == 0) {
			    mysql_query('UPDATE sharebase_files SET visible = 1 WHERE name = "'.$selected_file.'"');
			    echo 'Die Datei <span style="color:#56a015;">'.$selected_file.'</span> ist jetzt sichtbar.';
                writelog("".$owner." has changed the visibility of a file: '".$selected_file."' is now visible");
		    }
	    }
	    
	    if(!isset($action_rename) AND !isset($action_delete) AND !isset($action_visible) AND !isset($newname) AND !isset($oldname) AND !isset($delfile)) {
		    echo 'Hier kannst Du Dateien umbennen, l&ouml;schen und unsichtbar / sichtbar machen. W&auml;hle dazu die jeweilige Aktion.';
	    }
	    
	    if(isset($newname)) {
	    	if(!preg_match($character, $uploaded_filename)) {
		    	echo '<div id="error">Der Dateiname darf nur aus Buchstaben und Zahlen bestehen. Umlaute sind nicht erlaubt!</div>';
	    	} else {
		    	$fileextension = pathinfo($oldname, PATHINFO_EXTENSION);
		    	if(pathinfo($newname, PATHINFO_EXTENSION) != $fileextension) $newname .= '.'.$fileextension;
		    	if(rename('upload/'.$oldname.'', 'upload/'.$newname.'')) {
		    		mysql_query('UPDATE sharebase_files SET name = "'.$newname.'" WHERE name = "'.$oldname.'"');
		    		writelog("".$owner." has renamed a file: from '".$oldname."' to '".$newname."'");
		    		echo '<div id="success">Die Datei wurde erfolgreich umbenannt.</div>';
		    	} else {
		    	echo '<div id="error">Ein unbekannter Fehler ist aufgetreten.</div>';
		    	}
	    	}
	    }
	    if(isset($delfile)) {
		    if(unlink('upload/'.$delfile.'')) {
			    mysql_query('DELETE FROM sharebase_files WHERE name = "'.$delfile.'"');
			    writelog("".$owner." has deleted a file: '".$delfile."'");
			    echo '<div id="success">Die Datei wurde erfolgreich gel&ouml;scht.</div>';
		    } else {
			    echo '<div id="error">Ein unbekannter Fehler ist aufgetreten.</div>';
		    }
	    }
     ?>
     <br /><br />
    </div>
   <div id="title">
    <ul>
     <li class="name">Name</li>
     <li class="date">Dateigr&ouml;&szlig;e</li>
     <li class="size">Uploader</li>
     <li class="uploader">Aktionen</li>
    </ul>
   </div>
   <div id="files">
    <?php
     if($_SESSION['status'] <1) {
      $loggedin_user = $_SESSION['username'];
      $result_files = mysql_query('SELECT * FROM sharebase_files WHERE owner = "'.$loggedin_user.'" ORDER BY name');
     }
     elseif($_SESSION['status'] >0) {
      $result_files = mysql_query("SELECT * FROM sharebase_files ORDER BY name");
     }
     
     if($result_files) {
      echo '<ul>';
      while($row = mysql_fetch_array($result_files)) {
        $name = $row['name'];
        $date = $row['date'];
        $size = $row['size'];
        $owner = $row['owner'];
        
        $visible_query_2 = mysql_query('SELECT visible FROM sharebase_files WHERE name = "'.$name.'"');
		$visible_result_2 = mysql_fetch_array($visible_query_2);
		$tooltip_visible = 'Verbergen';
		$class_invisible = '';
		$class_invisible_compact = '';
		if($visible_result_2['visible'] == 0) {
			$tooltip_visible = 'Zeigen';
			$class_invisible = ' class="invisible"';
			$class_invisible_compact = ' invisible';
		}
	   $link_addition = '';
	   $fileextension_linkaddition = strtolower(pathinfo($name, PATHINFO_EXTENSION));
       if($fileextension_linkaddition == 'md' || $fileextension_linkaddition == 'mdown' || $fileextension_linkaddition == 'text' || $fileextension_linkaddition == 'png' || $fileextension_linkaddition == 'jpg' || $fileextension_linkaddition == 'jpeg'  || $fileextension_linkaddition == 'gif' ) {
	       $link_addition = 'r.php?f=';
       } else {
	       $link_addition = 'upload/';
       }
        
        echo '<li class="name"><span'.$class_invisible.'><a href="'.$link_addition.''.$name.'" target="_blank">'.$name.'</a></span></li>';
        echo '<li class="date"><span'.$class_invisible.'>';
        echo round($size / 1024, 3).' KB</span></li>';
        echo '<li class="size"><span'.$class_invisible.'>'.$owner.'</span></li>';
        echo '<li class="uploader">
        <form action="manage.php" method="post">
         <input type="hidden" name="selected_file" value="'.$name.'" />
         <a href="#" class="tooltip"><input type="submit" class="action_rename'.$class_invisible_compact.'" value="" name="rename" /><span>Umbenennen</span></a>
         <a href="#" class="tooltip"><input type="submit" class="action_delete'.$class_invisible_compact.'" value="" name="delete" /><span>L&ouml;schen</span></a>
         <a href="#" class="tooltip"><input type="submit" class="action_visible'.$class_invisible_compact.'" value="" name="visible" /><span>'.$tooltip_visible.'</span></a>
        </form>
        </li>';
      }
      echo '</ul>';
     }
    ?>
   </div>
  </div>
 </div>
</body>
</html>