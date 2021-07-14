<?php


class ParsingPriceFile
{
    public $phpExel;
    private $pathRoot;
    public $folderName;
    protected $fileName;
    protected $startRow;
    protected $finishRow = 0;
    protected $paramsParsingXls = [];
    protected $margin;
    protected $vendorId;
    protected $instanceDb;


    function __construct()
    {
        include_once PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'phpexel/PHPExcel.php';
        include_once PATH . '/core/classes/db.class.php';
        $this->instanceDb = cmsDatabase::getInstance();
        $this->pathRoot = dirname(__DIR__, 1);

    }


    /**
     * @throws PHPExcel_Reader_Exception
     */
    public function createFactory()
    {

        return PHPExcel_IOFactory::load($this->pathFile);

    }

    public function createReaderForFile($pathToFile)
    {
        return PHPExcel_IOFactory::createReaderForFile($pathToFile);
    }

    public function getParamsBrand($email, $filename)
    {
        $query = 'SELECT * FROM cms_vendors_params WHERE email LIKE "' . $email  .'%" AND name_xls LIKE "' . $filename[0] . '%"';
        $result = $this->instanceDb->query($query);
        if ($this->instanceDb->num_rows($result)) {
            $params = $this->instanceDb->fetch_assoc($result);
        }
//        $result = $this->instanceDb->get_table('cms_vendors_params', $queryWhere);

        if ($result) {
            $this->paramsParsingXls = json_decode($params['params_xls']);
            $this->folderName = $email;
            $this->fileName = join('.', $filename);
            $this->startRow = $params['row_start'];
            $this->finishRow = $params['row_count'];
            $this->margin = $params['margin'];
            $this->vendorId = $params['vendor_id'];
            return 0;
        } else {
            return 1;
        }
    }

    public function parsingFile()
    {
        $pathToFile = $this->pathRoot . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $this->folderName . DIRECTORY_SEPARATOR . $this->fileName;
        $factoryExcel = PHPExcel_IOFactory::createReaderForFile($pathToFile);
        $definiteExcelFile = $factoryExcel->load($pathToFile);

        if (is_null($this->finishRow) || $this->finishRow = 0) {
            $this->finishRow = $definiteExcelFile->setActiveSheetIndex(0)->getHighestRow();
        }

        $activeSheet = $definiteExcelFile->getActiveSheet();
//        $arrayFromFileXsl = $definiteExcelFile->getActiveSheet()->toArray();



//        for ($i = $this->startRow; $i < $this->finishRow; $i++) {
//            foreach ($this->paramsParsingXls as $index => $value) {
//                $valueColumn[$value] = trim($arrayFromFileXsl[$i][$index - 1]);  // getCellByColumnAndRow($index, $i);
//            }
//            $this->writingInDatabase($valueColumn);
////            $this->writingInDatabaseSqlite($valueColumn);
//        }

//        if (is_null($this->finishRow) || $this->finishRow = 0) {
//            $this->finishRow = $definiteExcelFile->setActiveSheetIndex(0)->getHighestRow();
//        }

//        $arrAlfabet = [
//            1 => 'A',
//            2 => 'B',
//            3 => 'C',
//            4 => 'D',
//            5 => 'E',
//            6 => 'F',
//            7 => 'G',
//            8 => 'H'
//        ];

        for ($i = $this->startRow; $i < $this->finishRow; $i++) {
            foreach ($this->paramsParsingXls as $index => $value) {
                switch ($value) {
                    case 'price':
                    case 'qty_from_vendor':
                        $valueColumns[$value] = PHPExcel_Style_NumberFormat::toFormattedString($activeSheet->getCellByColumnAndRow($index - 1, $i)->getValue(), PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        break;
                    default:
                        $valueColumns[$value] = trim($activeSheet->getCellByColumnAndRow($index - 1, $i)->getFormattedValue());
                }
            }
            $this->writingInDatabase($valueColumns);
        }

    }

    public function writingInDatabaseSqlite($arrayValue)
    {
        if (empty($arrayValue['price']) || empty($arrayValue['ven_code'])) {
            return;
        }
        $arrayValue['price'] = rtrim($arrayValue['price']);
        $arrayValue['price'] += $arrayValue['price'] * ($this->margin / 100);
        $query = "ven_code LIKE {$arrayValue['ven_code']}";
        $dbSqlite = new SQLite3('sopt1_2.sqlite');
        $query = "SELECT id FROM cms_shop_items WHERE ven_code LIKE \"{$arrayValue['ven_code']}\"";
        $result = $dbSqlite->query($query);
        if ($result) {
            $idItem = $result->fetchArray();
        } else {
            $idItem = false;
        }

        if ($idItem) {
            unset($arrayValue['title']);
            unset($arrayValue['ven_code']);

            $arrayValue['qty_from_vendor'] = rtrim($arrayValue['qty_from_vendor'], ',');

            $set = '';
            $where = "id = '$idItem' LIMIT 1";
            foreach ($arrayValue as $field => $value) {
                $set .= "{$field} = '{$value}',";
            }
            $set = rtrim($set, ',');

            $dbSqlite->query("UPDATE cms_shop_items SET {$set} WHERE $where");
            $dbSqlite->close();

        } else {
            $arrayValue['category_id'] = 10991;
            $arrayValue['published'] = 0;
            $arrayValue['pubdate'] = date('Y-m-d');
            $arrayValue['tpl'] = 'com_inshop_item.tpl';

            // формируем запрос на вставку в базу
            foreach ($arrayValue as $field => $value) {
                $set .= "{$field} = '{$value}',";
            }
            // убираем последнюю запятую
            $set = rtrim($set, ',');

            $dbSqlite->query("INSERT INTO cms_shop_items SET {$set}");
            $dbSqlite->close();
        }

    }

    public function writingInDatabase($arrayValue)
    {
        if ( empty($arrayValue['ven_code']) || empty($arrayValue['price']) ) {
            return;
        }
        $arrayValue['qty_from_vendor'] = number_format($arrayValue['qty_from_vendor'], 0, ',', ' ');
        $arrayValue['price'] += $arrayValue['price'] * ($this->margin / 100);
        $arrayValue['qty_from_vendor'] = number_format($arrayValue['qty_from_vendor'], 0);
        $query = "ven_code LIKE \"{$arrayValue['ven_code']}\"";
        $idItem = $this->instanceDb->get_field('cms_shop_items', $query, 'id');
        if ($idItem) {
            unset($arrayValue['title']);
            unset($arrayValue['ven_code']);

            $querySuccess = $this->instanceDb->update('cms_shop_items', $arrayValue, $idItem);
        } else {
            $arrayValue['vendor_id'] = $this->vendorId;
            $arrayValue['price'] += $arrayValue['price'] * ($this->margin / 100);
            $arrayValue['title'] = trim($arrayValue['title']);
            $arrayValue['category_id'] = 10991;
            $arrayValue['published'] = 0;
            $arrayValue['pubdate'] = date('Y-m-d');
            $arrayValue['tpl'] = 'com_inshop_item.tpl';

            $querySuccess = $this->instanceDb->insert('cms_shop_items', $arrayValue);
        }
        return $querySuccess;
    }


}