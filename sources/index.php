<?php
if (! isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $ip = $_SERVER['REMOTE_ADDR'];
}
else {
 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<title>Sharebase</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<!-- Favicon
<link rel="shortcut icon" href="img/favicon.ico" />
-->
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
</head>
<body>
 <div id="container">
  <div id="db">
   <div id="error">
    <span>Hey du! Was willst du denn hier? Ich glaube, du hast dich vertan und wolltest hier gar nicht hin, denn es gibt hier absolut gar nichts zu sehen, bis auf diesen wunderh&uuml;bschen roten Kasten mit CSS3-Stripes drin. Wenn du nun bitte wieder auf die Startseite zur&uuml;ck gehen und alle deine privaten Dateien hochladen w&uuml;rdest? Vielen Dank, <?php echo $ip; ?>!</br>Hochachtungsvoll,</br>deine Sharebase</a></span>
   </div>
   <a href="../">Auf nach Narnia! &Auml;&auml;&auml;h, zur Startseite.</a>
  </div>
 </div>
</body>
</html>