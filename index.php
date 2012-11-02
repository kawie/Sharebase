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
   <div id="title">
    <ul>
     <li class="name">Name</li>
     <li class="date">Datum des Uploads</li>
     <li class="size">Dateigr&ouml;&szlig;e</li>
     <li class="uploader">Uploader</li>
    </ul>
   </div>
   <div id="files">
    <?php  
     $custom_filesize_unit_query = mysql_query('SELECT filesize_unit FROM sharebase_user WHERE `username` = "'.$_SESSION['username'].'"');
     $custom_filesize_unit_result = mysql_fetch_array($custom_filesize_unit_query);
     $custom_filesize_unit = $custom_filesize_unit_result['filesize_unit'];
     
     $result_files = mysql_query("SELECT name, owner, DATE_FORMAT(DATE, '%d.%m.%Y - %H:%i') AS date, size, visible FROM sharebase_files ORDER BY `name`");
     if($result_files) {
      echo '<ul>';
      while($row = mysql_fetch_array($result_files)) {
      $keks = 0;
      $class_invisible = '';
       if($_SESSION['status'] == 0 AND $row['visible'] == 0) {
	       if($_SESSION['username'] == $row['owner']) {
			$class_invisible = ' class="invisible"';
	       } else {
		       continue;
	       }
       } elseif($_SESSION['status'] >0 AND $row['visible'] == 0) {
			$class_invisible = ' class="invisible"';
       }
       $name = $row['name'];
       $date = $row['date'];
       $size = $row['size'];
       $owner = $row['owner'];
       $link_addition = '';
       $fileextension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
       if($fileextension == 'md' || $fileextension == 'mdown' || $fileextension == 'text' || $fileextension == 'png' || $fileextension == 'jpg' || $fileextension == 'jpeg'  || $fileextension == 'gif' ) {
	       $link_addition = 'r.php?f=';
       } else {
	       $link_addition = 'upload/';
       }
       echo '<li class="name"><span'.$class_invisible.'><a href="'.$link_addition.''.$name.'">'.$name.'</a></span></li>';
       echo '<li class="date"><span'.$class_invisible.'>'.$date.'</span></li>';
       echo '<li class="size"><span'.$class_invisible.'>';
       if($custom_filesize_unit == 'KB') {
	       echo round($size / 1024, 3).' KB</span></li>';
       } elseif($custom_filesize_unit == 'MB') {
	       echo round($size / 1048576, 3). ' MB</span></li>';
       }
       echo '<li class="uploader"><span'.$class_invisible.'>'.$owner.'</span></li>';
      }
      echo '</ul>';
     }
    ?>
   </div>
  </div>
 </div>
</body>
</html>