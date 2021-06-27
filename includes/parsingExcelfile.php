<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Almaty');

$path = dirname(__DIR__, 1);

include_once 'phpexel/PHPExcel.php';

//$excel = PHPExcel_IOFactory::load($path . '/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');

//var_dump('<pre>', $worksheet->getCellByColumnAndRow('D', '17'), '</pre>');
//foreach ($excel->getWorksheetIterator() as $index => $worksheet) {
//    $lists[] = $worksheet->toArray();
//    $row = $worksheet->getRowIterator(17);
//    var_dump($row->key());
//
//}


//var_dump('<pre>', $lists, '</pre>'); die;

//foreach ($lists as $index => $list) {
//    echo '<table border="1">';
//    // Перебор строк
//    foreach($list as $row){
//        echo '<tr>';
//        // Перебор столбцов
//        foreach($row as $col){
//            echo '<td>'.$col.'</td>';
//        }
//        echo '</tr>';
//    }
//    echo '</table>';
//}

$excel = PHPExcel_IOFactory::createReaderForFile($path . '/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');
$load = $excel->load($path . '/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');
$highestColumn = $load->setActiveSheetIndex(0)->getHighestColumn();
$highestRow = $load->setActiveSheetIndex(0)->getHighestRow();

foreach ($load->setActiveSheetIndex(0)->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();




    foreach ($cellIterator as $cell) {

        var_dump($cell->getValue());
    }
}

var_dump($highestColumn, $highestRow);