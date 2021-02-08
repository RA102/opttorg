<?php
$dir = "images/photos/small/";

// Открыть заведомо существующий каталог и начать считывать его содержимое
if (is_dir($dir)) {
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
           print "Файл: $file  blabla <br />";
       }
       closedir($dh);
   }
} else { echo 'nodir'; }
