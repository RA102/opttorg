<?php

$priceFiles = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

$handle = opendir($priceFiles);
$tmpArray = [];

while (false !== ($file = readdir($handle))) {
    $tmpArray[] = pathinfo($file);
}


closedir($handle);


foreach ($tmpArray as $index => $item) {


}


//foreach ($arrayFiles as $index => $file) {
//    echo pathinfo($file . "<br />");
//
//}