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
            $this->paramsParsingXls = json_decode(strval($params['params_xls']));
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

        for ($i = $this->startRow; $i < $this->finishRow; $i++) {
            foreach ($this->paramsParsingXls as $index => $value) {
                $valueColumn[$value] = $definiteExcelFile->setActiveSheetIndex(0)->getCell(strval($index . $i)); //->getCellByColumnAndRow($index, $i);
            }
            $this->writingInDatabase($valueColumn);
        }

    }

    public function writingInDatabase($arrayValue)
    {
        if (is_null($arrayValue['price']) || is_null($arrayValue['ven_code'])) {
            return;
        }
        $arrayValue['price'] += ($arrayValue['price'] * $this->margin);
        $query = "ven_code LIKE {$arrayValue['ven_code']}";
        $idItem = $this->instanceDb->get_field('cms_shop_items', $query, 'id');
        if ($idItem) {
            unset($arrayValue['title']);
            unset($arrayValue['ven_code']);
            $querySuccess = $this->instanceDb->update('cms_shop_items', $arrayValue, $idItem);
        } else {
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