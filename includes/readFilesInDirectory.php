<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Almaty');

const VALID_CMS = 1;

define('PATH', dirname(__DIR__, 1));

include_once __DIR__ .'/../core/cms.php';
include_once __DIR__ . '/phpexel/PHPExcel.php';
include_once __DIR__ . '/../core/classes/db.class.php';
include_once __DIR__ . '/../core/classes/config.class.php';

//$instanceCore = cmsCore::getInstance();
//$instanceCfg = cmsConfig::getInstance();
$instanceDb = cmsDatabase::getInstance();


//var_dump(date('Y-m-d' , fileatime(PATH . '/tmp/ra_lebedev@mail.ru')));
//var_dump(mktime(date('Y-m-d', fileatime(PATH . '/tmp/ra_lebedev@mail.ru'))), mktime(date('Y-m-d')));
//, date('Y-m-d', time())

$pathCatalog = PATH . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

// получение списка каталогов
$listCatalogs = scandir($pathCatalog);

// удадение '.' и '..' из массива
unset($listCatalogs[array_search( '.', $listCatalogs)]);
unset($listCatalogs[array_search('..', $listCatalogs)]);

// перебор каталогов и получение даты изменения или создания каталога для определения в каком котологе были обновлены сегодня файлы
// ? возможно придется определять по файлам в каталоге

foreach ($listCatalogs as $catalog) {
    if (mktime(date('Y-m-d', filemtime($pathCatalog . $catalog))) == mktime(date('Y-m-d')) || mktime(date('Y-m-d', filectime($pathCatalog . $catalog))) == mktime(date('Y-m-d'))) {
        $listFilesWithPoints = [];
        $listFilesWithoutPoints = [];
        $listFilesWithPoints = scandir($pathCatalog . $catalog);
        unset($listFilesWithPoints[array_search( '.', $listFilesWithPoints)]);
        unset($listFilesWithPoints[array_search( '..', $listFilesWithPoints)]);
        $listFilesInDirectory[$catalog] = array_values($listFilesWithPoints);
    }

}



$sql = "SELECT * FROM cms_vendors_params vp JOIN cms_shop_vendors sv ON sv.id = vp.vendor_id WHERE sv.published = 1";
$result = $instanceDb->query($sql);
if ($instanceDb->num_rows($result)) {
    $listParamsVendors = $instanceDb->fetchAllFromArray($result);
}

$priceFiles = PATH . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $listParamsVendors[0]['email'] . DIRECTORY_SEPARATOR;

$handle = opendir($priceFiles);
$listFiles = [];

while (false !== ($file = readdir($handle))) {
    $file;
    $tmpCurrentFile = pathinfo($file);

    if (array_key_exists('extension', $tmpCurrentFile) && ($tmpCurrentFile['extension'] == 'xls' || $tmpCurrentFile['extension'] == 'xlsx')) {
        $listFiles[] = $tmpCurrentFile;
    }
}
closedir($handle);

$excel = PHPExcel_IOFactory::load('/tmp/V.Pakhomov@sanmarket.kz/radomir.xls');

foreach ($excel->getWorksheetIterator() as $index => $worksheet) {
    $lists[] = $worksheet->toArray();
}

foreach ($lists as $index => $list) {
    echo '<table border="1">';
    // Перебор строк
    foreach($list as $row){
        echo '<tr>';
        // Перебор столбцов
        foreach($row as $col){
            echo '<td>'.$col.'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
