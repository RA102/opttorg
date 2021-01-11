<?php
error_reporting(E_ALL);
//Error_Reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set("display_errors", "on");
if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
}

if (!defined('PATH')) {
    define('PATH', $_SERVER['DOCUMENT_ROOT']);
}

require_once '../includes/phpexel/PHPExcel.php';
require_once '../components/shop/model.php';

cmsCore::loadClass('shop');
cmsCore::request('do', 'str', 'view');

function applet_loadprices()
{
    global $_LANG;
    $inPage = cmsPage::getInstance();
    $do = cmsCore::request('do', 'str', '');
    $dir = PATH . '/cache/';



    if ($do == 'load' && $_FILES['load']['size'] && cmsUser::checkCsrfToken() ) {

        $makeup = $_POST['price'];

        $model = new cms_model_shop();

        $filesName = $_FILES['load']['name'];
        move_uploaded_file($_FILES['load']['tmp_name'], "$dir/$filesName");


        $exel = PHPExcel_IOFactory::load("$dir/$filesName");

        $exel->setActiveSheetIndex(0);

        $lists = [];


//            foreach ($exel->getWorksheetIterator() as $worksheet) {
//                $lists = $worksheet->toArray();
//            }

        $lists = $exel->getActiveSheet()->toArray();
        $inDb = cmsDatabase::getInstance();
        $itemUpdate = 0;
        $itemInsert = 0;

        $root = $_SERVER['DOCUMENT_ROOT'];

        foreach ($lists as $key => $item) {

            $array['ven_code'] = trim($item[0]);
            $array['title'] = trim($item[1]);
            $pattern = $array['ven_code'];
            $array['title'] = preg_replace("/{$pattern}/", '', $array['title']);
            $array['title'] = preg_replace("/[()]/", '', $array['title']);
            $array['title'] = quotemeta($array['title']);
            $array['title'] = $inDb->escape_string($array['title']);
            $array['price'] = preg_replace('/\s/', '.', $item[2]);
            $number = number_format($array['price'], 0, ',', '');

            $array['qty_from_vendor'] = preg_replace('/[^0-9]+/', '', $item[3]);

            if (!array_key_exists(3, $item)) {
                $array['qty_from_vendor'] = 10000;
            }

            if ($array['ven_code']) {

                $idItemInDb = $inDb->get_field('cms_shop_items', "ven_code = '{$array['ven_code']}'", 'id');
                if ($idItemInDb) {
                    $arr = [];
//                    unset($array['title']);
//                    unset($array['ven_code']);
                    $arr['price'] = $array['price'];
                    $arr['qty_from_vendor'] = $array['qty_from_vendor'];


                    $inDb->update('cms_shop_items', $arr, $idItemInDb);
                    $itemUpdate++;

                } else {

                    $arrayWithCategory = [];

                    $arrayWithCategory = $array;
                    $arrayWithCategory['category_id'] = 11039;


                    $idInsertedItem = $inDb->insert('cms_shop_items', $arrayWithCategory);

                    $inDb->insert('cms_shop_items_cats', ['item_id' => $idInsertedItem, 'category_id' => $arrayWithCategory['category_id'], 'ordering' => 1]);

                    $itemInsert++;
                    $row++;
                }

            } else {
                $unloaded[] = $item;
            }
        }

        cmsCore::redirectBack();

    }


    if ( $do == 'checked' && $_FILES['load']['size'] ) {

        $tmp_name = $_FILES['load']['tmp_name'];

        $filesName = $_FILES['load']['name'];

        move_uploaded_file($_FILES['load']['tmp_name'], $dir."$filesName");

        $exel = PHPExcel_IOFactory::load($dir."$filesName");

        $exel->setActiveSheetIndex(0);

        $sheet = $exel->getActiveSheet();

        $lists = $exel->getActiveSheet()->toArray();
        $inDb = cmsDatabase::getInstance();

        $result = [];

        foreach ($lists as $key => $item) {
            $venCode = trim($item[0]);
            if ($venCode == "") {
                continue;
            }

            $countRow = $inDb->rows_count('cms_shop_items', "ven_code LIKE '$venCode'");
//            $sql = "SELECT COUNT(*) FROM cms_shop_items WHERE 'ven_code' LIKE '$venCode'";
//            $countRow = $inDb->query($sql);

            if ($countRow > 1) {
                $array[0] = $venCode;
                $array[1] = $countRow;
                array_push($result, $array);
                continue;
//                $inDb->delete('cms_shop_')
            }
        }

        /*
         * Запись в файл
         */
        if (!file_exists($dir.'checked.xls')) {
            $document = new PHPExcel();
            $objWriter = PHPExcel_IOFactory::createWriter($document, 'Excel5');
            $objWriter->save($dir.'checked.xls');
        }
        $file = PHPExcel_IOFactory::load($dir.'checked.xls');

        $exel2 =  $file->setActiveSheetIndex(0);

        foreach ($result as $row => $item) {
            foreach ($item as $col => $it) {
                $exel2->setCellValueByColumnAndRow($col, $row, $it);
            }
        }

        $obj = new PHPExcel_Writer_Excel2007($file);
        $obj->save($dir.'checked.xls');

//        }

    }

    if ($do == 'fixed') {

        $exel = PHPExcel_IOFactory::load($dir.'checked.xls');

        $exel->setActiveSheetIndex(0);

        $lists = [];
        $res = [];

        $lists = $exel->getActiveSheet()->toArray();
        $inDb = cmsDatabase::getInstance();

        foreach ($lists as $key => $item) {
            $delResult = $inDb->delete('cms_shop_items', "ven_code LIKE '{$item[0]}' AND category_id = 11039");
            /*
             * Запись результата удаления с данными
             */
            array_push($res, [$item[0], $delResult]);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($exel, 'Excel5');
        $objWriter->save($dir.'fixed.xls');

        $exel = PHPExcel_IOFactory::load($dir.'fixed.xls');
        $fil = $exel->setActiveSheetIndex(0);
        foreach ($res as $row => $value) {
            foreach ($value as $col => $item) {
                $fil->setCellValueByColumnAndRow($col, $row, $item);
            }
        }

        $obj = new PHPExcel_Writer_Excel2007($exel);
        $obj->save($dir. 'fixed.xls');
    }

    if ($do == 'create') {

        if (file_exists($dir.'checked.xls')) {
            unlink($dir.'checked.xls');
        }
        $document = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($document, 'Excel5');
        $objWriter->save($dir."checked.xls");
    }


    ?>
    <table class="table table-bordered" style="max-width: 600px;">
        <thead>
        <tr>
            <th>Артикул</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
        </tr>
        </thead>
    </table>
    <div>
        <ul>
            <li>Поверить кол-во столбцов</li>
            <li>Удалить заголовки</li>
            <li>Убрать разделитель групп разрядов</li>
        </ul>
    </div>

    <form action="index.php?view=loadprices" method="post" enctype="multipart/form-data" name="addform" id="addform">
        <input type="hidden" name="csrf_token" value="<?php echo cmsUser::getCsrfToken(); ?>"/>
        <table width="750" border="0" cellpadding="0" cellspacing="10" class="proptable">
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="defaultCheck2" name="price">
                        <label class="form-check-label" for="defaultCheck2">
                            Подгружать цену
                        </label>
                    </div>
                </td>

            </tr>
            <tr>
                <td width="300" valign="middle">
                    <strong><?php echo $_LANG['FILE_NAME']; ?>:</strong> <input name="load" type="file" value=""/><br/>
                </td>
            </tr>
        </table>
        <p>
            <input name="do" type="hidden" id="load" value="load"/>
            <input name="add_mod" type="submit" id="add_mod" value="<?php echo $_LANG['LOADING']; ?>"/>
            <span style="margin-top:15px">
                <input name="back2" type="button" id="back2" value="<?php echo $_LANG['CANCEL']; ?>"
                       onclick="window.history.back();"/>
            </span>
        </p>

<!--        <p>-->
<!---->
<!--            <input name="do" type="submit" value="checked" />-->
<!--        </p>-->
<!--        <p>-->
<!--            <input name="do" type="submit" value="fixed" />-->
<!--        </p>-->
<!--        <p>-->
<!--            <input name="do" type="submit" id="create" value="create" />-->
<!--        </p>-->
    </form>

<?php } ?>

