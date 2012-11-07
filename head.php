<?php
error_reporting(0);
include 'config.php';
mysql_connect("$database_server", "$database_username" , "$database_password") or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
mysql_select_db("$database_name") or die ("Datenbank konnte nicht ausgew&auml;hlt werden");
$settings = mysql_query("SELECT value FROM `sharebase_settings` WHERE `option` = 'filesizelimit';");
$row = mysql_fetch_array($settings);

$visibility_option = 'unchecked';
$filesize = $row['value'];
$filesizebyte = $filesize * 1000000;
$uploaded_filename = $_FILES['datei']['name'];
$owner = $_SESSION['username'];
$size = $_FILES['datei']['size'];
$custom_name = $_POST['custom_name'];
if(isset($_POST['visibility_option'])) {
	$visibility_option = $_POST['visibility_option'];
} if($visibility_option == 'invisible') {
	$visibility_option = 0;
} else {
	$visibility_option = 1;
}
$character = '#^[A-Za-z0-9_.+-]+[.]+$#i';

$extension_query = mysql_query('SELECT * FROM sharebase_fileextensions');
$allowedExtensions = array();

     if($extension_query) {
      while($row_extensions = mysql_fetch_array($extension_query)) {
       $whitelisted_extension = $row_extensions['extension'];
       $allowedExtensions[] = $whitelisted_extension;
      }
     }   

  foreach ($_FILES as $file) { 
    if ($file['tmp_name'] > '') { 
      if (!in_array(end(explode(".", 
            strtolower($file['name']))), 
            $allowedExtensions)) { 
         setcookie("error", "extension", time()+2);
         echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_SERVER['PHP_SELF'] . '">';
         exit;
      } 
    } 
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
     
if(isset($_GET['action']) and $_GET['action'] == "upload") {
	if(!empty($custom_name)) {
		$uploaded_fileextension = pathinfo($uploaded_filename, PATHINFO_EXTENSION);
		$uploaded_filename = ''.$custom_name.'.'.$uploaded_fileextension.'';
	}
	if(!preg_match($character, $uploaded_filename)) {
		setcookie("error", "filename", time()+2);
        echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_SERVER['PHP_SELF'] . '">';
        exit;
	}
	if(empty($uploaded_filename)) {
         setcookie("error", "nofile", time()+2);
         echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_SERVER['PHP_SELF'] . '">';
	} else {
		 if(file_exists('upload/'.$uploaded_filename)) {
         	setcookie("error", "fileexists", time()+2);
         	echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_SERVER['PHP_SELF'] . '">';
		 } else {
			 move_uploaded_file($_FILES['datei']['tmp_name'], "upload/".$uploaded_filename);
			 setcookie("uploaded", "true", time()+2);
			 mysql_query("INSERT INTO sharebase_files (name, owner, size, visible) VALUES ('$uploaded_filename', '$owner', '$size', '$visibility_option');");
			 writelog("".$owner." has uploaded a new file: '".$uploaded_filename."'");
			 echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_SERVER['PHP_SELF'] . '">';
		 }
	}
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<title>Sharebase</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=1000, maximum-scale=1.0">
<link rel="shortcut icon" href="sources/img/favicon.ico" />
<link rel="apple-touch-icon" href="sources/img/apple-touch-icon.png"/>
<link rel="stylesheet" type="text/css" href="sources/style.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
<script type="text/javascript" src="sources/jquery-1.7.1.js"></script>
<script type="text/javascript" src="sources/jquery_notification_v.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $('#upload-trigger').click(function(){
                $(this).next('#upload-content').slideToggle();
                $(this).toggleClass('active');                                  
                
                if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
                        else $(this).find('span').html('&#x25BC;')
                })
            
        // oh nein, es ist kein webkit!    
                
        if (!($.browser.webkit || $.browser.opera)) {
			$('.greenq').height(30)
						.css({marginTop: "0"});	
 		}
 		if ($.browser.opera){
	 		$('.greenq').css({marginTop: "0"});
	 		$('#fileextensions ul').height(238);
 		}
 		if ($.browser.mozilla) {
	 		$('.users li.id').css({paddingTop: "7px"});
	 		$('.users li.delete').css({paddingTop: "7px"});
	 		$('#fileextensions ul').height(228);
 		}
});
</script>
<script type="text/javascript">
function toggleMe(a){
  var e=document.getElementById(a);
  if(!e)return true;
  if(e.style.display=="none"){
    e.style.display="block"
  } else {
    e.style.display="none"
  }
  return true;
}
</script>
<script>
var myMessages = ['error','success']; // define the messages types		 
function hideAllMessages()
{
		 var messagesHeights = new Array(); // this array will store height for each
	 
		 for (i=0; i<myMessages.length; i++)
		 {
				  messagesHeights[i] = $('.' + myMessages[i]).outerHeight();
				  $('.' + myMessages[i]).css('top', -messagesHeights[i]); //move element outside viewport	  
		 }
}

function showMessage(type)
{
	$('.'+ type +'-trigger').click(function(){
		  hideAllMessages();				  
		  $('.'+type).animate({top:"0"}, 500);
	});
}

$(document).ready(function(){
		 
		 // Initially, hide them all
		 hideAllMessages();
		 

		 	 
		 
});       
</script>