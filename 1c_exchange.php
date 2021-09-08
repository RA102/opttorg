<?php
ini_set('display_errors', 0);
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

if (!defined('PATH')){
    define('PATH', __DIR__);
}
define("VALID_CMS", 1);

require_once PATH . '/core/cms.php';


$dir = 'cache/';

$_SESSION['brand_option_name'] = 'Производитель';
$_SESSION['brand_option_id'] = '';

$start_time = microtime(true);
$max_exec_time = @ini_get("max_execution_time");

if (empty($max_exec_time)) {
    $max_exec_time = 300;
}

session_start();


cmsCore::getInstance();
cmsCore::loadClass('user');

$type = cmsCore::request('type', 'str', '');
$mode = cmsCore::request('mode', 'str', '');
$filename = cmsCore::request('filename', 'str', '');

if (!$type || !$mode) {
    cmsCore::error404();
}

cmsCore::loadModel('shop');
$model = new cms_model_shop();

if ($type == 'sale') {
    if ($type == 'sale' && $mode == 'checkauth') {
        print "success\n";
        print session_name() . "\n";
        print session_id();
    }

    if ($type == 'sale' && $mode == 'init') {
        $tmp_files = glob($dir . '*.*');
        if (is_array($tmp_files)) {
            foreach ($tmp_files as $v) {
                /* unlink($v); */
            }
        }
        print "zip=no\n";
        print "file_limit=1000000\n";
    }

    if ($type == 'sale' && $mode == 'file') {

        $f = fopen($dir . $filename, 'ab');
        fwrite($f, file_get_contents('php://input'));
        fclose($f);

        $xml = simplexml_load_file($dir . $filename);

        foreach ($xml->Документ as $xml_order) {
            $order = array();

            $order['id'] = (int) $xml_order->Номер;

            $existed_order = $model->getOrder(intval($order['id']));

            $order['date_create'] = (string) $xml_order->Дата . ' ' . (string) $xml_order->Время;
            $order['customer_name'] = (string) $xml_order->Контрагенты->Контрагент->Наименование;

            if (isset($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита)) {
                foreach ($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита as $r) {
                    switch ($r->Наименование) {
                        case 'Проведен':
                            $proveden = ($r->Значение == 'true');
                            break;
                        case 'ПометкаУдаления':
                            $udalen = ($r->Значение == 'true');
                            break;
                    }
                }
            }

            if ($udalen) {
                $order['status'] = 3;
            } elseif ($proveden) {
                $order['status'] = 3;
            } elseif (!$proveden) {
                $order['status'] = 1;
            }

            if ($existed_order) {
                cmsDatabase::getInstance()->update('cms_shop_orders', $order, $existed_order['id']);
            } else {
                $order['d_type'] = 0;
                $order['d_summ'] = 0;
                $order['giftcode'] = '';
                $order['secret_key'] = md5(session_id());
                $order['customer_org'] = '';
                $order['customer_inn'] = '';
                $order['customer_phone'] = '';
                $order['customer_email'] = '';
                $order['customer_address'] = '';
                $order['customer_comment'] = '';

                $order['id'] = $model->addOrder($order);
            }

            $purchases_ids = array();
            $purchase = array();
            foreach ($xml_order->Товары->Товар as $xml_product) {
                $product_1c_id = $variant_1c_id = '';
                @list($product_1c_id, $variant_1c_id) = explode('#', $xml_product->Ид);
                if (empty($product_1c_id)) {
                    $product_1c_id = '';
                }
                if (empty($variant_1c_id)) {
                    $variant_1c_id = '';
                }

                $product_id = cmsDatabase::getInstance()->get_field('cms_shop_items', 'external_id="' . (string) $product_1c_id . '"', 'id');
                $variant_id = cmsDatabase::getInstance()->get_field('cms_shop_items_bind', 'external_id="' . (string) $variant_1c_id . '" AND item_id=' . $product_id, 'art_no');

                $item['title'] = (string) $xml_product->Наименование;
                $item['art_no'] = (string) $xml_product->Артикул;
                $item['qty'] = 0;
                $item['cart_qty'] = (int) $xml_product->Количество;
				
				//$thepr = (float) $xml_product->ЦенаЗаЕдиницу;
				//$thepr = ($thepr*95)/100;
                //$item['price'] = $thepr;


                $item['price'] = (float) $xml_product->ЦенаЗаЕдиницу;
				
				
                $item['seolink'] = '';				
                //$item['chars'] = null;
                $item['is_digital'] = 0;
                $item['filename_item'] = '';
                $item['filename_orig'] = '';
                $item['category_id'] = 1;
                $item['filename'] = '';
                if (isset($xml_product->Скидки->Скидка)) {
                    $discount = $xml_product->Скидки->Скидка->Процент;
                    $item['price'] = round($item['price'] * (100 - $discount) / 100, 2);
                }

                $item['totalprice'] = $item['price'] * $item['cart_qty'];
                $purchase[] = $item;
            }

            $order['items'] = cmsCore::getInstance()->ArrayToYaml($purchase);

            if ($existed_order) {
                cmsDatabase::getInstance()->update('cms_shop_orders', $order, $existed_order['id']);
            } else {
                cmsDatabase::getInstance()->update('cms_shop_orders', $order, $order['id']);
            }
        }

        print "success";

    }

    if ($type == 'sale' && $mode == 'query') {
        $no_spaces = '<?xml version="1.0" encoding="utf-8"?>
                            <КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date('Y-m-d') . '"></КоммерческаяИнформация>';
        $xml = new SimpleXMLElement($no_spaces);

        $orders = $model->getOrders();
        foreach ($orders as $order) {
            $date = new DateTime($order['date_create']);

            $doc = $xml->addChild("Документ");
            $doc->addChild("Ид", $order['id']);
            $doc->addChild("Номер", $order['id']);
            $doc->addChild("Дата", $date->format('Y-m-d'));
            $doc->addChild("ХозОперация", "Заказ товара");
            $doc->addChild("Роль", "Продавец");
            $doc->addChild("Курс", "1");
            $doc->addChild("Сумма", $order['total_price']);
            $doc->addChild("Время", $date->format('H:i:s'));
            $doc->addChild("Комментарий", $order['customer_comment'] . ' / ' . $order['comment']);

            $k1 = $doc->addChild('Контрагенты');
            $k1_1 = $k1->addChild('Контрагент');
            $k1_2 = $k1_1->addChild("Ид", $order['customer_name']);
            $k1_2 = $k1_1->addChild("Наименование", $order['customer_name']);
            $k1_2 = $k1_1->addChild("Роль", "Покупатель");
            $k1_2 = $k1_1->addChild("ПолноеНаименование", $order['customer_name']);

            $addr = $k1_1->addChild('АдресРегистрации');
            $addr->addChild('Представление', $order['customer_address']);
            $addrField = $addr->addChild('АдресноеПоле');
            $addrField->addChild('Тип', 'Страна');
            $addrField->addChild('Значение', 'RU');
            $addrField = $addr->addChild('АдресноеПоле');
            $addrField->addChild('Тип', 'Регион');
            $addrField->addChild('Значение', $order['customer_address']);

            $contacts = $k1_1->addChild('Контакты');
            $cont = $contacts->addChild('Контакт');
            $cont->addChild('Тип', 'Телефон');
            $cont->addChild('Значение', $order['customer_phone']);
            $cont = $contacts->addChild('Контакт');
            $cont->addChild('Тип', 'Почта');
            $cont->addChild('Значение', $order['customer_email']);

            $t1 = $doc->addChild('Товары');
            foreach ($order['items'] as $purchase) {
                if (!empty($purchase['item_id'])) {
                    $id_p = cmsDatabase::getInstance()->get_field('cms_shop_items', 'id=' . $purchase['item_id'], 'external_id');
                    if (!empty($id_p)) {
                        $id = $id_p;
                    } else {
                        cmsDatabase::getInstance()->update('cms_shop_items', array('external_id' => $purchase['item_id']), $purchase['item_id']);
                        $id = $purchase['item_id'];
                    }

                    $t1_1 = $t1->addChild('Товар');

                    if ($id) {
                        $t1_2 = $t1_1->addChild("Ид", $id);
                    }

                    $t1_2 = $t1_1->addChild("Артикул", $purchase['art_no']);

                    $name = $purchase['title'];
                    $t1_2 = $t1_1->addChild("Наименование", $name);
                    $t1_2 = $t1_1->addChild("ЦенаЗаЕдиницу", $purchase['price']);
                    $t1_2 = $t1_1->addChild("Количество", $purchase['cart_qty']);
                    $t1_2 = $t1_1->addChild("Сумма", $purchase['totalprice']);

                    $t1_2 = $t1_1->addChild("Скидки");
                    $t1_3 = $t1_2->addChild("Скидка");
                    $t1_4 = $t1_3->addChild("Сумма", $purchase['price'] * $order['discount'] / 100);
                    $t1_4 = $t1_3->addChild("УчтеноВСумме", "false");

                    $t1_2 = $t1_1->addChild("ЗначенияРеквизитов");
                    $t1_3 = $t1_2->addChild("ЗначениеРеквизита");
                    $t1_4 = $t1_3->addChild("Наименование", "ВидНоменклатуры");
                    $t1_4 = $t1_3->addChild("Значение", "Товар");

                    $t1_2 = $t1_1->addChild("ЗначенияРеквизитов");
                    $t1_3 = $t1_2->addChild("ЗначениеРеквизита");
                    $t1_4 = $t1_3->addChild("Наименование", "ТипНоменклатуры");
                    $t1_4 = $t1_3->addChild("Значение", "Товар");
                }
            }

            if ($order['d_price'] > 0) {
                $t1 = $t1->addChild('Товар');
                $t1->addChild("Ид", 'ORDER_DELIVERY');
                $t1->addChild("Наименование", 'Доставка');
                $t1->addChild("ЦенаЗаЕдиницу", $order['d_price']);
                $t1->addChild("Количество", 1);
                $t1->addChild("Сумма", $order['d_price']);
                $t1_2 = $t1->addChild("ЗначенияРеквизитов");
                $t1_3 = $t1_2->addChild("ЗначениеРеквизита");
                $t1_4 = $t1_3->addChild("Наименование", "ВидНоменклатуры");
                $t1_4 = $t1_3->addChild("Значение", "Услуга");

                $t1_2 = $t1->addChild("ЗначенияРеквизитов");
                $t1_3 = $t1_2->addChild("ЗначениеРеквизита");
                $t1_4 = $t1_3->addChild("Наименование", "ТипНоменклатуры");
                $t1_4 = $t1_3->addChild("Значение", "Услуга");

            }

            if ($order['status'] == 1) {
                $s1_2 = $doc->addChild("ЗначенияРеквизитов");
                $s1_3 = $s1_2->addChild("ЗначениеРеквизита");
                $s1_3->addChild("Наименование", "Статус заказа");
                $s1_3->addChild("Значение", "[N] Принят");
            }

            if ($order['status'] == 2) {
                $s1_2 = $doc->addChild("ЗначенияРеквизитов");
                $s1_3 = $s1_2->addChild("ЗначениеРеквизита");
                $s1_3->addChild("Наименование", "Статус заказа");
                $s1_3->addChild("Значение", "[F] Оплачен");
            }

            if ($order['status'] == 3) {
                $s1_2 = $doc->addChild("ЗначенияРеквизитов");
                $s1_3 = $s1_2->addChild("ЗначениеРеквизита");
                $s1_3->addChild("Наименование", "Закрыт");
                $s1_3->addChild("Значение", "[C] Закрыт");
            }
        }

        header("Content-type: text/xml; charset=utf-8");
        print "\xEF\xBB\xBF";

        print $xml->asXML();
    }

    if ($type == 'sale' && $mode == 'success') {
        $last_1c_orders_export_date = date("Y-m-d H:i:s");
    }
}

