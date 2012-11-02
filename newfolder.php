<?php
/*mkdir("./testomatiko", 0777);
chmod("./testomatiko", 0777);*/
touch("./test.php");
$file = fopen("./test.php", "a");
fwrite($file, "<?php 
echo 'Hallo Welt!'; 
?>");
fclose($file);
?>