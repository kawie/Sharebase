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
    <span style="color:#56a015;">Share</span><span style="color:#868686;">base <span style="font-style:italic;font-size:17pt;">Installation 50%</span></span>
   </div>
  </div>
  <div id="progress_frame"><div id="progress_content" style="width:50%;"></div></div>
  <br />
  <?php
  	include '../config.php';
  	mysql_connect("$database_server", "$database_username" , "$database_password") or die("Verbindung zur Datenbank konnte nicht hergestellt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");
  	mysql_select_db("$database_name") or die ("Datenbank konnte nicht ausgew&auml;hlt werden.<br /><br /> <a href='config.php'><button class='green'>Zur&uuml;ck</button</a>");

	//Tabelle "sharebase_fileextensions" anlegen
	mysql_query("CREATE TABLE IF NOT EXISTS `sharebase_fileextensions` (
  `extension` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

	//Tabelle "sharebase_fileextensions" füllen
	mysql_query("INSERT INTO `sharebase_fileextensions` (`extension`) VALUES
('7zip'),
('doc'),
('docx'),
('gif'),
('jpeg'),
('jpg'),
('m4a'),
('mov'),
('mp3'),
('pdf'),
('png'),
('ppt'),
('pptx'),
('rar'),
('rtf'),
('tif'),
('tiff'),
('txt'),
('xls'),
('md'),
('zip'),
('odt'),
('pass'),
('text'),
('mdown'),
('tar.gz'),
('dmg');");
	
	
	//Tabelle "sharebase_files" anlegen
	mysql_query("CREATE TABLE IF NOT EXISTS `sharebase_files` (
  `name` varchar(150) NOT NULL,
  `owner` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` int(150) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
	
	//Tabelle "sharebase_settings" anlegen
	mysql_query("CREATE TABLE IF NOT EXISTS `sharebase_settings` (
  `option` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
	
	//Tabelle "sharebase_settings" füllen
	mysql_query("INSERT INTO `sharebase_settings` (`option`, `value`) VALUES
('filesizelimit', '50'),
('logfilename', 'log.txt');");
	
	//Tabelle "sharebase_user" anlegen
	mysql_query("CREATE TABLE IF NOT EXISTS `sharebase_user` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mail` varchar(150) NOT NULL DEFAULT '',
  `filesize_unit` varchar(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
  ?>
  <div id="success">Die Datenbank wurde erfolgreich angelegt. Klicke jetzt auf "Fortfahren"</div>
  <br /><br />
  <a href="reg.php"><button class="green">Fortfahren</button></a>
 </div>
</body>
</html>