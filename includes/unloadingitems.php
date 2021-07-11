<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log' . PHP_EOL, __DIR__ . '/../log/error_unloadingitems_.log');


if(!defined('VALID_CMS')) {
    define('VALID_CMS', 1);
}

include_once __DIR__ .'/../core/cms.php';



$dir = '/cache/';
$filename = 'import.xml';

cmsCore::loadModel('shop');
$model = new cms_model_shop();

if (file_exists( __DIR__ . '/../'. $dir . $filename)) {

    $z = new XMLReader;
    $errorOpen = $z->open(__DIR__ . '/../' . "/cache/import.xml");

    $z->read();

//    try {
//        $xmlProducts = new SimpleXMLElement($z->readString());
//        $xpath = $xmlProducts->xpath('Товары');
//    } catch (Exception $e) {
//        die($e->getMessage());
//    }

    while ($z->read() && $z->name !== 'Товары') ;

    $current_product_num = 0;

    $xml = new SimpleXMLIterator($z->readOuterXML());

    try {
        for ($i = 0; $i <= $xml->count(); $i++) {
            import_product($xml->Товар[$i]);
            $current_product_num++;
            throw new Exception($current_product_num);
        }
    } catch(Exception $exception) {
        echo $exception->getMessage(), '\n';
    }
    $z->close();

    $sql = "UPDATE cms_shop_items SET sorting = CASE WHEN 'qty' > 1 OR 'qty_from_vendor' > 1 THEN 1 ELSE 0 END";

    cmsDatabase::getInstance()->query($sql);

} else {

    echo "Нет файла export.xml";
}


function import_product($xml_product)
{

    try {

        $item = [];

        $instanceDb = cmsDatabase::getInstance();

        $artNo = trim($xml_product->Артикул);


        if ($artNo) {

//            $sql = "SELECT id FROM cms_shop_items WHERE art_no LIKE ?";
            $sql = "SELECT id FROM cms_shop_items WHERE art_no LIKE \"$artNo\"";
//            $product_id = $instanceDb->prepareSql($sql, $artNo);
            $result = $instanceDb->query($sql);
            if ($instanceDb->num_rows($result)) {
                $product_id = $instanceDb->fetch_assoc($result);
            }

        } else {
            return;
        }

    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
    if ( empty($product_id['id']) || is_null($product_id['id'])) {

        $item['category_id'] = 10991;
        $item['art_no'] = (string)$xml_product->Артикул;
        $item['title'] = $instanceDb->escape_string((string)$xml_product->Наименование);
        $item['published'] = 0;
        $item['price'] = $xml_product->Стоимость;
        $item['pubdate'] = date('Y-m-d');
        $item['qty'] = $xml_product->КоличествоОстаток;
        $item['tpl'] = 'com_inshop_item.tpl';
        $item['external_id'] = (string)$xml_product->Ид;

        $lastIdInTable = $instanceDb->insert('cms_shop_items', $item);
        $sql = "SELECT MAX(ordering) FROM cms_shop_items_cats";

        $result = $instanceDb->query($sql);

        if ($instanceDb->num_rows($result)){
            $maxNumberColumnOrdering = $instanceDb->fetch_assoc($result);
        }

        $thisItem['item_id'] = $lastIdInTable;
        $thisItem['category_id'] = 10991;
        $thisItem['ordering'] = $maxNumberColumnOrdering['MAX(ordering)'] + 1;

        $instanceDb->insert('cms_shop_items_cats', $thisItem);

    } else {

        // TODO переделать не нравится
        $sql = "SELECT old_price FROM cms_shop_items WHERE id = {$product_id['id']}";

        $result = $instanceDb->query($sql);

        if($instanceDb->num_rows($result)) {
            $oldPrice = $instanceDb->fetch_row($result);
        }

        if (!(int)$oldPrice[0]) {
            $item['price'] = (int)$xml_product->Стоимость;
            $item['qty'] = (int)$xml_product->КоличествоОстаток;
            $item['update_at'] = date('Y-m-d H:i:s');
            $instanceDb->update('cms_shop_items', $item, $product_id['id']);
        } else {
            $item['qty'] = (int)$xml_product->КоличествоОстаток;
            $item['old_price'] = (int)$xml_product->Стоимость;
            $item['update_at'] = date('Y-m-d H:i:s');
            $instanceDb->update('cms_shop_items', $item, $product_id['id']);

        }

    }

}