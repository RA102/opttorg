<?php

define('PATH', dirname(__FILE__));

include_once PATH . '/includes/PhpSpreadsheet/Spreadsheet.php';

$pathToFile = PATH . '/tmp/ra_lebedev@mail.ru/Comforty.xls';

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($pathToFile);
$reader->setReadDataOnly(true);
$reader->setReadFilter(new MyReadFilter(21, 224, range('B', ''))
$spreadsheet = $reader->load($pathToFile);

$cells = $spreadsheet->getActiveSheet()->getCellCollection();

for ($row=21; $row <= $cells->getHighestRow(); $row++) {
    for($col= )
}


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
                $sheetExcelFile->getStyle("$column")->getNumberFormat()->setFormatCode('#.##0');
                $valueColumn[$value] = $sheetExcelFile->getCell("$column$i")->getValue();
                //$valueColumn[$value] = $definiteExcelFile->getActiveSheet()->getCellByColumnAndRow($index, $i)->getValue();
                break;
            case 'qty_from_vendor':
                $sheetExcelFile->getCell("$column$i")->setDataType(TYPE_NUMERIC);
                $valueColumn[$value] = $definiteExcelFile->getActiveSheet()->getCellByColumnAndRow($index, $i)->getValue();
                break;
            default:
                $sheetExcelFile->getCell("$column$i")->setDataType();
                $sheetExcelFile->getCellByColumnAndRow($index, $i, false)->set
                $valueColumn[$value] = $sheetExcelFile->getCellByColumnAndRow($index, $i)->getValue();    //getCell("$column$i")->getValue();
        }

        $styles = $definiteExcelFile->setActiveSheetIndex(0)->getStyles();
    }

}

var_dump('<pre>', $valueColumn, '</pre>');
