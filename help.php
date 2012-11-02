<?php 
session_start(1); 
include 'head.php';
if(!isset($_SESSION["username"])) 
   { 
   echo '<html><head><meta http-equiv="refresh" content="0; URL=./login.php">'; 
   exit; 
   } 
?> 
</head>
<body>
 <div id="container">
 <?php include 'divhead.php'; ?>
  <div id="db">
    <span class="question">Was ist Sharebase?</span><br />
    <span class="answer">Sharebase bietet einen einfachen Dateiaustausch f&uuml;r kleine Gruppen. Sharebase ist einfach und schlicht gehalten und auf das Wesentliche reduziert.</span><br />
    <br />
    <span class="question">K&ouml;nnen andere die Dateien sehen?</span><br />
    <span class="answer">Die Dateien sind &ouml;ffentlich. Jeder, der den Link hat kann die Datei ansehen und herunterladen. Die Liste der Dateien ist allerdings nur von registrierten Benutzern einsehbar.</span><br />
    <br />
    <span class="question">Was kann ich bei "Dateien verwalten" machen?</span><br />
    <span class="answer">Du kannst Dateien umbenennen, Dateien l&ouml;schen, Dateien unsichtbar / sichtbar machen und Dateien zippen (mit anschlie&szlig;endem Download). W&auml;hle dazu einfach die jeweilige Aktion.<br /><br />
    <img src="sources/img/rename_p.png" /> &nbsp;- Dateien umbenennen<br />
    <img src="sources/img/delete_p.png" /> &nbsp;- Dateien l&ouml;schen<br />
    <img src="sources/img/visible_p.png" />&nbsp;- Dateien unsichtbar / sichtbar machen
    </span><br />
    <br />
    <span class="question">"Datei anlegen" - Was ist das denn?</span><br />
    <span class="answer">Bei "Datei anlegen" kannst Du ganz einfach online einen Text verfassen, der dann automatisch in der Sharebase gespeichert wird. Um Dir das Schreiben angenehmer zu einfacher zu machen, setzt die Sharebase auf <a href="http://daringfireball.net/projects/markdown/">Markdown</a>, mit dem du deine Texte einfach formatieren kannst. Lies dir dabei am Besten die <a href="markdown.php">Anleitung und Tipps f&uuml;r die Verwendeung von Markdown</a> durch. Du wirst begeistert sein!<br />
    <br />
    <span class="question">Wer ist f&uuml;r diesen Bullshit verantwortlich?</span><br />
    <span class="answer">
    Programmierung und Design: <a href="https://twitter.com/#!/janh97">Jan Hassel (@janh97)</a> <a href="mailto:jan@sharebase.eu">(Mail)</a><br />
    Design und allgemeine Awesomeness: <a href="https://twitter.com/#!/KaWie">Kai Wieland (@KaWie)</a> <a href="mailto:kai@sharebase.eu">(Mail)</a><br />
    Programmierung: <a href="https://twitter.com/#!/Der_Hutt">Jannis Hutt (@Der_Hutt)</a> <a href="mailto:jannis@sharebase.eu">(Mail)</a></span><br />
    
    <br /><span style="color:#ccc;font-size:10pt;font-style:italic;">Sharebase Open Beta 0.9 &middot; <a href="http://sharebase.eu">Sharebase.eu</a> &middot; <a href="http://github.com/Sharebase">Sharebase on GitHub</a></span>
  </div>
 </div>
</body>
</html>