if ($type == 'catalog') {

    if ($type == 'catalog' && $mode == 'checkauth') {
        print "success\n";
        print session_name() . "\n";
        print session_id();
    }

    if ($type == 'catalog' && $mode == 'init') {
        $tmp_files = glob($dir . '*.*');
        if (is_array($tmp_files)) {
            foreach ($tmp_files as $v) {
                unlink($v);
            }
        }
        unset($_SESSION['last_1c_imported_variant_num']);
        unset($_SESSION['last_1c_imported_product_num']);
        unset($_SESSION['features_mapping']);
        unset($_SESSION['categories_mapping']);
        unset($_SESSION['brand_id_option']);
        print "zip=no\n";
        print "file_limit=100000000\n";
    }

    if ($type == 'catalog' && $mode == 'file') {
        $filename = basename($filename);
        $f = fopen($dir . $filename, 'ab');
        fwrite($f, file_get_contents('php://input'));
        fclose($f);
        print "success\n";
    }

    if ($type == 'catalog' && $mode == 'import') {
        if ($filename === 'import.xml') {
//            if (!isset($_SESSION['last_1c_imported_product_num'])) {
//                $z = new XMLReader;
//                $z->open(__DIR__ . '/' . $dir . $filename);
//                while ($z->read() && $z->name !== 'Классификатор');
//                $xml = new SimpleXMLElement($z->readOuterXML());
//                $z->close();
                //import_categories($xml);
                //import_features($xml);
//            }

            $z = new XMLReader;
            $z->open($dir . $filename);

            while ($z->read() && $z->name !== 'Товар');

            $last_product_num = 0;
            if (isset($_SESSION['last_1c_imported_product_num'])) {
                $last_product_num = $_SESSION['last_1c_imported_product_num'];
            }
            $current_product_num = 0;

            while ($z->name === 'Товар') {
                if ($current_product_num >= $last_product_num) {
                    $xml = new SimpleXMLElement($z->readOuterXML());

//                    import_product($xml);

                    $exec_time = microtime(true) - $start_time;
                    if ($exec_time + 1 >= $max_exec_time) {
                        header("Content-type: text/xml; charset=utf-8");
                        print "\xEF\xBB\xBF";
                        print "progress\r\n";
                        print "Выгружено товаров: $current_product_num\r\n";
                        $_SESSION['last_1c_imported_product_num'] = $current_product_num;
                        exit();
                    }
                }
                $z->next('Товар');
                $current_product_num++;

            }
            $z->close();
            print "success\r\n";
            unset($_SESSION['last_1c_imported_product_num']);
            if($current_product_num) {
                include_once PATH . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'LoadItemXml.php';
                $pathToFile = PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'import.xml';
                $loadItemXmlInstance = new LoadItemXml($pathToFile);
                $loadItemXmlInstance->importProduct();
            }
        } elseif ($filename === 'offers.xml') {
            $z = new XMLReader;
            $z->open($dir . $filename);

            while ($z->read() && $z->name !== 'Предложение');
            $last_variant_num = 0;
            if (isset($_SESSION['last_1c_imported_variant_num'])) {
                $last_variant_num = $_SESSION['last_1c_imported_variant_num'];
            }

            $current_variant_num = 0;

            while ($z->name === 'Предложение') {
                if ($current_variant_num >= $last_variant_num) {
                    $xml = new SimpleXMLElement($z->readOuterXML());

                    import_variant($xml);

                    $exec_time = microtime(true) - $start_time;
                    if ($exec_time + 1 >= $max_exec_time) {
                        header("Content-type: text/xml; charset=utf-8");
                        print "\xEF\xBB\xBF";
                        print "progress\r\n";
                        print "Выгружено ценовых предложений: $current_variant_num\r\n";
                        $_SESSION['last_1c_imported_variant_num'] = $current_variant_num;
                        exit();
                    }
                }
                $z->next('Предложение');
                $current_variant_num++;
            }

            $z->close();
            print "success";
            unset($_SESSION['last_1c_imported_variant_num']);
        }
    }
}
#region function import_categories
/*
function import_categories($xml, $parent_id = 1)
{
    global $model;

    if (isset($xml->Группы->Группа)) {
        foreach ($xml->Группы->Группа as $xml_group) {
            $category_id = cmsDatabase::getInstance()->get_field('cms_shop_cats', 'external_id="' . (string) $xml_group->Ид . '"', 'id');
            if (empty($category_id)) {
                $cat['parent_id'] = $parent_id;
                $cat['external_id'] = strval($xml_group->Ид);
                $cat['title'] = strval($xml_group->Наименование);
                $cat['tpl'] = 'com_inshop_view.tpl';
                $cat['url'] = '';
                $cat['meta_desc'] = strval($xml_group->Наименование);
                $cat['meta_keys'] = strval($xml_group->Наименование);
                $cat['pagetitle'] = strval($xml_group->Наименование);
                $cat['description'] = '';
                $cat['published'] = 1;
                $cat['is_catalog'] = 0;
                $category_id = $model->addCategory($cat);
                cmsDatabase::getInstance()->update('cms_shop_cats', array('external_id' => $cat['external_id']), $category_id);
            }
            $_SESSION['categories_mapping'][strval($xml_group->Ид)] = $category_id;
            import_categories($xml_group, $category_id);
        }
    }

}
*/
#endregion
#region  function import_features
/*
function import_features($xml)
{
    global $model;
    global $brand_option_name;

    $property = array();
    if (isset($xml->Свойства->СвойствоНоменклатуры)) {
        $property = $xml->Свойства->СвойствоНоменклатуры;
    }

    if (isset($xml->Свойства->Свойство)) {
        $property = $xml->Свойства->Свойство;
    }

    foreach ($property as $xml_feature) {
        if ($xml_feature->Наименование == $_SESSION['brand_option_id']) {
            $_SESSION['brand_option_id'] = strval($xml_feature->Ид);
            foreach ($xml_feature->ВариантыЗначений->Справочник as $xml_vendor) {
                $vendor_id = cmsDataBase::getInstance()->get_field('cms_shop_vendors', 'external_id="' . strval($xml_vendor->ИдЗначения) . '"', 'id');
                if (!$vendor_id) {
                    $vendor_id = cmsDatabase::getInstance()->insert('cms_shop_vendors', array('title' => strval($xml_vendor->Значение), 'external_id' => strval($xml_vendor->ИдЗначения), 'published' => 1));
                }
                $_SESSION['features_val'][strval($xml_vendor->ИдЗначения)] = $vendor_id;
            }
        } else {
            $feature_id = cmsDatabase::getInstance()->get_field('cms_shop_chars', 'external_id="' . strval($xml_feature->Ид) . '"', 'id');

            $char_values = array();
            foreach ($xml_feature->ВариантыЗначений->Справочник as $xml_val) {
                $char_values[] = strval($xml_val->Значение);
            }

            $char_values = implode("\n", $char_values);

            if (!$feature_id) {
                $char['title'] = strval($xml_feature->Наименование);
                $char['units'] = '';
                $char['published'] = 1;
                $char['fieldtype'] = 'text';
                $char['is_custom'] = 0;
                $char['is_compare'] = 0;
                $char['is_filter'] = 0;
                $char['is_filter_many'] = 0;
                $char['bind_all'] = 1;
                $char['values'] = '';
                $char['cats'] = array();
                $char['fieldgroup'] = '';
                $char['values'] = $char_values;

                $feature_id = $model->addChar($char);
                cmsDatabase::getInstance()->update('cms_shop_chars', array('external_id' => strval($xml_feature->Ид)), $feature_id);
            } else {
                $char['values'] = $char_values;
                cmsDatabase::getInstance()->update('cms_shop_chars', $char, $feature_id);
            }

            $_SESSION['features_mapping'][strval($xml_feature->Ид)] = $feature_id;

        }
    }
}
*/
#endregion
function import_variant($xml_variant)
{
    $variant = null;

    @list($product_1c_id, $variant_1c_id) = explode('#', $xml_variant->Ид);
    if (empty($variant_1c_id)) {
        $variant_1c_id = '';
    }

foreach ($xml_variant->Цены->Цена as $value) {
	
    if ($value->ИдТипаЦены == '3475b900-064d-11e8-049b-001e67f53ada') { 
        $rozn = (float) $value->ЦенаЗаЕдиницу;
    }	
	
	// розн
    //if ($value->ИдТипаЦены == '3475b900-064d-11e8-049b-001e67f53ada') { 
    //    $rozn = (float) $value->ЦенаЗаЕдиницу;
    //}
	// опт
    //if ($value->ИдТипаЦены == 'e3f0b148-4bf2-11e6-bc9b-002522e4cd0e') {        
    //    $opt = (float) $value->ЦенаЗаЕдиницу;
    //}
	// круп опт
   // if ($value->ИдТипаЦены == 'e3f0b149-4bf2-11e6-bc9b-002522e4cd0e') {        
    //    $kropt = (float) $value->ЦенаЗаЕдиницу;
   // }
	// на реал
   // if ($value->ИдТипаЦены == 'e3f0b14a-4bf2-11e6-bc9b-002522e4cd0e') {        
   //     $nareal = (float) $value->ЦенаЗаЕдиницу;
   // }	
}		
	
	
    //$sql = 'UPDATE cms_shop_items SET price=' . $rozn . ', opt=' . $opt . ', kropt=' . $kropt . ', nareal=' . $nareal . ', qty=' . (int) $xml_variant->Количество . ' WHERE external_id="' . (string) $product_1c_id . '" LIMIT 1';
	
	$sql = "UPDATE `cms_shop_items` SET `price`='" . $rozn . "', `qty`='" . (int) $xml_variant->КоличествоОстаток . "' WHERE `external_id`='" . (string) $product_1c_id . "' LIMIT 1";
	
	// это после глюка на сервере $sql = "UPDATE cms_shop_items SET price=" . $rozn . ", qty=" . (int) $xml_variant->Количество . " WHERE external_id=" . (string) $product_1c_id . " LIMIT 1";
	
    cmsDatabase::getInstance()->query($sql);

    return true;
}
#region function importChars
/*
function importChars($product_id, $xml_product)
{

    if (!isset($xml_product->ЗначенияСвойств)) {
        return false;
    }

    foreach ($xml_product->ЗначенияСвойств->ЗначенияСвойства as $xml_property) {
        $id = strval($xml_property->Ид);

        if (isset($xml_property->Значение)) {
 
            if ($_SESSION['brand_option_id'] != $id) {

                $val = $_SESSION['features_val'][strval($xml_property->Значение)];

                $char_id = cmsDatabase::getInstance()
                    ->get_field('cms_shop_chars', 'external_id="' . $id . '"', 'id');

                if ($char_id && $val) {

                    $is_already = cmsDatabase::getInstance()
                        ->get_field('cms_shop_chars_val', 'item_id=' . $product_id . ' AND char_id=' . $char_id, 'item_id');

                    if (!$is_already) {
                        cmsDatabase::getInstance()
                            ->insert('cms_shop_chars_val', array('item_id' => $product_id, 'char_id' => $char_id, 'val' => $val));
                    } else {
                        cmsDatabase::getInstance()
                            ->query('UPDATE cms_shop_chars_val SET val="' . $val . '" WHERE item_id=' . $product_id . ' AND char_id=' . $char_id);
                    }
                }
            } else {
                $val = $_SESSION['features_val'][strval($xml_property->Значение)];
                cmsDatabase::getInstance()->update('cms_shop_items', array('vendor_id' => $val), $product_id);
            }
        }
    }

    return true;
}
*/
#endregion

