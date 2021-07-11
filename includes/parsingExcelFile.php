<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Almaty');


define('PATH', dirname(__DIR__, 1));

include_once 'phpexel/PHPExcel.php';
include_once PATH . '/core/classes/db.class.php';




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

$excel = PHPExcel_IOFactory::createReaderForFile(PATH . '/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');
$load = $excel->load(PATH . '/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');
$highestColumn = $load->setActiveSheetIndex(0)->getHighestColumn();
$highestRow = $load->setActiveSheetIndex(0)->getHighestRow();

/**
 * TODO
 * итерация по строкам с помощью for
 * загрузить настройки excel файла
 * инициализировать $i из настройки
 * максимальное значение  из $highestRow
 */

for ($i = 17; $i < $highestRow; $i++) {
    $venCode =
    $listItems = $load->getActiveSheet(0)->getCellByColumnAndRow(3, $i);

}

var_dump($load->getActiveSheet(0)->getCellByColumnAndRow(3, 17)->getValue());

//foreach ($load->setActiveSheetIndex(0)->getRowIterator() as $row) {
//    $cellIterator = $row->getCellIterator();
//
//
//    foreach ($cellIterator as $cell) {
//
//        var_dump($cell->getValue());
//    }
//}
//
//var_dump($highestColumn, $highestRow);


class parsingExcelFile
{
    protected $pathToFile;
    protected $startRow;
    protected $countRow;
    protected $column;
    protected $excel;

    /**
     * @throws PHPExcel_Reader_Exception
     */
    public function __construct($pathToFile, $startRow, $countRow, $column)
    {
        $this->pathToFile = $pathToFile;
        $this->startRow = $startRow;
        $this->countRow = $countRow;
        $this->column = $column;
    }

    public function instancePHPExcel()
    {
        $this->excel = PHPExcel_IOFactory::createReaderForFile($this->pathToFile);
    }

    public function parsingFileXls()
    {

    }

}