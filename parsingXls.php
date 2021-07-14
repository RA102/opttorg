<?php

define('PATH', dirname(__FILE__));

include_once PATH . '/includes/phpexel/PHPExcel.php';
//include_once PATH . '/includes/PhpSpreadsheet/Spreadsheet.php';

$pathToFile = PATH . '/tmp/ra_lebedev@mail.ru/Comforty.xls';

$factoryExcel = PHPExcel_IOFactory::createReaderForFile($pathToFile);
$definiteExcelFile = $factoryExcel->load($pathToFile);
$definiteExcelFile->setActiveSheetIndex(0);
$sheetExcelFile = $definiteExcelFile->getActiveSheet();

//$arr = $sheetExcelFile->toArray(null, false,true);
//
//var_dump('<pre>', $arr, '</pre>');

$finishRow = $sheetExcelFile->getHighestRow();

$paramsParsingXls = json_decode('{"2":"title","3":"qty_from_vendor","4":"ven_code","8":"price"}');

$arrAlfabet = [
    1 => 'A',
    2 => 'B',
    3 => 'C',
    4 => 'D',
    5 => 'E',
    6 => 'F',
    7 => 'G',
    8 => 'H'
];

$definiteExcelFile->setActiveSheetIndex(0);

for ($i = 21; $i <= $finishRow; $i++) {
    foreach ($paramsParsingXls as $index => $value) {
        $column = $arrAlfabet[$index];
//        $sheet->setCellValueExplicit("A1", '1.', PHPExcel_Cell_DataType::TYPE_STRING);
//                $objPHPExcel->getActiveSheet()->getStyle('A9')->getNumberFormat()->setFormatCode('0');

        switch ($value) {
            case 'price':
//                $sheetExcelFile->getStyle("$column")->getNumberFormat()->setFormatCode('#.##0');
//                $valueColumn[$i][$value] = number_format($sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue(), 0, ',', '');
                $valueColumn[$i][$value] = PHPExcel_Style_NumberFormat::toFormattedString($sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                //$valueColumn[$value] = $definiteExcelFile->getActiveSheet()->getCellByColumnAndRow($index, $i)->getValue();
                break;
            case 'qty_from_vendor':
//              $sheetExcelFile->getCell("$column$i")->setDataType(TYPE_NUMERIC);
//                $valueColumn[$i][$value] =  $definiteExcelFile->getActiveSheet()->getCellByColumnAndRow($index - 1, $i)->getValue();
                $valueColumn[$i][$value] = PHPExcel_Style_NumberFormat::toFormattedString($sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                break;
            default:
//                $sheetExcelFile->getCell("$column$i")->setDataType('str');
//                $sheetExcelFile->getCellByColumnAndRow($index, $i, false)->getValue();
//                trim($sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue());    //getCell("$column$i")->getValue();
//                $sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
//                $sheetExcelFile->getCell("$column$index - 1")->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
//                $valueColumn[$i][$value] = $sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue()->get;
//                $valueColumn[$i][$value] = PHPExcel_Style_NumberFormat::toFormattedString($sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $valueColumn[$i][$value] = $formatted = $sheetExcelFile->getCellByColumnAndRow($index - 1, $i)->getFormattedValue();
        }

        $styles = $definiteExcelFile->setActiveSheetIndex(0)->getStyles();
    }

}

var_dump('<pre>', $valueColumn, '</pre>');