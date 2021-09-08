<?php
if(!defined('VALID_CMS')) {
    define('VALID_CMS', 1);
}


include_once __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'LoadItemXml.php';

$pathToFile = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'import.xml';

$loadItemXmlInstance = new LoadItemXml($pathToFile);
//$class->iteratorXml();
//$product = $class->iteratorXml();
//while($product = $class->iteratorXml()) {
//    $class->importProduct($product);
//}
$loadItemXmlInstance->importProduct();
echo 'ok';

#region работает simplexml_load_file

//$xml = simplexml_load_file($pathToFile, 'SimpleXMLIterator');
//$attr = $xml->attributes();
//$items = ($xml->Каталог)->Товары;
//while($item = $items->Товар) {
//    var_dump($item->Артикул); die();
//}

//foreach($items as $index => $item) {
//    var_dump($item);
//}


//foreach ($items->Товар as $index => $item) {
//    echo $index . ": " . $item->Артикул . PHP_EOL;
//}

#endregion

//$xmlReader = new XMLReader();
//$isOpenFile = $xmlReader::open($pathToFile, 'UTF-8');
//
//$xmlIterator = new SimpleXMLIterator($isOpenFile->read());
//
//var_dump($xmlIterator->count()); die();
//$firstItem = $isOpenFile->read;
//
//var_dump($firstItem);
