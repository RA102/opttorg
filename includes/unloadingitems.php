<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/../log/error_unloadingitems_.log');


if(!defined('VALID_CMS')) {
    define('VALID_CMS', 1);
}

include_once __DIR__ .'/../core/cms.php';
//error_reporting(E_ALL);
//error_log('error_log', '/log/error_unloadingitems.log');

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

    for ($i = 0; $i <= $xml->count(); $i++) {
        import_product($xml->Товар[$i]);
        $current_product_num++;
    }
    $z->close();

    $sql = "UPDATE cms_shop_items SET sorting = CASE WHEN 'qty' > 1 OR 'qty_from_vendor' > 1 THEN 1 ELSE 0 END";

    cmsDatabase::getInstance()->query($sql);

} else {

    echo "Нет файла export.xml";
}


function import_product($xml_product)
{
    $item = array();

    $artNo = strval($xml_product->Артикул);

    $instanceDb = cmsDatabase::getInstance();

    if ($artNo) {
        $product_id = $instanceDb->get_field('cms_shop_items', 'art_no=' . $artNo , 'id' );
    } else {
        return;
    }


    if (empty($product_id)) {
        $item['category_id'] = 10991;
        $item['art_no'] = (string)$xml_product->Артикул;
        $item['title'] = $instanceDb->escape_string((string)$xml_product->Наименование);
        $item['price'] = $xml_product->Стоимость;
        $item['published'] = 0;
        $item['pubdate'] = date('Y-m-d');
        $item['qty'] = $xml_product->КоличествоОстаток;
        $item['tpl'] = 'com_inshop_item.tpl';
        $item['external_id'] = (string)$xml_product->Ид;

        $sql = "INSERT INTO cms_shop_items (
                            `category_id`, 
                            `art_no`,
                            `title`, 
                            `price`, 
                            `published`,
                            `pubdate`,
                            `qty`,
                            `tpl`,
                            `external_id`)
				VALUES (
				        '{$item['category_id']}',
				        '{$item['art_no']}',
				        '{$item['title']}',
				        '{$item['price']}',
				        '{$item['published']}',
				         NOW(),
				        '{$item['qty']}',
				        '{$item['tpl']}', 
				        '{$item['external_id']}'
				)";
        $result = $instanceDb->query($sql);

    } else {

        $sql = "SELECT id FROM cms_shop_items WHERE id = {$product_id} AND old_price = 0";

        $result = $instanceDb->query($sql);

        if ($instanceDb->num_rows($result)) {
            $item['price'] = (int)$xml_product->Стоимость;
            $item['qty'] = (int)$xml_product->КоличествоОстаток;
            $item['update_at'] = date('Y-m-d H:i:s');
            $instanceDb->update('cms_shop_items', $item, $product_id);
        } else {

            $item['qty'] = (int)$xml_product->КоличествоОстаток;
            $item['update_at'] = date('Y-m-d H:i:s');
            $instanceDb->update('cms_shop_items', $item, $product_id);

        }

    }

}