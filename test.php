<?php

include_once __DIR__ . '/classes/LoadFilesInFolder.php';

$pathToFolder = 'tmp' . DIRECTORY_SEPARATOR;

$class = new LoadFilesInFolder($pathToFolder);


$folders = $class->getDirectioryUpdatedToday();



//foreach ($folders as $index => $folder) {
//    $filesFromDirectory = $class->getEntityInDirector($folder);
//    var_dump($filesFromDirectory);
//}
//$files = $class->isUpdateToday();

//var_dump('<pre>', $files, '</pre>');


//$folders = $class->getEntityInDirector();
//
//foreach ($folders as $index => $folder) {
//
//    $listFiles[$folder] = $class->getEntityInDirector($folder);
//
//}

