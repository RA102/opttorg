<?php

$priceFiles = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

$handle = opendir($priceFiles);
$arrayFiles = [];

while (false !== ($arrayFiles[] = readdir($handle))) {
//    var_dump('<pre>', $file, '</pre>');


}


closedir($handle);


foreach ($arrayFiles as $index => $file) {
    echo $file . "<br />";

}