function import_product($xml_product)
{

    global $model;
    global $dir;

    @list($product_1c_id, $variant_1c_id) = explode('#', $xml_product->Ид);

    if (empty($variant_1c_id)) {
        $variant_1c_id = '';
    }
/*
    if (isset($xml_product->Группы->Ид)) {
        $category_id = $_SESSION['categories_mapping'][strval($xml_product->Группы->Ид)];
    }
*/
    $variant_id = null;
    $variant = array();
    $values = array();

    if (isset($xml_product->ХарактеристикиТовара->ХарактеристикаТовара)) {
        foreach ($xml_product->ХарактеристикиТовара->ХарактеристикаТовара as $xml_property) {
            $values[] = $xml_property->Значение;
        }
    }

    if (!empty($values)) {
        $variant['name'] = implode(', ', $values);
    }

    $variant['art_no'] = (string) $xml_product->Артикул;
    $variant['external_id'] = $variant_1c_id;

    $product_id = cmsDatabase::getInstance()
        ->get_field('cms_shop_items', 'external_id="' . (string) $product_1c_id . '"', 'id');

    if (empty($product_id) && !empty($variant['art_no'])) {
        $res = cmsDatabase::getInstance()->get_fields('cms_shop_items_bind', 'art_no="' . $variant['art_no'] . '"', 'id,item_id');
        $product_id = $res['item_id'];
        $variant_id = $res['id'];
    }
	
	

    //if (empty($product_id)) {

    $description = '';
    if (!empty($xml_product->Описание)) {
        $description = $xml_product->Описание;
    }
/////////////////////// вооооооот тут

    if (isset($xml_product->ЗначенияРеквизитов->ЗначениеРеквизита)) {
		$vals = array();
        foreach ($xml_product->ЗначенияРеквизитов->ЗначениеРеквизита as $xml_prop) {
            $vals[] = $xml_prop->Значение;
        }
    }

    $item['vendor_id'] = 0;
    $item['art_no'] = (string) $xml_product->Артикул;
    $item['title'] = $vals[2];
   // $item['cats'] = array();
    $item['tpl'] = 'com_inshop_item.tpl';
    $item['url'] = ''; 

    $item['shortdesc'] = (string) $description;
   // $item['description'] = (string) $description;
    $item['metakeys'] = (string) $xml_product->Наименование;
    $item['metadesc'] = (string) $description;

    $item['is_comments'] = 0;
    $item['tags'] = '';
    $item['price'] = 0;
    $item['old_price'] = 0;
    $item['published'] = 1;
    $item['is_hit'] = 0;
    $item['is_front'] = 0;
    $item['is_digital'] = 0;

    $item['qty'] = $xml_product->КоличествоОстаток;

    if (empty($product_id)) {
		$item['category_id'] = 10991;
        $product_id = $model->addItem($item);
    } else {
		$category_id = cmsDatabase::getInstance() 
			->get_field('cms_shop_items', 'id="' . $product_id . '"', 'category_id');		
		$item['category_id'] = $category_id;
        $model->updateItemSin($product_id, $item);
    }
    cmsDatabase::getInstance()
        ->update('cms_shop_items', array('external_id' => $product_1c_id), $product_id);

    $cfg = $model->getConfig();


    if ($xml_product->Статус == 'Удален') {
        $model->deleteItem($product_id);
    }
}