<?php
$filename = $_GET['f'];
$fileextension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$image = $fileextension == png || $fileextension == jpg || $fileextension == gif;
$markdown = $fileextension == md || $fileextension == mdown || $fileextension == text;
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="sources/markdown.css">
		<link rel="stylesheet" href="sources/rendering.css">
	</head>
	<body <? if($image) echo 'class="inverted"' ?>>
		<div id="head">
			<div id="logo">
			<a href="./"><span class="logo-share">Share</span><span class="logo-base">base</span></a><span class="filename"> &#8211; <? 
			if (file_exists('upload/'.$filename)) {
			echo $filename;
			} else {
			echo "404 not found";
			}
			?></span>
			</div>
		</div>
		<?php
		if(file_exists('upload/'.$filename)){
			if ($markdown) {
				include_once('sources/markdown.php');
				$lines = file_get_contents('upload/'.$filename);
				$rendered = Markdown(stripslashes($lines));
				echo $rendered;
			}
			if ($image) {
				echo '<a href="upload/'.$filename.'"><img src="upload/'.$filename.'" class="image"></a>';
			}
		} else {
			echo "Sorry, Datei nicht gefunden!";
		}
		?>
	</body>
</html>