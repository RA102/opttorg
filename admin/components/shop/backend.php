<?php
if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
}

function getField($table, $where, $field)
{
    $inDB = cmsDatabase::getInstance();
    return $inDB->get_field($table, $where, $field);
}

function getFields($table, $where, $fields)
{
    $inDB = cmsDatabase::getInstance();
    return $inDB->get_fields($table, $where, $fields);
}

function cpPriceInput($id)
{
    $price = getField('cms_shop_items', 'id=' . $id, 'price');
    $price = number_format($price, 2, '.', '');
    $html = '<input type="text" name="price[' . $id . ']" value="' . $price . '" id="priceinput" style="width:90%;border:none;border-bottom:solid 1px gray;text-align:right;"/>';
    return $html;
}

function spellcount($num, $one, $two, $many)
{
    if ($num % 10 == 1 && $num % 100 != 11) {
        echo $num . ' ' . $one;
    } elseif ($num % 10 >= 2 && $num % 10 <= 4 && ($num % 100 < 10 || $num % 100 >= 20)) {
        echo $num . ' ' . $two;
    } else {
        echo $num . ' ' . $many;
    }
}

$inCore = cmsCore::getInstance();
$inUser = cmsUser::getInstance();
$inCore::loadLib('tags');
$inCore->loadModel('shop');
$model = new cms_model_shop();

$inDB = cmsDatabase::getInstance();

$cfg = $model->getConfig();

$opt = $inCore::request('opt', 'str', 'list_orders');

$GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/admin/components/shop/js/common.js"></script>';
$GLOBALS['cp_page_head'][] = '<link type="text/css" rel="stylesheet" href="/admin/components/shop/css/styles.css">';

cpAddPathway('InstantShop', '?view=components&do=config&id=' . $_REQUEST['id']);

//=================================================================================================//
//=================================================================================================//

$toolmenu = array();

if ($opt == 'list_items' || $opt == 'list_cats' || $opt == 'list_chars' || $opt == 'list_vendors' || $opt == 'list_delivery' || $opt == 'list_psys' || $opt == 'list_orders' || $opt == 'list_discounts') {

    echo '<h3>InstantShop</h3>';

    $toolmenu[0]['icon'] = 'listorders.gif';
    $toolmenu[0]['title'] = 'Заказы';
    $toolmenu[0]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_orders';

    $toolmenu[1]['icon'] = 'folders.gif';
    $toolmenu[1]['title'] = 'Категории и товары';
    $toolmenu[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items';

    $toolmenu[2]['icon'] = 'listchars.gif';
    $toolmenu[2]['title'] = 'Характеристики товаров';
    $toolmenu[2]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1';

    $toolmenu[3]['icon'] = 'listvendors.gif';
    $toolmenu[3]['title'] = 'Производители';
    $toolmenu[3]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_vendors';

    $toolmenu[4]['icon'] = 'listlorry.gif';
    $toolmenu[4]['title'] = 'Способы доставки';
    $toolmenu[4]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_delivery';

    $toolmenu[5]['icon'] = 'listpsys.gif';
    $toolmenu[5]['title'] = 'Платежные системы';
    $toolmenu[5]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_psys';

    $toolmenu[6]['icon'] = 'listdiscount.gif';
    $toolmenu[6]['title'] = 'Скидки и наценки';
    $toolmenu[6]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts';

    $toolmenu[7]['icon'] = 'newstuff.gif';
    $toolmenu[7]['title'] = 'Новый товар';
    $toolmenu[7]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_item';

    $toolmenu[8]['icon'] = 'newfolder.gif';
    $toolmenu[8]['title'] = 'Новая категория';
    $toolmenu[8]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_cat';

    $toolmenu[9]['icon'] = 'newchar.gif';
    $toolmenu[9]['title'] = 'Новая характеристика';
    $toolmenu[9]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_char&all=1';

    $toolmenu[10]['icon'] = 'newvendor.gif';
    $toolmenu[10]['title'] = 'Новый производитель';
    $toolmenu[10]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_vendor';

    $toolmenu[11]['icon'] = 'newlorry.gif';
    $toolmenu[11]['title'] = 'Новый способ доставки';
    $toolmenu[11]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_delivery';

    $toolmenu[12]['icon'] = 'newdiscount.gif';
    $toolmenu[12]['title'] = 'Новая скидка';
    $toolmenu[12]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_discount';

    $toolmenu[13]['icon'] = 'import.gif';
    $toolmenu[13]['title'] = 'Импорт товаров';
    $toolmenu[13]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=import';

    $toolmenu[14]['icon'] = 'yml.gif';
    $toolmenu[14]['title'] = 'Экспорт в XML';
    $toolmenu[14]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=ymlcfg';

    $toolmenu[15]['icon'] = 'config.gif';
    $toolmenu[15]['title'] = 'Настройки';
    $toolmenu[15]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=config';

    $toolmenu[16]['icon'] = 'decrypted.png';
    $toolmenu[16]['title'] = 'Фиксация цен';
    $toolmenu[16]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=fixprice';

    if ($opt != 'load_chars') {
        cpToolMenu($toolmenu);
        $toolmenu = array();
        echo '<div style="margin-top:2px"></div>';
    }

}


//=================================================================================================//
//=================================================================================================//

if ($opt == 'list_orders') {

    cpAddPathway('Список заказов', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
    echo '<h3>Список заказов</h3>';

    $status = $inCore->request('status', 'int', 0);
    $refresh_sec = $inCore->request('refresh_sec', 'int', 900);

    $GLOBALS['cp_page_head'][] = '<meta http-equiv="refresh" content="' . $refresh_sec . '">';

    $component_id = $inCore->request('id', 'int', 0);
    $base_uri = 'index.php?view=components&do=config&id=' . $component_id . '&opt=list_orders';
    $component_uri = 'index.php?view=components&do=config&id=' . $component_id;

    $customer_name = $inCore->request('customer_name', 'str', '');

    $def_order = 'id';
    $orderby = $inCore->request('orderby', 'str', $def_order);
    $orderto = $inCore->request('orderto', 'str', 'desc');
    $page = $inCore->request('page', 'int', 1);
    $perpage = 10;

    $hide_cats = $inCore->request('hide_cats', 'int', 0);

    $cats = array('1' => 'Принятые', '2' => 'Оплаченные', '3' => 'Закрытые');

    if ($customer_name) {
        $model->where('LOWER(o.customer_name) LIKE \'%' . strtolower($customer_name) . '%\'');
    }

    if ($status == 0) {
        $model->where('o.status = 1 OR o.status = 2');
    } else {
        $model->where('o.status = ' . $status);
    }

    $model->orderBy($orderby, $orderto);

    $model->limitPage($page, $perpage);

    $total = $model->getOrdersCount();

    $items = $model->getOrders();

    $pages = ceil($total / $perpage);

    include($_SERVER['DOCUMENT_ROOT'] . '/admin/components/shop/orders.tpl.php');

}

//=================================================================================================//
//=================================================================================================//

if ($opt == 'edit_order') {

    $order_id = $inCore->request('item_id', 'int', 0);
    $component_id = $inCore->request('id', 'int', 0);
    $component_uri = 'index.php?view=components&do=config&id=' . $component_id;

    cpAddPathway('Список заказов', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_orders');
    cpAddPathway('Просмотр заказа', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_order&item_id=' . $order_id);
    echo '<h3>Просмотр заказа #' . $order_id . '</h3>';

    $order = $model->getOrder($order_id);
    $order['delivery'] = $inDB->get_field('cms_shop_delivery', "id={$order['d_type']}", 'title');

    foreach ($order['items'] as $i => $item) {
        if ($item['is_digital'] && $item['filename_item'] && $item['filename_orig']) {

            $load = $inDB->get_fields('cms_shop_loads', "item_id={$item['item_id']} AND order_id={$order_id}", '*');

            if (!$load) {
                $order['items'][$i]['load_info'] = 'Ссылка на загрузку еще не выслана';
            } elseif ($load['is_loaded']) {
                $inCore->loadLanguage('lang');
                $order['items'][$i]['load_info'] = '<strong>Загружен:</strong> ' . cmsCore::dateFormat($load['load_date']) . ' с адреса ' . $load['load_ip'];
            } else {
                $order['items'][$i]['load_info'] = 'Ссылка выслана, еще не загружен';
            }

        }
    }

    include($_SERVER['DOCUMENT_ROOT'] . '/admin/components/shop/order.tpl.php');

}

//=================================================================================================//
//=================================================================================================//

if ($opt == 'delete_order') {

    if ($inCore->inRequest('item_id')) {
        $id = $inCore->request('item_id', 'int');
        $model->deleteOrder($id);
    }

    $inCore->redirectBack();
}

//=================================================================================================//
//=================================================================================================//

if ($opt == 'add_order_item') {

    if ($inCore->inRequest('add_art_no')) {
        $order_id = $inCore->request('order_id', 'int');
        $art_no = $inCore->request('add_art_no', 'str', '');
        $qty = $inCore->request('add_qty', 'int');
        $model->addOrderItem($order_id, $art_no, $qty);
    }

    $inCore->redirectBack();

}

if ($opt == 'delete_order_item') {

    if ($inCore->inRequest('item_id')) {
        $item_id = $inCore->request('item_id', 'int');
        $order_id = $inCore->request('order_id', 'int');
        $model->deleteOrderItem($order_id, $item_id);
    }

    $inCore->redirectBack();
}

if ($opt == 'save_order_comment') {

    $order_id = $inCore->request('order_id', 'int');
    $comment = $inCore->request('comment', 'str');
    $model->saveOrderComment($order_id, $comment);

    $inCore->redirectBack();

}

//=================================================================================================//
//=================================================================================================//

if ($opt == 'set_order_status') {

    $status = $inCore->request('status', 'int', 0);
    $order_id = $inCore->request('order_id', 'int', 0);
    $secret_key = $inCore->request('secret_key', 'str', '');

    if ($status && $order_id && $secret_key) {
        $model->setOrderStatus($order_id, $secret_key, $status);
    }

    $inCore->redirectBack();

}

if ($inUser->id == 1 || $inUser->id == 69 || $inUser->id == 221) {

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_items') {

        $toolmenu[110]['icon'] = 'edit.gif';
        $toolmenu[110]['title'] = 'Редактировать выбранные';
        $toolmenu[110]['link'] = "javascript:checkSel('?view=components&do=config&id=" . $_REQUEST['id'] . "&opt=edit_item&multiple=1');";

        $toolmenu[120]['icon'] = 'show.gif';
        $toolmenu[120]['title'] = 'Публиковать выбранные';
        $toolmenu[120]['link'] = "javascript:checkSel('?view=components&do=config&id=" . $_REQUEST['id'] . "&opt=show_item&multiple=1');";

        $toolmenu[130]['icon'] = 'hide.gif';
        $toolmenu[130]['title'] = 'Скрыть выбранные';
        $toolmenu[130]['link'] = "javascript:checkSel('?view=components&do=config&id=" . $_REQUEST['id'] . "&opt=hide_item&multiple=1');";

        $toolmenu[160]['icon'] = 'saveprices.gif';
        $toolmenu[160]['title'] = 'Сохранить цены отмеченных товаров';
        $toolmenu[160]['link'] = "javascript:sendForm('index.php?view=components&do=config&id=" . $_REQUEST['id'] . "&opt=saveprices');";

        // if ($opt != 'load_chars'){ cpToolMenu($toolmenu); $toolmenu = array(); }

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_items' || $opt == 'list_cats' || $opt == 'list_discounts' || $opt == 'list_chars' || $opt == 'list_vendors' || $opt == 'list_delivery' || $opt == 'list_psys' || $opt == 'list_orders') {

    } else {

        $toolmenu[200]['icon'] = 'save.gif';
        $toolmenu[200]['title'] = 'Сохранить';
        $toolmenu[200]['link'] = 'javascript:document.addform.submit();';

        $toolmenu[210]['icon'] = 'cancel.gif';
        $toolmenu[210]['title'] = 'Отмена';
        $toolmenu[210]['link'] = 'javascript:history.go(-1);';


        if ($opt != 'load_chars') {
            cpToolMenu($toolmenu);
            $toolmenu = array();
        }

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'go_import_csv') {

        $items = array();
        $error = '';

        $component_id = $inCore->request('id', 'int');

        $encoding = $inCore->request('encoding', 'str', 'CP1251');
        $separator = $inCore->request('separator', 'str', ',');
        if ($separator == 't') {
            $separator = "\t";
        }

        $quote = $inCore->request('$quote', 'str', 'quot');
        $quote = ($quote == 'quot' ? '"' : "'");
        $cat_id = $inCore->request('cat_id', 'int', 0);
        $rows_start = $inCore->request('rows_start', 'int', 1);
        $rows_count = $inCore->request('rows_count', 'int', 0);
        $data_struct = $inCore->request('data_struct', 'str', '');
        $current_row = 0;
        $rows_loaded = 0;
        $cfg['hide_items'] = $inCore->request('hide_items', 'int', 0);
        $cfg['update_items'] = $inCore->request('update_items', 'int', 0);

        if (!isset($_FILES["csvfile"]["name"]) || @$_FILES["csvfile"]["name"] == '') {
            $error = 'Ошибка загрузки файла. Код: 001';
        }

        $tmp_name = $_FILES["csvfile"]["tmp_name"];
        $file = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . md5($_FILES["csvfile"]["name"] . time()) . '.csv';

        if (!move_uploaded_file($tmp_name, $file)) {
            $error = 'Ошибка загрузки файла. Код: 002';
        }

        $csv_file = @fopen($file, 'r');

        if (!$csv_file) {
            $error = 'Ошибка открытия файла. Код: 003';
        }

        if ($csv_file) {

            $data_struct = explode(',', $data_struct);
            foreach ($data_struct as $key => $val) {
                $data_struct[$key] = trim($val);
            }

            //Импорт товаров в цикле
            while (!feof($csv_file)) {

                //увеличим номер текущей строки
                $current_row++;
                //читаем строку
                $row = fgets($csv_file);
                if (!$row) {
                    continue;
                }
                //если не достигли начала, пропускаем импорт и в начало
                if ($current_row < $rows_start) {
                    continue;
                }
                //увеличим счетчик строк
                $rows_loaded++;
                //проверяем превышение лимита
                if ($rows_loaded > $rows_count && $rows_count > 0) {
                    break;
                }

                //конвертим кодировку
                if ($encoding != 'UTF-8') {
                    $row = iconv($encoding, 'UTF-8', $row);
                }

                $row_struct = array();

                //разбиваем строку на поля
                $row_struct = explode($separator, $row);

                //очищаем поля от кавычек
                foreach ($row_struct as $key => $val) {
                    $val = trim($val);
                    $val = ltrim($val, $quote);
                    $val = rtrim($val, $quote);
                    $row_struct[$key] = trim($val);
                }

                $item = array();

                foreach ($data_struct as $num => $field) {

                    //пропускаем ненужные колонки
                    if ($field == '---') {
                        continue;
                    }

                    //сохраняем id доп.категории в списке
                    if ($field == 'sub_category_id' && $row_struct[$num]) {
                        $item['cats'][] = $row_struct[$num];
                        continue;
                    }

                    //сохраняем название доп.категории в списке
                    if ($field == 'sub_category' && $row_struct[$num]) {
                        $item['cats_titles'][] = $row_struct[$num];
                        continue;
                    }

                    if (is_numeric(str_replace('c', '', $field))) {
                        //поле - характеристика
                        $item['chars'][str_replace('c', '', $field)] = $row_struct[$num];
                    } else {
                        //поле - параметр товара
                        $item[$field] = $row_struct[$num];
                    }
                }

                if ($item) {

                    $items[] = $item;

                }

            }//while

            @unlink($file);

        }//if csv file

        $imported_items = array();

        if ($items) {
            $importResult = $model->importItems($items, $cat_id, $cfg);
        }

        echo '<h3 style="margin-bottom:4px;padding-bottom:0px;">Импорт завершен</h3>';

        if ($importResult['imported'] || $importResult['updated']) {

            echo '<form action="index.php?view=components&do=config&id=' . $component_id . '&opt=edit_item" name="selform" method="post">';

            //
            // Импортированные
            //
            if ($importResult['imported']) {

                echo '<p style="font-size:14px">
                        <strong>Добавленные товары (' . sizeof($importResult['imported']) . '):</strong>
                      </p>';

                echo '<table cellpadding="1" cellspacing="0" border="0">';
                foreach ($importResult['imported'] as $item) {
                    echo '<tr>';
                    echo '<td width="25"><input type="checkbox" id="item' . $item['id'] . '" value="' . $item['id'] . '" name="item[]" /><td>';
                    echo '<td><a target="_blank" href="/admin/index.php?view=components&do=config&id=' . $component_id . '&opt=edit_item&item_id=' . $item['id'] . '">' . $item['title'] . '</a><td>';
                    echo '</tr>';
                }
                echo '</table>';

            }

            //
            // Обновленные
            //
            if ($importResult['updated']) {

                echo '<p style="font-size:14px">
                        <strong>Обновленные товары (' . sizeof($importResult['updated']) . '):</strong>
                      </p>';

                echo '<table cellpadding="1" cellspacing="0" border="0">';
                foreach ($importResult['updated'] as $item) {
                    echo '<tr>';
                    echo '<td width="25"><input type="checkbox" id="item' . $item['id'] . '" value="' . $item['id'] . '" name="item[]" /><td>';
                    echo '<td><a target="_blank" href="/admin/index.php?view=components&do=config&id=' . $component_id . '&opt=edit_item&item_id=' . $item['id'] . '">' . $item['title'] . '</a><td>';
                    echo '</tr>';
                }
                echo '</table>';

            }

            echo '<p style="margin-top:10px;padding-top:15px;border-top:dotted 1px silver">
                    <a href="javascript:" onclick="$(\'input[type=checkbox]\').attr(\'checked\', \'checked\')" style="color:#09C;border-bottom:dashed 1px #09c;text-decoration:none">Отметить все</a> |
                    <a href="javascript:" onclick="$(\'input[type=checkbox]\').attr(\'checked\', \'\')" style="color:#09C;border-bottom:dashed 1px #09c;text-decoration:none">Снять отметки</a> |
                    <a href="javascript:" onclick="invert()" style="color:#09C;border-bottom:dashed 1px #09c;text-decoration:none">Инвертировать</a>
                  </p>';

            echo '<p>
                    Отмеченные:
                    <input type="button" onclick="sendShopForm(' . $component_id . ', \'edit_item\')" value="Редактировать" />
                    <input type="button" onclick="sendShopForm(' . $component_id . ', \'delete_item\')" value="Удалить" /> или
                    <input type="button" onclick="window.location.href=\'/admin/index.php?view=components&do=config&id=' . $component_id . '&opt=list_items\'" value="Продолжить" />
                  </p>';

            echo '</form>';

        } else {

            if ($error) {
                echo '<p style="color:red">' . $error . '</p>';
            }

            echo '<p>Ни один товар не был добавлен.</p>';
            echo '<p>Пожалуйста, проверьте настройки импорта и повторите операцию.</p>';
            echo '<p><input type="button" onclick="window.history.go(-1)" value="Повторить" /></p>';

        }

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'saveprices') {
//		$prices = $_REQUEST['price'];
//		$old_prices = $_REQUEST['old_price'];

        $items['price'] = $_REQUEST['price'];
        $items['old_price'] = $_REQUEST['old_price'];
        $itemsId = $_REQUEST['item'];

        foreach ($itemsId as $item) {
            $itemPrice = $items['price']["$item"];
            $itemOldPrice = $items['old_price']["$item"];
            $itemPrice = str_replace(',', '.', $itemPrice);
            $itemPrice = number_format($itemPrice, $cfg['show_decimals'], '.', '');

            $itemOldPrice = str_replace(',', '.', $itemOldPrice);
            $itemOldPrice = number_format($itemOldPrice, $cfg['show_decimals'], '.', '');

            if ($itemPrice || $itemOldPrice) {
                $sql = "UPDATE cms_shop_items SET price='$itemPrice', old_price=$itemOldPrice WHERE id = $item";
                $inDB->query($sql);
            }
        }


//		if (is_array($prices) || is_array($old_price)){
//			foreach($prices as $id=>$price) {
//				$sql = "UPDATE cms_shop_items SET price='$price' WHERE id = $id";
//				$inDB->query($sql);
//			}
//		}
        $var_prices = $_REQUEST['var_price'];
        $var_is_price = $_REQUEST['var_is_price'];
        if (is_array($var_prices)) {
            foreach ($var_prices as $id => $price) {
                if ($var_is_price[$id]) {
                    $price = str_replace(',', '.', $price);
                    $price = number_format($price, $cfg['show_decimals'], '.', '');
                } else {
                    $price = '0';
                }
                $sql = "UPDATE cms_shop_items_bind SET price='$price' WHERE id = $id";
                $inDB->query($sql);

            }
        }
        header('location:' . $_SERVER['HTTP_REFERER']);
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_chars', $_REQUEST['item_id']);
            }
        } else {
            dbShowList('cms_shop_chars', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_chars', $_REQUEST['item_id']);
            }
        } else {
            dbHideList('cms_shop_chars', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_psys') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_psys', $_REQUEST['item_id']);
            }
        } else {
            dbShowList('cms_shop_psys', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_psys') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_psys', $_REQUEST['item_id']);
            }
        } else {
            dbHideList('cms_shop_psys', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_delivery') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_delivery', $_REQUEST['item_id']);
            }
        } else {
            dbShowList('cms_shop_delivery', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_delivery') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_delivery', $_REQUEST['item_id']);
            }
        } else {
            dbHideList('cms_shop_delivery', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_vendor') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_vendors', $_REQUEST['item_id']);
            }
        } else {
            dbShowList('cms_shop_vendors', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_vendor') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_vendors', $_REQUEST['item_id']);
            }
        } else {
            dbHideList('cms_shop_vendors', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_discount') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_discounts', $_REQUEST['item_id']);
            }
        } else {
            dbShowList('cms_shop_discounts', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_discount') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_discounts', $_REQUEST['item_id']);
            }
        } else {
            dbHideList('cms_shop_discounts', $_REQUEST['item']);
        }
        echo '1';
        exit;
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'move_char') {

        $item_id = $inCore->request('item_id', 'int', 0);
        $cat_id = $inCore->request('cat_id', 'int', 0);

        $dir = $_REQUEST['dir'];
        $step = 1;

        $model->moveChar($item_id, $cat_id, $dir, $step);
        echo '1';
        exit;

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'move_item') {

        $item_id = $inCore->request('item_id', 'int', 0);
        $cat_id = $inCore->request('cat_id', 'int', 0);

        $dir = $_REQUEST['dir'];
        $step = 1;

        $model->moveItem($item_id, $cat_id, $dir, $step);
        echo '1';
        exit;

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'move_cat') {

        $cat_id = $inCore->request('cat_id', 'int', 0);

        $dir = $_REQUEST['dir'];

        $model->moveCategory($cat_id, $dir);
        $inCore->redirectBack();
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'move_psys') {

        $item_id = $inCore->request('item_id', 'int', 0);

        $dir = $_REQUEST['dir'];
        $step = 1;

        $model->movePaySys($item_id, $dir, $step);
        echo '1';
        exit;

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_item') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbShow('cms_shop_items', $_REQUEST['item_id']);
                echo '1';
                exit;
            } else {
                $category_id = $inCore->request('cat_id', 'int', 0);
                $model->toggleItems($category_id, true);
                $inCore->redirectBack();
            }
        } else {
            dbShowList('cms_shop_items', $_REQUEST['item']);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'hide_item') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                dbHide('cms_shop_items', $_REQUEST['item_id']);
                echo '1';
                exit;
            } else {
                $category_id = $inCore->request('cat_id', 'int', 0);
                $model->toggleItems($category_id, false);
                $inCore->redirectBack();
            }
        } else {
            dbHideList('cms_shop_items', $_REQUEST['item']);
            $inCore->redirectBack();
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'compare_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setCharFlag($_REQUEST['item_id'], 'is_compare', 1);
                echo '1';
                exit;
            }
        } else {
            $model->setCharFlag($_REQUEST['item'], 'is_compare', 1);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'uncompare_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setCharFlag($_REQUEST['item_id'], 'is_compare', 0);
                echo '1';
                exit;
            }
        } else {
            $model->setCharFlag($_REQUEST['item'], 'is_compare', 0);
            $inCore->redirectBack();
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'filter_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setCharFlag($_REQUEST['item_id'], 'is_filter', 1);
                echo '1';
                exit;
            }
        } else {
            $model->setCharFlag($_REQUEST['item'], 'is_filter', 1);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'unfilter_char') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setCharFlag($_REQUEST['item_id'], 'is_filter', 0);
                echo '1';
                exit;
            }
        } else {
            $model->setCharFlag($_REQUEST['item'], 'is_filter', 0);
            $inCore->redirectBack();
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_item_front') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_front', 1);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_front', 1);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'hide_item_front') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_front', 0);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_front', 0);
            $inCore->redirectBack();
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_item_hit') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_hit', 1);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_hit', 1);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'hide_item_hit') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_hit', 0);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_hit', 0);
            $inCore->redirectBack();
        }
    }

    if ($opt == 'show_item_spec') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_spec', 1);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_spec', 1);
            $inCore->redirectBack();
        }

    }

    if ($opt == 'hide_item_spec') {
        if (!isset($_REQUEST['item'])) {
            if (isset($_REQUEST['item_id'])) {
                $model->setItemFlag($_REQUEST['item_id'], 'is_spec', 0);
                echo '1';
                exit;
            }
        } else {
            $model->setItemsFlag($_REQUEST['item'], 'is_spec', 0);
            $inCore->redirectBack();
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_item') {

        $inCore->includeGraphics();

        $item = array();
        $paramsItem = [];

        //get variables
        $item['category_id'] = $inCore->request('cat_id', 'int', 0);
        $item['vendor_id'] = $inCore->request('vendor_id', 'int', 0);
        $item['art_no'] = $inCore->request('art_no', 'str', '000');
        $item['title'] = $inCore->request('title', 'str');

        $item['tpl'] = $inCore->request('tpl', 'str', 'com_inshop_item.tpl');
        $item['url'] = $inCore->request('url', 'str', '');

        $item['shortdesc'] = $inDB->escape_string($inCore->request('shortdesc', 'html'));
        $item['description'] = $inDB->escape_string($inCore->request('description', 'html'));
        $item['metakeys'] = $inDB->escape_string($inCore->request('metakeys', 'str'));
        $item['metadesc'] = $inDB->escape_string($inCore->request('metadesc', 'str'));

        $item['is_comments'] = $inCore->request('is_comments', 'int', 0);
        $item['metakeys'] = $inCore->request('metakeys', 'str');
        $item['metadesc'] = $inCore->request('metadesc', 'str');
        $item['tags'] = $inCore->request('tags', 'str');

        $item['ves'] = number_format(str_replace(',', '.', $inCore->request('ves', 'str', '0.00')), 2, '.', '');
        $item['vol'] = number_format(str_replace(',', '.', $inCore->request('vol', 'str', '0.00')), 2, '.', '');
        $item['ven_code'] = $inCore->request('ven_code', 'str');
        $item['ordering'] = $inCore->request('ordering', 'int', 0);

        $item['price'] = number_format(str_replace(',', '.', $inCore->request('price', 'str', '0.00')), $cfg['show_decimals'], '.', '');
        $item['old_price'] = number_format(str_replace(',', '.', $inCore->request('old_price', 'str', '0.00')), $cfg['show_decimals'], '.', '');

        $item['published'] = $inCore->request('published', 'int', 0);
        $date = explode('.', $inCore->request('pubdate', 'str'));
        $item['pubdate'] = $date[2] . '-' . $date[1] . '-' . $date[0] . ' ' . date('H:i');

        $item['is_hit'] = $inCore->request('is_hit', 'int', 0);
        $item['is_spec'] = $inCore->request('is_spec', 'int', 0);
        $item['is_front'] = $inCore->request('is_front', 'int', 0);
        $item['is_digital'] = $inCore->request('is_digital', 'int', 0);

        $item['qty'] = $inCore->request('qty', 'int', 1);

        $item['cats'] = $inCore->request('cats', 'array');
        $item['chars'] = $inCore->request('chars', 'array');
        $item['vars_art_no'] = $inCore->request('vars_art_no', 'array');
        $item['vars_title'] = $inCore->request('vars_title', 'array');
        $item['vars_price'] = $inCore->request('vars_price', 'array');
        $item['vars_qty'] = $inCore->request('vars_qty', 'array');

        $item['kaspikz'] = $inCore->request('kaspikz', 'str');

        $item['auto_thumb'] = $inCore->request('auto_thumb', 'int', 0);


        $titlePart = $inCore->request('titlePart', 'array');
        $widthItem = $inCore->request('widthItem', 'array');
        $heightItem = $inCore->request('heightItem', 'array');
        $depthItem = $inCore->request('depthItem', 'array');
        $weightItem = $inCore->request('weightItem', 'array');






//        $checkingExistenceItem = $model->getItemFromVenCode($item['ven_code']);
//
//        if ($item['title'] == '' || $item['ven_code'] == '' || $checkingExistenceItem == null) {
//            return $inCore->redirectBack();
//        }


        $item['id'] = $model->addItem($item);


        for ($i = 0; $i < count($titlePart); $i++) {
            $paramsItem[$i] = [
                'title' => $titlePart[$i],
                'width' => $widthItem[$i],
                'height' => $heightItem[$i],
                'depth' => $depthItem[$i],
                'weight' => $weightItem[$i]
            ];
        }



        if ($item['ordering'] == 1) {
            $model->vperedItem($id, $item['category_id']);
        }




        $model->addParamsItem($item['id'], $paramsItem);

        if ($inCore->request('add_again', 'int', 0)) {
            $inCore->redirect('?view=components&do=config&opt=add_item&id=' . $_REQUEST['id'] . '&added=' . $item['id']);
        } else {
            $inCore->redirect('?view=components&do=config&opt=list_items&id=' . $_REQUEST['id'] . '&orderby=id&orderto=desc&cat_id=' . $item['category_id']);
        }


    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'renew_item') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->renewItem($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_prices') {

        $sign = $_REQUEST['p_sign'];
        $cat_id = $inCore->request('p_cat_id', 'int', 0);
        $back_to_cat_id = $inCore->request('cat_id', 'int', 0);
        $value = $inCore->request('p_val', 'str', '0');
        $is_percent = $inCore->request('p_is_percent', 'int', 1);
        $is_recursive = $inCore->request('p_is_recursive', 'int', 1);
        $is_round = $inCore->request('p_is_round', 'int', 1);
        $is_save_old = $inCore->request('p_is_old', 'int', 0);

        $model->updatePrices($cat_id, $value, $sign, $is_percent, $is_recursive, $is_round, $is_save_old);

        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=' . $back_to_cat_id . '&prices_upd=1');

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_item') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $item = array();
            $paramsItem = [];

            //get variables
            $item['category_id'] = $inCore->request('cat_id', 'int', 0);
            $item['vendor_id'] = $inCore->request('vendor_id', 'int', 0);
            $item['art_no'] = $inCore->request('art_no', 'str', '000');
            $item['title'] = $inCore->request('title', 'str');

            $item['tpl'] = $inCore->request('tpl', 'str', 'com_inshop_item.tpl');
            $item['url'] = $inCore->request('url', 'str', '');

            $item['shortdesc'] = $inDB->escape_string($inCore->request('shortdesc', 'html'));
            $item['description'] = $inDB->escape_string($inCore->request('description', 'html'));
            $item['metakeys'] = $inDB->escape_string($inCore->request('metakeys', 'str'));
            $item['metadesc'] = $inDB->escape_string($inCore->request('metadesc', 'str'));

            $item['is_comments'] = $inCore->request('is_comments', 'int', 0);
            $item['meta_desc'] = $inCore->request('meta_desc', 'str');
            $item['meta_keys'] = $inCore->request('meta_keys', 'str');
            $item['tags'] = $inCore->request('tags', 'str');
// и тууууутттт
            $item['ves'] = number_format(str_replace(',', '.', $inCore->request('ves', 'str', '0.00')), 2, '.', '');
            $item['vol'] = number_format(str_replace(',', '.', $inCore->request('vol', 'str', '0.00')), 2, '.', '');
            $item['ven_code'] = $inCore->request('ven_code', 'str');
            $item['ordering'] = $inCore->request('ordering', 'int', 0);

            $item['price'] = number_format(str_replace(',', '.', $inCore->request('price', 'str', '0.00')), $cfg['show_decimals'], '.', '');
            $item['old_price'] = number_format(str_replace(',', '.', $inCore->request('old_price', 'str', '0.00')), $cfg['show_decimals'], '.', '');

            $item['published'] = $inCore->request('published', 'int', 0);
            $date = explode('.', $inCore->request('pubdate', 'str'));
            $item['pubdate'] = $date[2] . '-' . $date[1] . '-' . $date[0] . ' ' . date('H:i');

            $item['is_hit'] = $inCore->request('is_hit', 'int', 0);
            $item['is_spec'] = $inCore->request('is_spec', 'int', 0);
            $item['is_front'] = $inCore->request('is_front', 'int', 0);
            $item['is_digital'] = $inCore->request('is_digital', 'int', 0);

            $item['qty'] = $inCore->request('qty', 'int', 1);

            $item['kaspikz'] = $inCore->request('kaspikz', 'str');

            $item['cats'] = $inCore->request('cats', 'array');
            $item['chars'] = $inCore->request('chars', 'array');
            $item['vars_art_no'] = $inCore->request('vars_art_no', 'array');
            $item['vars_title'] = $inCore->request('vars_title', 'array');
            $item['vars_price'] = $inCore->request('vars_price', 'array');
            $item['vars_qty'] = $inCore->request('vars_qty', 'array');

            $item['auto_thumb'] = $inCore->request('auto_thumb', 'int', 0);

            $item['img_delete'] = $inCore->request('img_delete', 'array');

            $model->updateItem($id, $item);

            $partId = $inCore->request('partId', 'array');

            $titlePart = $inCore->request('titlePart', 'array');
            $widthItem = $inCore->request('widthItem', 'array');
            $heightItem = $inCore->request('heightItem', 'array');
            $depthItem = $inCore->request('depthItem', 'array');
            $weightItem = $inCore->request('weightItem', 'array');

            for($i=0; $i < count($titlePart); $i++) {
                $paramsItem[$i] = [
                    'id' => $partId[$i],
                    'title' => $titlePart[$i],
                    'width' => $widthItem[$i],
                    'height' => $heightItem[$i],
                    'depth' => $depthItem[$i],
                    'weight' => $weightItem[$i]
                ];
            }

            $model->updateParamsItem($id, $paramsItem);

            if ($item['ordering'] == 1) {
                $model->vperedItem($id, $item['category_id']);
            }
            // tokarev
        }
        if (!isset($_SESSION['editlist']) || @sizeof($_SESSION['editlist']) == 0) {
            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=' . $item['category_id']);
        } else {
            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_item');
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'move_items') {

        if ($inCore->inRequest('item')) {

            $items = $inCore->request('item', 'array');
            $to_cat_id = $inCore->request('obj_id', 'int', 0);
            $from_cat_id = $inCore->request('subj_id', 'int', 0);

            $model->moveItems($items, $from_cat_id, $to_cat_id);

        }

        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=' . $to_cat_id);

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_item') {

        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteItem($id);
        }

        if ($inCore->inRequest('item')) {
            $items = $inCore->request('item', 'array');
            $model->deleteItems($items);
        }


        $inCore->redirectBack();
    }


//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_discount') {

        $item['title'] = $inCore->request('title', 'str');
        $item['sign'] = $inCore->request('sign', 'str');
        $item['cats'] = $inCore->request('cats', 'array');
        $item['groups'] = $inCore->request('groups', 'array');
        $item['amount'] = $inCore->request('amount', 'str');
        $item['is_percent'] = $inCore->request('is_percent', 'int', 0);
        $item['is_forever'] = $inCore->request('is_forever', 'int', 1);
        $item['date_until'] = $inCore->request('date_until', 'str');

        $model->addDiscount($item);

        $inCore->redirect('?view=components&do=config&opt=list_discounts&id=' . $_REQUEST['id']);

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_discount') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $item['title'] = $inCore->request('title', 'str');
            $item['sign'] = $inCore->request('sign', 'str');
            $item['cats'] = $inCore->request('cats', 'array');
            $item['groups'] = $inCore->request('groups', 'array');
            $item['amount'] = $inCore->request('amount', 'str');
            $item['is_percent'] = $inCore->request('is_percent', 'int', 0);
            $item['is_forever'] = $inCore->request('is_forever', 'int', 1);
            $item['date_until'] = $inCore->request('date_until', 'str');

            $model->updateDiscount($id, $item);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts');
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_discount') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteDiscount($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'rename_char_group') {

        $old_name = $inCore->request('old_name', 'str', '');
        $new_name = $inCore->request('new_name', 'str', '');

        if ($old_name && $new_name) {
            $model->renameCharGroup($old_name, $new_name);
        }

        $inCore->redirect('?view=components&do=config&opt=list_chars&id=' . $_REQUEST['id'] . '&all=1&group=' . urlencode($new_name));

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_char_group') {

        $group_name = $inCore->request('group_name', 'str', '');

        if (group_name) {
            $model->deleteCharGroup($group_name);
        }

        $inCore->redirect('?view=components&do=config&opt=list_chars&id=' . $_REQUEST['id'] . '&all=1');

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_char') {

        $item['title'] = $inCore->request('title', 'str');
        $item['units'] = $inCore->request('units', 'str');
        $item['published'] = $inCore->request('published', 'int', 0);
        $item['fieldtype'] = $inCore->request('fieldtype', 'str', 'text');
        $item['is_custom'] = $inCore->request('is_custom', 'int', 0);
        $item['is_compare'] = $inCore->request('is_compare', 'int', 0);
        $item['is_filter'] = $inCore->request('is_filter', 'int', 0);
        $item['is_filter_many'] = $inCore->request('is_filter_many', 'int', 0);
        $item['bind_all'] = $inCore->request('bind_all', 'int', 0);
        $item['values'] = $inCore->request('values', 'str');

        $item['cats'] = $inCore->request('cats', 'array');

        $new_group = $inCore->request('fieldgroup_new', 'str', '');
        $group = $inCore->request('fieldgroup', 'str', '');
        $item['fieldgroup'] = ($new_group ? $new_group : $group);

        $model->addChar($item);

        $inCore->redirect('?view=components&do=config&opt=list_chars&id=' . $_REQUEST['id'] . '&all=1');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_char') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $item['title'] = $inCore->request('title', 'str');
            $item['units'] = $inCore->request('units', 'str');
            $item['published'] = $inCore->request('published', 'int', 0);
            $item['fieldtype'] = $inCore->request('fieldtype', 'str', 'text');
            $item['is_custom'] = $inCore->request('is_custom', 'int', 0);
            $item['is_compare'] = $inCore->request('is_compare', 'int', 0);
            $item['is_filter'] = $inCore->request('is_filter', 'int', 0);
            $item['is_filter_many'] = $inCore->request('is_filter_many', 'int', 0);
            $item['values'] = $inCore->request('values', 'str');
            $item['bind_all'] = $inCore->request('bind_all', 'int', 0);

            $item['cats'] = $inCore->request('cats', 'array');

            $new_group = $inCore->request('fieldgroup_new', 'str', '');
            $group = $inCore->request('fieldgroup', 'str', '');
            $item['fieldgroup'] = ($new_group ? $new_group : $group);

            $model->updateChar($id, $item);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_char_values') {
        if ($inCore->inRequest('item_id')) {

            $char_id = $inCore->request('item_id', 'int', 0);
            $vals = $inCore->request('val', 'array');

            $model->saveCharValues($char_id, $vals);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');

        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_char') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteChar($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_vendor') {

        $item['title'] = $inCore->request('title', 'str');
        $item['descr'] = $inCore->request('descr', 'html');
        $item['published'] = $inCore->request('published', 'int', 0);

        $model->addVendor($item);

        $inCore->redirect('?view=components&do=config&opt=list_vendors&id=' . $_REQUEST['id']);
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'save_psys_config') {

        $item_id = $inCore->request('item_id', 'int', 0);
        $config = $inCore->request('config', 'array');

        $model->savePaymentSystemConfig($item_id, $config);

        $inCore->redirect('?view=components&do=config&opt=list_psys&id=' . $_REQUEST['id']);

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_vendor') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $item['title'] = $inCore->request('title', 'str');
            $item['descr'] = $inCore->request('descr', 'html');
            $item['published'] = $inCore->request('published', 'int', 0);

            $model->updateVendor($id, $item);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_vendors');

        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_vendor') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteVendor($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_vendors');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_delivery') {

        $item['title'] = $inCore->request('title', 'str');
        $item['description'] = nl2br($inCore->request('description', 'str'));
        $item['published'] = $inCore->request('published', 'int', 0);
        $item['nofree'] = $inCore->request('nofree', 'int', 0);
        $item['price'] = $inCore->request('price', 'str', '0');
        $item['minsumm'] = $inCore->request('minsumm', 'str', '0');
        $item['freesumm'] = $inCore->request('freesumm', 'str', '0');

        $model->addDelivery($item);

        $inCore->redirect('?view=components&do=config&opt=list_delivery&id=' . $_REQUEST['id']);
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_delivery') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $item['title'] = $inCore->request('title', 'str');
            $item['description'] = nl2br($inCore->request('description', 'str'));
            $item['published'] = $inCore->request('published', 'int', 0);
            $item['nofree'] = $inCore->request('nofree', 'int', 0);
            $item['price'] = $inCore->request('price', 'str', '0');
            $item['minsumm'] = $inCore->request('minsumm', 'str', '0');
            $item['freesumm'] = $inCore->request('freesumm', 'str', '0');

            $model->updateDelivery($id, $item);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_delivery');

        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_delivery') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteDelivery($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_delivery');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'show_cat') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $sql = "UPDATE cms_shop_cats SET published = 1 WHERE id = $id";
            $inDB->query($sql);
            echo '1';
            exit;
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'hide_cat') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $sql = "UPDATE cms_shop_cats SET published = 0 WHERE id = $id";
            $inDB->query($sql);
            echo '1';
            exit;
        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'submit_cat') {

        $cat['parent_id'] = $inCore->request('parent_id', 'int');
        $cat['title'] = $inCore->request('title', 'str');
        $cat['tpl'] = $inCore->request('tpl', 'str', 'com_inshop_view.tpl');
        $cat['url'] = $inCore->request('url', 'str', '');
        $cat['meta_desc'] = $inCore->request('meta_desc', 'str', '');
        $cat['meta_keys'] = $inCore->request('meta_keys', 'str', '');
        $cat['pagetitle'] = $inCore->request('pagetitle', 'str', '');
        $cat['description'] = $inCore->request('description', 'html');
        $cat['published'] = $inCore->request('published', 'int');
        $cat['is_catalog'] = $inCore->request('is_catalog', 'int', 0);
        $cat['is_xml'] = $inCore->request('is_xml', 'int', 0);

        $cat['id'] = $model->addCategory($cat);

        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=' . $cat['id']);

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'delete_cat') {
        if ($inCore->inRequest('item_id')) {
            $id = $inCore->request('item_id', 'int');
            $model->deleteCategory($id);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'update_cat') {
        if ($inCore->inRequest('item_id')) {

            $id = $inCore->request('item_id', 'int');

            $cat['parent_id'] = $inCore->request('parent_id', 'int');
            $cat['old_parent_id'] = $inCore->request('old_parent_id', 'int');
            $cat['title'] = $inCore->request('title', 'str');
            $cat['tpl'] = $inCore->request('tpl', 'str', 'com_inshop_view.tpl');
            $cat['url'] = $inCore->request('url', 'str', '');
            $cat['meta_desc'] = $inCore->request('meta_desc', 'str', '');
            $cat['meta_keys'] = $inCore->request('meta_keys', 'str', '');
            $cat['pagetitle'] = $inCore->request('pagetitle', 'str', '');
            $cat['description'] = $inCore->request('description', 'html');
            $cat['published'] = $inCore->request('published', 'int');
            $cat['is_catalog'] = $inCore->request('is_catalog', 'int', 0);
            $cat['is_xml'] = $inCore->request('is_xml', 'int', 0);

            $model->updateCategory($id, $cat);

            $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=' . $id);

        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_cats') {

        cpAddPathway('Категории товаров', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_cats');
        echo '<h3>Категории товаров</h3>';

        //TABLE COLUMNS
        $fields = array();

        $fields[0]['title'] = 'id';
        $fields[0]['field'] = 'id';
        $fields[0]['width'] = '30';

        $fields[1]['title'] = 'Название';
        $fields[1]['field'] = 'title';
        $fields[1]['width'] = '';
        $fields[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_cat&item_id=%id%';

        $fields[4]['title'] = 'Показ';
        $fields[4]['field'] = 'published';
        $fields[4]['width'] = '100';
        $fields[4]['do'] = 'opt';
        $fields[4]['do_suffix'] = '_cat';

        //ACTIONS
        $actions = array();
        $actions[0]['title'] = 'Добавить товар';
        $actions[0]['icon'] = 'add.gif';
        $actions[0]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_item&cat_id=%id%';

        $actions[1]['title'] = 'Редактировать';
        $actions[1]['icon'] = 'edit.gif';
        $actions[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_cat&item_id=%id%';

        $actions[3]['title'] = 'Удалить';
        $actions[3]['icon'] = 'delete.gif';
        $actions[3]['confirm'] = 'Удалить категорию?';
        $actions[3]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=delete_cat&item_id=%id%';

//		echo '<script type="text/javascript">function openCat(id){ $("#catform input").val(id); $("#catform").submit(); } </script>';
//		echo '<form id="catform" method="post" action="index.php?view=components&do=config&id='.$_REQUEST['id'].'&opt=list_items"><input type="hidden" id="filter[category_id]" name="filter[category_id]" value=""></form>';

        //Print table
        cpListTable('cms_shop_cats', $fields, $actions, 'parent_id>0', 'NSLeft');

    }


//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_chars') {

        cpAddPathway('Характеристики товаров', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
        echo '<h3>Характеристики товаров</h3>';

        $show_all = $inCore->request('all', 'int', 0);
        $component_id = $inCore->request('id', 'int', 0);
        $category_id = $inCore->request('cat_id', 'int', 0);
        $group = $inCore->request('group', 'str', '');
        $base_uri = 'index.php?view=components&do=config&id=' . $component_id . '&opt=list_chars';
        $component_uri = 'index.php?view=components&do=config&id=' . $component_id;

        $cats = $model->getCategories(false);
        $groups = $model->getCharGroups();

        if ($show_all) {

            $items = $model->getChars(false, $group);

        } else {

            $all_items = $model->getChars(false);
            $items = $model->getCatChars($category_id, false);

        }

        include($_SERVER['DOCUMENT_ROOT'] . '/admin/components/shop/chars.tpl.php');

    }


//=================================================================================================//
//=================================================================================================//

    if ($opt == 'copy_cat_chars') {

        $to_cat_id = $inCore->request('to_cat_id', 'int', 0);
        $from_cat_id = $inCore->request('from_cat_id', 'int', 0);

        if ($to_cat_id && $from_cat_id) {
            $model->copyCatChars($from_cat_id, $to_cat_id);
        }

        $inCore->redirectBack();

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'bind_char') {

        $char_id = $inCore->request('char_id', 'int', 0);
        $cat_id = $inCore->request('cat_id', 'int', 0);

        if ($char_id && $cat_id) {
            $model->bindChar($char_id, $cat_id);
        }

        $inCore->redirectBack();

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'bind_char_group') {

        $char_group_id = $inCore->request('char_group_id', 'str', '');
        $cat_id = $inCore->request('cat_id', 'int', 0);

        if ($char_group_id && $cat_id) {
            $model->bindCharGroup($char_group_id, $cat_id);
        }

        $inCore->redirectBack();

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'unbind_char') {

        $char_id = $inCore->request('item_id', 'int', 0);
        $cat_id = $inCore->request('cat_id', 'int', 0);

        if ($char_id) {
            $model->unbindChar($char_id, $cat_id);
        }

        $inCore->redirectBack();

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'unbind_chars') {

        $cat_id = $inCore->request('cat_id', 'int', 0);

        if ($cat_id) {
            $model->unbindChars($cat_id);
        }

        $inCore->redirectBack();

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_vendors') {

        cpAddPathway('Производители', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_vendors');
        echo '<h3>Производители / Бренды</h3>';

        //TABLE COLUMNS
        $fields = array();

        $fields[0]['title'] = 'id';
        $fields[0]['field'] = 'id';
        $fields[0]['width'] = '30';

        $fields[1]['title'] = 'Название';
        $fields[1]['field'] = 'title';
        $fields[1]['width'] = '';
        $fields[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_vendor&item_id=%id%';

        $fields[4]['title'] = 'Показ';
        $fields[4]['field'] = 'published';
        $fields[4]['width'] = '100';
        $fields[4]['do'] = 'opt';
        $fields[4]['do_suffix'] = '_vendor';

        //ACTIONS
        $actions = array();
        $actions[0]['title'] = 'Товары';
        $actions[0]['icon'] = 'explore.gif';
        $actions[0]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items&cat_id=0&vendor_id=%id%&hide_cats=1';

        $actions[1]['title'] = 'Редактировать';
        $actions[1]['icon'] = 'edit.gif';
        $actions[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_vendor&item_id=%id%';

        $actions[3]['title'] = 'Удалить';
        $actions[3]['icon'] = 'delete.gif';
        $actions[3]['confirm'] = 'Удалить производителя?\nТовары не будут удалены.';
        $actions[3]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=delete_vendor&item_id=%id%';

//		echo '<script type="text/javascript">function openCat(id){ $("#catform input").val(id); $("#catform").submit(); } </script>';
//		echo '<form id="catform" method="post" action="index.php?view=components&do=config&id='.$_REQUEST['id'].'&opt=list_items"><input type="hidden" id="filter[category_id]" name="filter[category_id]" value=""></form>';

        //Print table
        cpListTable('cms_shop_vendors', $fields, $actions, '', 'title');

    }

//=================================================================================================//
//=================================================================================================//
    if ($opt == 'list_discounts') {

        cpAddPathway('Скидки и наценки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts');
        echo '<h3>Скидки и наценки</h3>';

        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/includes/jquery/tabs/jquery.ui.min.js"></script>';
        $GLOBALS['cp_page_head'][] = '<link href="/includes/jquery/tabs/tabs.css" rel="stylesheet" type="text/css" />';

        if ($inCore->inRequest('submit')) {

            $cfg['discount'] = array();

            $dis_amount = $inCore->request('dis_amount', 'array');
            $dis_price = $inCore->request('dis_price', 'array');

            if (is_array($dis_amount) && $dis_amount[0]) {

                foreach ($dis_amount as $num => $amount) {
                    $amount = (int)$amount;
                    $price = (int)$dis_price[$num];
                    $cfg['discount'][$amount] = $price;
                }

                ksort($cfg['discount']);

            }

            $inCore->saveComponentConfig('shop', $cfg);

        }

        //TABLE COLUMNS
        $fields = array();

        $fields[0]['title'] = 'id';
        $fields[0]['field'] = 'id';
        $fields[0]['width'] = '30';

        $fields[1]['title'] = 'Название';
        $fields[1]['field'] = 'title';
        $fields[1]['width'] = '';
        $fields[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_discount&item_id=%id%';

        $fields[4]['title'] = 'Активна';
        $fields[4]['field'] = 'published';
        $fields[4]['width'] = '100';
        $fields[4]['do'] = 'opt';
        $fields[4]['do_suffix'] = '_discount';

        //ACTIONS
        $actions = array();

        $actions[1]['title'] = 'Редактировать';
        $actions[1]['icon'] = 'edit.gif';
        $actions[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_discount&item_id=%id%';

        $actions[3]['title'] = 'Удалить';
        $actions[3]['icon'] = 'delete.gif';
        $actions[3]['confirm'] = 'Удалить коэффициент?';
        $actions[3]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=delete_discount&item_id=%id%';

        //Print table
        ob_start();
        cpListTable('cms_shop_discounts', $fields, $actions, '', 'id');
        $discount_table = ob_get_clean();

        ?>

        <div id="discount_tabs" style="margin-top:12px;" class="uitabs">

            <ul id="tabs">
                <li><a href="#items"><span>Скидки на товары</span></a></li>
                <li><a href="#order"><span>Скидки на сумму заказа</span></a></li>
            </ul>

            <div id="items"><?php echo $discount_table; ?></div>

            <div id="order">

                <form method="post" action="">

                    <div style="padding:10px;border:solid 1px #CCC">
                        <table border="0" cellpadding="5" cellspacing="0" id="discounts">
                            <tr>
                                <th width="160">Сумма заказа от, <?php echo $cfg['currency']; ?></th>
                                <th width="160">Скидка, %</th>
                                <th width="17" class="dis_del">&nbsp;</th>
                            </tr>
                            <?php if (!$cfg['discount']) { ?>
                                <tr class="var">
                                    <td><input type="text" class="dis_amount" name="dis_amount[]" style="width:80px"/>
                                    </td>
                                    <td><input type="text" class="dis_price" name="dis_price[]" style="width:80px"/>
                                    </td>
                                    <td width="17" class="char_del">
                                        <a href="javascript:" onclick="deleteDiscount(this)" title="Удалить скидку">
                                            <img src="/admin/images/actions/delete.gif" alt="Удалить скидку" border="0">
                                        </a>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($cfg['discount'] as $amount => $price) { ?>
                                    <tr class="var">
                                        <td>
                                            <input type="text" class="dis_amount" name="dis_amount[]" style="width:80px" value="<?php echo $amount; ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" class="dis_price" name="dis_price[]" style="width:80px" value="<?php echo $price; ?>"/>
                                        </td>
                                        <td width="17" class="char_del">
                                            <a href="javascript:" onclick="deleteDiscount(this)" title="Удалить скидку">
                                                <img src="/admin/images/actions/delete.gif" alt="Удалить скидку" border="0">
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>

                        <script type="text/javascript">
                            updateDiscounts();
                        </script>

                        <div style="margin:15px 0; margin-left:17px;" class="add_discount">
                            <a href="javascript:addDiscount()">Добавить скидку</a>
                        </div>
                    </div>

                    <p>
                        <input name="submit" type="submit" value="Сохранить изменения"/>
                    </p>

                </form>

            </div>

        </div>

        <?php

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_delivery') {

        cpAddPathway('Способы доставки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_delivery');
        echo '<h3>Способы доставки</h3>';

        //TABLE COLUMNS
        $fields = array();

        $fields[0]['title'] = 'id';
        $fields[0]['field'] = 'id';
        $fields[0]['width'] = '30';

        $fields[1]['title'] = 'Название';
        $fields[1]['field'] = 'title';
        $fields[1]['width'] = '';
        $fields[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_delivery&item_id=%id%';

        $fields[2]['title'] = 'Цена';
        $fields[2]['field'] = 'price';
        $fields[2]['width'] = '150';

        $fields[4]['title'] = 'Показ';
        $fields[4]['field'] = 'published';
        $fields[4]['width'] = '100';
        $fields[4]['do'] = 'opt';
        $fields[4]['do_suffix'] = '_delivery';

        //ACTIONS
        $actions = array();
        $actions[1]['title'] = 'Редактировать';
        $actions[1]['icon'] = 'edit.gif';
        $actions[1]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_delivery&item_id=%id%';

        $actions[3]['title'] = 'Удалить';
        $actions[3]['icon'] = 'delete.gif';
        $actions[3]['confirm'] = 'Удалить способ доставки?';
        $actions[3]['link'] = '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=delete_delivery&item_id=%id%';

        //Print table
        cpListTable('cms_shop_delivery', $fields, $actions, '', 'title');

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_items') {

        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/admin/components/catalog/js/common.js"></script>';

        cpAddPathway('Категории и товары', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
        echo '<h3>Категории и товары</h3>';

        $component_id = $inCore->request('id', 'int', 0);
        $category_id = $inCore->request('cat_id', 'int', 0);
        $vendor_id = $inCore->request('vendor_id', 'int', 0);
        $base_uri = 'index.php?view=components&do=config&id=' . $component_id . '&opt=list_items';

        $title_part = $inCore->request('title', 'str', '');
        $art_no_part = $inCore->request('art_no', 'str', '');

        $def_order = $category_id ? 'ic.ordering' : 'title';
        $orderby = $inCore->request('orderby', 'str', $def_order);
        $orderto = $inCore->request('orderto', 'str', 'asc');
        $page = $inCore->request('page', 'int', 1);
        $perpage = 30;

        $hide_cats = $inCore->request('hide_cats', 'int', 0);

        $cats = $model->getCategories(false);
        $vendors = $model->getVendors(false);

        if ($vendor_id && $vendors[$vendor_id]['title']) {
            $vendor = $vendors[$vendor_id]['title'];
        } else {
            $vendor = '';
        }

        if ($category_id) {
            $model->whereCatIs($category_id);
        } else {
            $model->where('i.category_id = c.id');
        }

        if ($title_part) {
            $model->where('LOWER(i.title) LIKE \'%' . strtolower($title_part) . '%\'');
        }

        if ($art_no_part) {
            $model->where('LOWER(i.art_no) LIKE \'' . strtolower($art_no_part) . '%\'');
        }

        if ($vendor_id) {
            $model->whereVendorIs($vendor_id);
        }

        $model->orderBy($orderby, $orderto);

        $model->limitPage($page, $perpage);

        $total = $model->getItemsCount(false);

        $items = $model->getItems(false, false);

        $pages = ceil($total / $perpage);

        include($_SERVER['DOCUMENT_ROOT'] . '/admin/components/shop/items.tpl.php');

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'list_psys') {

        $component_id = (int)$_REQUEST['id'];

        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/admin/components/catalog/js/common.js"></script>';
        cpAddPathway('Платежные системы', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');

        $installed = $model->installPaymentSystems();

        if (is_array($installed)) {
            echo '<p style="color:green">';
            echo '<strong>Были установлены платежные системы:</strong> ';
            foreach ($installed as $num => $system) {
                echo $system;
                if ($num < sizeof($installed) - 1) {
                    echo ', ';
                }
            }
            echo '</p>';
        }

        $items = $model->getPaymentSystems(false);

        $is_billing = $inCore->isComponentInstalled('billing');

        include($_SERVER['DOCUMENT_ROOT'] . '/admin/components/shop/psys.tpl.php');

    }

//=================================================================================================//
//=================================================================================================//
//

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'copy_item') {
        $item_id = $inCore->request('item_id', 'int');
        $copies = $inCore->request('copies', 'int');
        if ($copies) {
            $model->copyItem($item_id, $copies);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'copy_cat') {
        $item_id = $inCore->request('item_id', 'int');
        $copies = $inCore->request('copies', 'int');
        if ($copies) {
            $model->copyCategory($item_id, $copies);
        }
        $inCore->redirect('?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_cats');
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'load_chars') {

        header('Content-type: text/html; charset=utf-8');

        $item_id = $inCore->request('item_id', 'int', 0);
        $cat_id = $inCore->request('cat_id', 'int', 0);

        //характеристики
        if ($item_id) {
            $mod['chars'] = array();
            $chrres = $inDB->query("SELECT char_id, val FROM cms_shop_chars_val WHERE item_id={$item_id}");
            if (mysqli_num_rows($chrres)) {
                while ($char = mysqli_fetch_assoc($chrres)) {
                    $mod['chars'][$char['char_id']] = $char['val'];
                }
            }
        }

        $chars = $model->getCatChars($cat_id);

        if ($chars) {
            ob_start();
            ?>
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <?php
                foreach ($chars as $id => $char) {
                    ?>
                    <tr>
                        <td width="40%"><?php echo $char['title']; ?></td>
                        <td align="right" width="60%">

                            <?php if ($char['fieldtype'] == 'file') { //Файл ?>

                                <?php $filedata = array(); ?>

                                <?php if ($mod['chars'][$char['id']]) {
                                    $filedata = $inCore->yamlToArray($mod['chars'][$char['id']]);
                                } ?>

                                <div id="cfile<?php echo $char['id']; ?>" style="display:<?php if ($filedata) { ?>none<?php } else { ?>block<?php } ?>">
                                    <input type="file" name="char_file<?php echo $char['id']; ?>"/>
                                </div>

                                <?php if ($filedata) { ?>
                                    <div style="float:left">
                                        <a href="#"><?php echo $filedata['name']; ?></a> <?php echo round($filedata['size'] / 1024); ?> Кб
                                        <input type="button" style="margin-left:10px" value="Заменить" onclick="$(this).parent('div').hide();$('#cfile<?php echo $char['id']; ?>').show()">
                                    </div>
                                <?php } ?>

                                <?php continue; ?>

                            <?php } ?>

                            <?php if ($char['fieldtype'] == 'cbox') { //Чекбоксы ?>

                                <?php
                                if ($char['values']) {
                                    $values = explode("\n", $char['values']);
                                    if (isset($mod['chars'][$char['id']])) {
                                        $checked = trim($mod['chars'][$char['id']], '|');
                                        $checked = explode('|', $checked);
                                    }
                                } else {
                                    $values = array();
                                }
                                ?>

                                <div style="text-align:left">
                                    <?php foreach ($values as $value) { ?>
                                        <label>
                                            <input type="checkbox" name="chars[<?php echo $char['id']; ?>][]" value="<?php echo trim($value); ?>" <?php if (in_array(trim($value), $checked)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                            <?php echo $value; ?>
                                        </label>
                                    <?php } ?>
                                </div>

                                <?php continue; ?>

                            <?php } ?>

                            <?php if ($char['fieldtype'] == 'user') { //Профиль пользователя ?>

                                <?php

                                if (!$users_list) {
                                    $sql = "SELECT login,nickname FROM cms_users WHERE is_deleted=0";
                                    $result = $inDB->query($sql);

                                    if ($inDB->num_rows($result)) {
                                        while ($user = $inDB->fetch_assoc($result)) {
                                            $users_list[] = array('nickname' => $user['nickname'], 'hash' => $user['login'] . '|' . $user['nickname']);
                                        }
                                    }
                                }

                                ?>

                                <select name="chars[<?php echo $char['id']; ?>]" style="width:100%">
                                    <?php foreach ($users_list as $user) { ?>
                                        <option value="<?php echo trim($user['hash']); ?>" <?php if (trim($user['hash']) == trim($default)) {
                                            echo 'selected="selected"';
                                        } ?>>
                                            <?php echo trim($user['nickname']); ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <?php continue; ?>

                            <?php } ?>

                            <?php //Текстовое поле
                            if (!$char['values']) {
                                if (!isset($mod['chars'][$char['id']])) {
                                    if ($char['fieldtype'] == 'link') {
                                        $default = 'http://';
                                    } else {
                                        $default = '';
                                    }
                                } else {
                                    $default = $mod['chars'][$char['id']];
                                }
                                ?>
                                <input type="text" name="chars[<?php echo $char['id']; ?>]" style="width:99%" value="<?php echo htmlspecialchars($default); ?>"/>
                            <?php } ?>

                            <?php //Список выбора
                            if ($char['values']) {
                                $values = explode("\n", $char['values']);
                                if (isset($mod['chars'][$char['id']])) {
                                    $default = $mod['chars'][$char['id']];
                                }
                                ?>
                                <select name="chars[<?php echo $char['id']; ?>]" style="width:100%">
                                    <?php foreach ($values as $value) { ?>
                                        <option value="<?php echo trim($value); ?>" <?php if (trim($value) == trim($default)) {
                                            echo 'selected="selected"';
                                        } ?>><?php echo trim($value); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>

                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php

        } else {

            echo 'Нет характеристик назначенных для этой категории';

        }

        echo str_replace("\t", '', ob_get_clean());

        exit;

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_item' || $opt == 'edit_item') {

        $inCore->includeFile('includes/jwtabs.php');

        $GLOBALS['cp_page_head'][] = jwHeader();
        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/includes/jquery/multifile/jquery.multifile.js"></script>';

        if ($opt == 'add_item') {

            echo '<h3>Добавить товар</h3>';
            cpAddPathway('Добавить товар', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_item');

        } else {

            if (isset($_REQUEST['item'])) {
                $_SESSION['editlist'] = $_REQUEST['item'];
            }

            $ostatok = '';

            if (isset($_SESSION['editlist'])) {
                $id = array_shift($_SESSION['editlist']);
                if (sizeof($_SESSION['editlist']) == 0) {
                    unset($_SESSION['editlist']);
                } else {
                    $ostatok = '(На очереди: ' . sizeof($_SESSION['editlist']) . ')';
                }
            } else {
                $id = $_REQUEST['item_id'];
            }

            $mod = $model->getItem($id, false);

            $itemParts = $model->getParamsItem($id);


            echo '<h3>Товар: <span style="color:#808080">' . $mod['title'] . '</span> ' . $ostatok . '</h3>';
            cpAddPathway('Категории и товары', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_item&item_id=' . $id);

        }

        if ($opt == 'edit_item' || isset($_REQUEST['cat_id'])) {

            if ($opt == 'edit_item') {
                $cat_id = $mod['category_id'];
            } else {
                $cat_id = $_REQUEST['cat_id'];
            }

            $cat = $model->getCategory($cat_id);

            $mod['price'] = isset($mod['price']) ? number_format($mod['price'], 2, '.', '') : '0.00';

            ?>

            <?php cpCheckWritable('/images/photos', 'folder'); ?>
            <?php cpCheckWritable('/images/photos/medium', 'folder'); ?>
            <?php cpCheckWritable('/images/photos/small', 'folder'); ?>

            <form action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>" method="post" enctype="multipart/form-data" name="addform" id="addform" data-toggle="validator">
                <table class="proptable" width="100%" cellpadding="15" cellspacing="2">
                    <tr>

                        <?php if ($opt == 'add_item' || $inCore->inRequest('added')) {

                            $added_id = $inCore->request('added', 'int', 0);

                            if ($added_id) {
                                $item = $inDB->get_field('cms_shop_items', "id={$added_id}", 'title');
                                echo '<div style="color:green">Товар &laquo;' . $item . '&raquo; добавлен успешно</div>';
                            }

                        } ?>

                        <!-- главная ячейка -->
                        <td valign="top">

                            <table width="100%" cellpadding="5" cellspacing="0" border="0">
                                <tr>
                                    <td valign="top" width="80">
                                        <div class="form-group">
                                            <label for="art_no" class="">Артикул</label>
                                            <input class="form-control" name="art_no" type="text" id="art_no" style="width:80px;" value="<?php echo htmlspecialchars($mod['art_no']); ?>"/>
                                        </div>
                                    </td>
                                    <td valign="top" width="120">
                                        <div class="form-group">
                                            <label class="" for="ven_code">Код произв-ля</label>
                                            <input class="form-control" name="ven_code" type="text" id="ven_code" style="width:120px;" onchange="checkVencode()" value="<?php echo htmlspecialchars($mod['ven_code']); ?>" required/>
                                            <div id="error_ven_code" class=""></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                        <div class="form-group">
                                            <label class="" for="title">Название товара</label>
                                            <input class="form-control" name="title" type="text" id="title" style="width:97%" value="<?php echo htmlspecialchars($mod['title']); ?>" required/>
                                        </div>
                                    </td>

                                    <td valign="top" width="120">
                                        <div><strong>Считать новинкой</strong></div>
                                        <div class="form-group">
                                            <input class="form-control" name="pubdate" type="text" id="pubdate" style="width:120px;" <?php if (@!$mod['pubdate']) {
                                                echo 'value="' . date('Y-m-d') . '"';
                                            } else {
                                                echo 'value="' . $mod['pubdate'] . '"';
                                            } ?>/>
                                            <?php
                                            //include javascript
                                            if (@!$mod['pubdate']) {
                                                $GLOBALS['cp_page_head'][] = '<script type="text/javascript">$(document).ready(function(){$(\'#pubdate\').datepicker({startDate:\'01/01/1996\'}).val(\'' . date('d.m.Y') . '\').trigger(\'change\');});</script>';
                                            } else {
                                                $GLOBALS['cp_page_head'][] = '<script type="text/javascript">$(document).ready(function(){$(\'#pubdate\').datepicker({startDate:\'01/01/1996\'}).val(\'' . $mod['pubdate'] . '\').trigger(\'change\');});</script>';
                                            }
                                            ?>
                                            <input class="form-control" type="hidden" name="olddate" value="<?php echo @$mod['pubdate'] ?>"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <hr/>
                            <table width="100%" cellpadding="5" cellspacing="0" border="0">
                                <tr>
                                    <td valign="top" width="80">
                                        <div><strong>Цена</strong></div>
                                        <div>
                                            <input name="price" type="text" id="price" style="width:80px" value="<?php echo htmlspecialchars($mod['price']); ?>"/>
                                        </div>
                                    </td>
                                    <td width="12" valign="" style="padding:0px">
                                        <a href="#" style="text-decoration:none" title="Перенести цену" style="padding-top:4px" onclick="$('input#old_price').val($('input#price').val());$('input#price').val('').focus();">
                                            <img src="components/shop/images/arrow.gif" border="0" </a>
                                    </td>
                                    <td valign="top" width="50">
                                        <div><strong>Старая цена</strong></div>
                                        <div>
                                            <input name="old_price" type="text" id="old_price" style="width:80px" value="<?php echo htmlspecialchars($mod['old_price']); ?>"/>
                                        </div>
                                    </td>

                                    <td valign="top" width="80">
                                        <div><strong>На складе</strong></div>
                                        <div>
                                            <input name="qty" type="text" id="qty" style="width:80px" value="<?php echo htmlspecialchars($mod['qty']); ?>"/>
                                        </div>
                                    </td>
                                    <td valign="top" width="80">
                                        <div><strong>Вес, кг</strong></div>
                                        <div>
                                            <input name="ves" type="text" id="ves" style="width:80px" value="<?php echo htmlspecialchars($mod['ves']); ?>"/>
                                        </div>
                                    </td>
                                    <td valign="top" width="80">
                                        <div><strong>Объем, кв м</strong></div>
                                        <div>
                                            <input name="vol" type="text" id="vol" style="width:80px" value="<?php echo htmlspecialchars($mod['vol']); ?>"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div><strong>Наверх списка</strong></div>
                                        <div>
                                            <label><input name="ordering" type="checkbox" id="ordering" value="1"/> Поднять</label>
                                        </div>
                                    </td>
                                </tr>

<!--                                <tr>-->
<!--                                    <td>-->
<!--                                        <div>-->
<!--                                            <strong>Название</strong>-->
<!--                                        </div>-->
<!--                                        <div>-->
<!--                                            <input name="partItem" type="text" id="vol" style="width:300px" value="--><?php //echo htmlspecialchars($itemParams['partItem']); ?><!--"/>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>-->
<!--                                        <div><strong>Ширина</strong></div>-->
<!--                                        <div>-->
<!--                                            <input name="widthItem" type="text" id="vol" style="width:80px" value="--><?php //echo htmlspecialchars($itemParams['widthItem']); ?><!--"/>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <div><strong>Высота</strong></div>-->
<!--                                        <div>-->
<!--                                            <input name="heightItem" type="text" id="vol" style="width:80px" value="--><?php //echo htmlspecialchars($itemParams['heightItem']); ?><!--"/>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <div><strong>Глубина</strong></div>-->
<!--                                        <div>-->
<!--                                            <input name="depthItem" type="text" id="vol" style="width:80px" value="--><?php //echo htmlspecialchars($itemParams['depthItem']); ?><!--"/>-->
<!--                                        </div>-->
<!--                  list_items                  </td>-->
<!--                                    <td valign="top" width="80">-->
<!--                                        <div><strong>Вес, кг</strong></div>-->
<!--                                        <div>-->
<!--                                            <input name="weightItem" type="text" id="ves" style="width:80px" value="--><?php //echo htmlspecialchars($ItemParams['weightItem']); ?><!--"/>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->

                            </table>
<!--    RA      -->
                            <table class="params-item">
                                <tr>

                                    <th width="200" class="text-center">Название</th>
                                    <th width="50">Ширина(см.)</th>
                                    <th width="50">Высота(см.)</th>
                                    <th width="50">Глубина(см.)</th>
                                    <th width="50">Вес(кг.)</th>
                                    <th width="50">Действия</th>
                                </tr>

                            <?php echo $model->generateRowPartsItem($itemParts); ?>

                                <tr name="addPartItem">
                                    <td class="">
                                        <img id="buttonAddPart" class="img-fluid" src="/admin/images/icons/hmenu/add.png" alt="" >
                                    </td>
                                </tr>

                            </table>
<!--   /RA      -->
                            <hr/>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <!-- CHARS -->
                                    <td width="100%" valign="top">
                                        <div style="margin-top:10px"><strong>Характеристики товара</strong></div>
                                        <div id="item_chars" style="padding:5px;background:#ECECEC;margin-top:10px;margin-bottom:10px;margin-right:10px;">
                                            <!-- -->
                                        </div>
                                        <script type="text/javascript">
                                            loadItemChars(<?php echo $_REQUEST['id']; ?>, <?php echo $cat_id; ?>, <?php echo $mod['id'] ? $mod['id'] : 0; ?>);
                                        </script>
                                    </td>

                                    <!--
                                <td valign="top">
                                    <div style="margin-top:10px"><strong>Разновидности товара</strong></div>
                                    <div style="padding:5px;background:#ECECEC;margin-top:10px;margin-bottom:10px;margin-right:0px;">

                                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="variants">
                                            <tr>
                                                <td width="53">Артикул</td>
                                                <td>Название</td>
                                                <td width="63">Цена</td>
                                                <td width="63">На складе</td>
                                                <td width="17" class="char_del">&nbsp;</td>
                                            </tr>
                                            <?php if (!$mod['vars']) { ?>
                                            <tr class="var">
                                                <td><input type="text" name="vars_art_no[]" style="width:50px" /></td>
                                                <td><input type="text" name="vars_title[]" style="width:99%" /></td>
                                                <td><input type="text" name="vars_price[]" style="width:60px" /></td>
                                                <td><input type="text" name="vars_qty[]" style="width:60px" /></td>
                                                <td width="17" class="char_del">
                                                    <a href="javascript:" onclick="deleteVariant(this)" title="Удалить вариант">
                                                        <img src="/admin/images/actions/delete.gif" alt="Удалить вариант" border="0">
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } else { ?>
                                                <?php foreach ($mod['vars'] as $var) { ?>
                                                     <tr class="var">
                                                        <td><input type="text" name="vars_art_no[]" style="width:50px" value="<?php echo htmlspecialchars($var['art_no']); ?>" /></td>
                                                        <td><input type="text" name="vars_title[]" style="width:99%" value="<?php echo htmlspecialchars($var['title']); ?>" /></td>
                                                        <td><input type="text" name="vars_price[]" style="width:60px" value="<?php echo htmlspecialchars($var['price']); ?>" /></td>
                                                        <td><input type="text" name="vars_qty[]" style="width:60px" value="<?php echo htmlspecialchars($var['qty']); ?>" /></td>
                                                        <td width="17" class="char_del">
                                                            <a href="javascript:" onclick="deleteVariant(this)" title="Удалить разновидность">
                                                                <img src="/admin/images/actions/delete.gif" alt="Удалить разновидность" border="0">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </table>

                                        <script type="text/javascript">
                                            updateVariants();
                                        </script>

                                        <div style="margin:5px;margin-bottom:10px;">
                                            <a href="javascript:addVariant()">Добавить разновидность</a>
                                        </div>

                                    </div>
                                </td>
								-->
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="checklist">
                                <?php if ($is_shop) { ?>
                                    <tr>
                                        <td width="20">
                                            <input type="checkbox" name="canmany" id="canmany" value="1" <?php if (@$mod['canmany']) {
                                                echo 'checked="checked"';
                                            } ?>/></td>
                                        <td>
                                            <label for="canmany"><strong>Разрешить выбор количества при заказе этого товара</strong></label>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <div><strong>Сопутствующие товары, артикулы ч/з запятую без пробелов</strong></div>
                            <div>
                                <input name="shortdesc" type="text" id="shortdesc" style="width:99%" value="<?php echo htmlspecialchars($mod['shortdesc']); ?>"/>
                            </div>


                            <div style="margin-top:12px"><strong>Подробное описание</strong></div>
                            <div><?php $inCore->insertEditor('description', $mod['description'], '400', '100%'); ?></div>

                            <!--
                        <div><strong>Теги товара</strong></div>
                        <div><input name="tags" type="text" id="tags" style="width:99%" value="<?php if (isset($mod['id'])) {
                                echo htmlspecialchars(cmsTagLine('shop', $mod['id'], false));
                            } ?>" /></div>
-->
                        </td>

                        <!-- боковая ячейка -->
                        <td width="300" valign="top" style="background:#ECECEC;">

                            <?php ob_start(); ?>

                            {tab=Публикация}

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="checklist">
                                <tr>
                                    <td width="20">
                                        <input type="checkbox" name="published" id="published" value="1" <?php if ($mod['published'] || $opt == 'add_item') {
                                            echo 'checked="checked"';
                                        } ?>/></td>
                                    <td><label for="published"><strong>Публиковать товар</strong></label></td>
                                </tr>
                                <tr>
                                    <td width="20">
                                        <input type="checkbox" name="is_front" id="is_front" value="1" <?php if ($mod['is_front']) {
                                            echo 'checked="checked"';
                                        } ?>/></td>
                                    <td><label for="is_front"><strong>На витрине</strong></label></td>
                                </tr>
                                <tr>
                                    <td width="20">
                                        <input type="checkbox" name="is_hit" id="is_hit" value="1" <?php if ($mod['is_hit']) {
                                            echo 'checked="checked"';
                                        } ?>/></td>
                                    <td><label for="is_hit"><strong>Хит продаж</strong></label></td>
                                </tr>
                                <tr>
                                    <td width="20">
                                        <input type="checkbox" name="is_spec" id="is_spec" value="1" <?php if ($mod['is_spec']) {
                                            echo 'checked="checked"';
                                        } ?>/></td>
                                    <td><label for="is_hit"><strong>Акцыя</strong></label></td>
                                </tr>
                            </table>
                            <!--
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="checklist" style="margin-top:5px;">
                            <tr>
                                <td width="20"><input type="checkbox" onclick="$('#file_div').toggle();$('#will_del').toggle()" name="is_digital" id="is_digital" value="1" <?php if ($mod['is_digital']) {
                                echo 'checked="checked"';
                            } ?>/></td>
                                <td><label for="is_digital"><strong>Цифровой товар</strong></label></td>
                            </tr>
                            <?php if ($mod['filename_orig']) { ?>
                            <tr>
                                <td width="20" valign="top"><?php echo $inCore->fileIcon($mod['filename_orig']); ?></td>
                                <td valign="top"><?php echo $mod['filename_orig']; ?> <span id="will_del" style="display:none;color:red"><small>(будет удален)</small></span><div style="color:gray"><small>(<?php echo $mod['filesize_format']; ?>, <?php echo $mod['filedate']; ?>)</small></div></td>
                            </tr>
                            <?php } ?>
                        </table>

                        <div id="file_div" style="margin-bottom:10px;margin-top:2px;<?php if (!$mod['is_digital']) {
                                echo 'display:none';
                            } ?>">
                            <input type="file" name="itemfile" style="width:100%" />
                        </div>
						-->
                            <div style="margin-top:15px">
                                <strong>Ссылка на каспи кз</strong>
                            </div>
                            <div>
                                <input name="kaspikz" style="width:100%" value="<?php echo htmlspecialchars($mod['kaspikz']); ?>"/>
                            </div>


                            <div style="margin-top:15px">
                                <strong>Производитель</strong>
                            </div>
                            <div>
                                <select name="vendor_id" style="width:100%">
                                    <option value="0" <?php if (!$mod['vendor_id']) {
                                        echo 'selected="selected"';
                                    } ?>>---
                                    </option>
                                    <?php echo $inCore->getListItems('cms_shop_vendors', $mod['vendor_id'], 'title'); ?>
                                </select>
                            </div>

                            <div style="margin-top:15px">
                                <strong>Категория</strong>
                            </div>
                            <div>
                                <select name="cat_id" style="width:100%" onchange="loadItemChars(<?php echo $_REQUEST['id']; ?>, $(this).val(), <?php echo $mod['id'] ? $mod['id'] : 0; ?>)">
                                    <?php
                                    if ($opt == 'edit_item') {
                                        echo $inCore->getListItemsNS('cms_shop_cats', $mod['category_id']);
                                    } else {
                                        echo $inCore->getListItemsNS('cms_shop_cats', $cat_id);
                                    }
                                    ?>
                                </select>
                            </div>

                            <div style="margin-top:15px">
                                <strong>Дополнительные категории</strong><br/>
                                <span class="hinttext">Можно выбрать несколько, удерживая CTRL</span>
                            </div>
                            <div>
                                <select name="cats[]" id="cats" style="width:100%" size="6" multiple="1" <?php if ($mod['bind_all']) {
                                    echo 'disabled="disabled"';
                                } ?>>
                                    <?php

                                    $sql = "SELECT title, id, NSLevel, NSLeft
                                           FROM cms_shop_cats
                                           WHERE parent_id>0
                                           ORDER BY NSLeft";
                                    $res = $inDB->query($sql);

                                    if ($inDB->num_rows($res)) {
                                        while ($cat = $inDB->fetch_assoc($res)) {
                                            $pad = str_repeat('--', $cat['NSLevel'] - 1);
                                            $sel = in_array($cat['id'], $mod['cats']) ? 'selected="selected"' : '';
                                            echo '<option value="' . $cat['id'] . '" ' . $sel . '>' . $pad . ' ' . $cat['title'] . '</option>';
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                            <div style="margin-top:15px">
                                <strong>URL страницы</strong><br/>
                                <div style="color:gray">Если не указан, генерируется из заголовка</div>
                            </div>
                            <div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td>
                                            <input type="text" name="url" value="<?php echo htmlspecialchars($mod['url']); ?>" style="width:100%"/>
                                        </td>
                                        <td width="40" align="center">.html</td>
                                    </tr>
                                </table>
                            </div>

                            <div style="margin-top:15px">
                                <strong>Шаблон товара</strong>
                            </div>
                            <div>
                                <input type="text" name="tpl" value="<?php echo $mod['tpl']; ?>" style="width:99%"/>
                            </div>

                            {tab=Фото}

                            <?php
                            if ($opt == 'edit_item') {
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $mod['id'] . '.jpg')) {
                                    ?>
                                    <div style="margin-top:3px;margin-bottom:3px;padding:10px;border:solid 1px gray;text-align:center">
                                        <img src="/images/photos/small/shop<?php echo $mod['id']; ?>.jpg" border="0"/>
                                        <div>
                                            <label><input type="checkbox" name="img_delete[]" class="input" value="shop<?php echo $mod['id']; ?>.jpg"/> Удалить</label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($mod['images']) {
                                    ?>
                                    <div style="margin-top:3px;margin-bottom:3px;padding:10px;border:solid 1px gray;overflow:hidden">
                                        <div style="clear:both" class="hinttext">Отмеченные изображения будут удалены</div>
                                        <?php
                                        foreach ($mod['images'] as $num => $filename) {
                                            ?>
                                            <div style="width:67px;height:80px;float:left;text-align:center">
                                                <img src="/images/photos/small/<?php echo $filename; ?>" width="64" height="64" border="0"/>
                                                <div style="width:45px;background:url(/admin/components/shop/images/del_small.gif) no-repeat right center;">
                                                    <input type="checkbox" name="img_delete[]" class="input" value="<?php echo $filename; ?>"/>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <div style="margin-top:15px"><strong>Изображение</strong></div>
                            <div style="margin-bottom:4px">
                                <input type="file" name="imgfile" style="width:100%"/>
                            </div>
                            <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:4px">
                                <tr>
                                    <td><input type="checkbox" id="auto_thumb" name="auto_thumb" value="1"/></td>
                                    <td><label for="auto_thumb">Создать маленькое автоматически</label></td>
                                </tr>
                            </table>

                            <div style="margin-top:15px"><strong>Маленькое изображение</strong></div>
                            <div style="margin-bottom:10px">
                                <input type="file" name="imgfile_small" style="width:100%"/>
                            </div>

                            <div style="margin-top:15px">
                                <strong>Дополнительные изображения</strong><br/>
                                <span class="hinttext">Можно выбрать несколько файлов</span>
                            </div>
                            <div style="margin-bottom:10px">
                                <input type="file" class="multi" name="upfile[]" id="upfile"/>
                            </div>

                            {tab=SEO}

                            <div style="margin-top:5px">
                                <strong>Ключевые слова</strong><br/>
                                <span class="hinttext">Через запятую, 10-15 слов</span>
                            </div>
                            <div>
                                <textarea name="metakeys" style="width:97%" rows="2" id="metakeys"><?php echo $mod['metakeys']; ?></textarea>
                            </div>

                            <div style="margin-top:20px">
                                <strong>Описание</strong><br/> <span class="hinttext">Не более 250 символов</span>
                            </div>
                            <div>
                                <textarea name="metadesc" style="width:97%" rows="4" id="metadesc"><?php echo $mod['metadesc']; ?></textarea>
                            </div>

                            {/tabs}

                            <?php echo jwTabs(ob_get_clean()); ?>

                        </td>

                    </tr>
                </table>

                <?php if ($opt == 'add_item') { ?>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="checklist">
                        <tr>
                            <td width="20">
                                <input type="checkbox" name="add_again" id="add_again" value="1" <?php if ($inCore->inRequest('added')) {
                                    echo 'selected="selected"';
                                } ?>/></td>
                            <td><label for="add_again">Добавить еще один товар после сохранения</label></td>
                        </tr>
                    </table>
                <?php } ?>
                <p>
                    <input name="add_mod" type="submit" id="add_mod" value="Сохранить товар"/>
                    <input name="back2" type="button" id="back2" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
                    <input name="opt" type="hidden" id="do" <?php if ($opt == 'add_item') {
                        echo 'value="submit_item"';
                    } else {
                        echo 'value="update_item"';
                    } ?> />
                    <?php
                    if ($opt == 'edit_item') {
                        echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                    }
                    ?>
                </p>
            </form>

            <?php
        } else {
            echo '<h4>Выберите категорию:</h4>';

            $sql = "SELECT id, title, NSLeft, NSLevel, parent_id
                            FROM cms_shop_cats
                            WHERE parent_id > 0
                            ORDER BY NSLeft";
            $result = $inDB->query($sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<div style="padding:10px">';
                while ($cat = mysqli_fetch_assoc($result)) {
                    echo '<div style="padding:2px;padding-left:18px;margin-left:' . (($cat['NSLevel'] - 1) * 15) . 'px;background:url(/admin/images/icons/hmenu/cats.png) no-repeat">
                                          <a href="?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_item&cat_id=' . $cat['id'] . '">' . $cat['title'] . '</a>
                                      </div>';
                }
                echo '</div>';
            }

        }
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_cat' || $opt == 'edit_cat') {

        require('../includes/jwtabs.php');
        $GLOBALS['cp_page_head'][] = jwHeader();

        if ($opt == 'add_cat') {

            echo '<h3>Добавить категорию</h3>';
            cpAddPathway('Категории и товары', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
            cpAddPathway('Добавить категорию', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_cat');

            $mod['config']['icon'] = 'shop_category.png';

        } else {

            if (isset($_REQUEST['item_id'])) {

                $id = (int)$_REQUEST['item_id'];
                $sql = "SELECT * FROM cms_shop_cats WHERE id = $id LIMIT 1";
                $result = $inDB->query($sql);

                if (mysqli_num_rows($result)) {
                    $mod = mysqli_fetch_assoc($result);
                    $seolink = explode('/', $mod['seolink']);
                    $mod['seolink'] = $seolink[sizeof($seolink) - 1];
                    $mod['config'] = $inCore->yamlToArray($mod['config']);

                    if (!$mod['config']['icon']) {
                        $mod['config']['icon'] = 'shop_category.png';
                    }
                }

            }

            cpAddPathway('Категории и товары', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_items');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_cat&item_id=' . $_REQUEST['item_id']);
            echo '<h3>Категория: <span style="color:gray">' . $mod['title'] . '</span></h3>';

        }
        ?>

        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>" enctype="multipart/form-data">
            <table class="proptable" width="100%" cellpadding="15" cellspacing="2">
                <tr>

                    <!-- главная ячейка -->
                    <td valign="top">

                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td><strong>Название категории</strong></td>
                                <td rowspan="2" width="50" align="center" valign="bottom">
                                    <div style="padding:5px;border:dotted 1px #ccc;margin-left:10px;margin-right:10px;">
                                        <img src="/images/photos/small/<?php echo $mod['config']['icon']; ?>"/>
                                    </div>
                                </td>
                                <td width="250">
                                    <strong>Иконка категории <span style="color:gray">(32x32)</span></strong>
                                    <?php if ($opt == 'edit_cat' && $mod['config']['icon'] != 'shop_category.png') { ?>
                                        <span style="margin-left:50px">
                                                <label>
                                                    <input type="checkbox" name="del_icon" value="1"/> Сбросить
                                                </label>
                                            </span>
                                    <?php } ?>
                                </td>
                                <td width="190" style="padding-left:6px">
                                    <strong>Шаблон категории</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="title" type="text" id="title" style="width:99%" value="<?php echo htmlspecialchars($mod['title']); ?>"/>
                                </td>
                                <td><input name="icon" type="file"/></td>
                                <td style="padding-left:6px">
                                    <input name="tpl" type="text" style="width:98%" value="<?php echo htmlspecialchars($mod['tpl']); ?>"/>
                                </td>
                            </tr>
                        </table>

                        <div></div>
                        <div></div>

                        <div style="margin-top:12px"><strong>Описание категории</strong></div>
                        <div><?php $inCore->insertEditor('description', $mod['description'], '400', '100%'); ?></div>

                    </td>

                    <!-- боковая ячейка -->
                    <td width="300" valign="top" style="background:#ECECEC;">

                        <?php ob_start(); ?>

                        {tab=Публикация}

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="checklist">
                            <tr>
                                <td width="20">
                                    <input type="checkbox" name="published" id="published" value="1" <?php if ($mod['published'] || $opt == 'add_cat') {
                                        echo 'checked="checked"';
                                    } ?>/></td>
                                <td><label for="published"><strong>Публиковать категорию</strong></label></td>
                            </tr>
                            <tr>
                                <td width="20">
                                    <input type="checkbox" name="is_catalog" id="is_catalog" value="1" <?php if ($mod['is_catalog']) {
                                        echo 'checked="checked"';
                                    } ?>/></td>
                                <td><label for="is_catalog"><strong>Режим каталога (не показывать цены)</strong></label>
                                </td>
                            </tr>
                            <tr>
                                <td width="20">
                                    <input type="checkbox" name="is_xml" id="is_xml" value="1" <?php if ($mod['is_xml']) {
                                        echo 'checked="checked"';
                                    } ?>/></td>
                                <td><label for="is_xml"><strong>Отправлять в XML-фид</strong></label></td>
                            </tr>
                        </table>

                        <div style="margin-top:7px">
                            <select name="parent_id" size="12" id="parent_id" style="width:99%;height:330px">
                                <?php $rootid = getField('cms_shop_cats', 'parent_id=0', 'id'); ?>
                                <option value="<?php echo $rootid; ?>" <?php if (@$mod['parent_id'] == $rootid || !isset($mod['parent_id'])) {
                                    echo 'selected';
                                } ?>>-- Корневая категория --
                                </option>
                                <?php
                                if (isset($mod['parent_id'])) {
                                    echo $inCore->getListItemsNS('cms_shop_cats', $mod['parent_id']);
                                } else {
                                    echo $inCore->getListItemsNS('cms_shop_cats');
                                }
                                ?>
                            </select>
                            <input type="hidden" name="old_parent_id" value="<?php echo $mod['parent_id']; ?>"/>
                        </div>


                        {tab=SEO}

                        <div style="margin-top:15px">
                            <strong>URL категории</strong><br/>
                            <div style="color:gray">Если не указан, генерируется из заголовка</div>
                        </div>
                        <div>
                            <input type="text" name="url" value="<?php echo htmlspecialchars($mod['url']); ?>" style="width:99%"/>
                        </div>
                        <div style="margin-top:20px">
                            <strong>Заголовок страницы</strong>
                        </div>
                        <div>
                            <input type="text" name="pagetitle" value="<?php echo htmlspecialchars($mod['pagetitle']); ?>" style="width:99%"/>
                        </div>

                        <div style="margin-top:20px">
                            <strong>Ключевые слова</strong><br/> <span class="hinttext">Через запятую, 10-15 слов</span>
                        </div>
                        <div>
                            <textarea name="meta_keys" style="width:97%" rows="2" id="meta_keys"><?php echo @$mod['meta_keys']; ?></textarea>
                        </div>

                        <div style="margin-top:20px">
                            <strong>Описание</strong><br/> <span class="hinttext">Не более 250 символов</span>
                        </div>
                        <div>
                            <textarea name="meta_desc" style="width:97%" rows="4" id="meta_desc"><?php echo @$mod['meta_desc']; ?></textarea>
                        </div>


                        {/tabs}

                        <?php echo jwTabs(ob_get_clean()); ?>

                    </td>

                </tr>
            </table>
            <p>
                <input name="add_mod" type="submit" id="add_mod" <?php if ($do == 'add_cat') {
                    echo 'value="Создать категорию"';
                } else {
                    echo 'value="Сохранить категорию"';
                } ?> /> <input name="back" type="button" id="back" value="Отмена" onclick="window.history.back();"/>
                <input name="opt" type="hidden" id="opt" <?php if ($opt == 'add_cat') {
                    echo 'value="submit_cat"';
                } else {
                    echo 'value="update_cat"';
                } ?> />
                <?php
                if ($opt == 'edit_cat') {
                    echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                }
                ?>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_discount' || $opt == 'edit_discount') {

        if ($opt == 'add_discount') {
            echo '<h3>Добавить коэффициент</h3>';
            cpAddPathway('Скидки и наценки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts');
            cpAddPathway('Добавить коэффициент', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_discount');
        } else {
            if (isset($_REQUEST['item_id'])) {
                $id = (int)$_REQUEST['item_id'];

                $mod = $model->getDiscount($id);

            }

            echo '<h3>' . $mod['title'] . '</h3>';
            cpAddPathway('Скидки и наценки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_discounts');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_discount&item_id=' . $_REQUEST['item_id']);
        }
        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">
            <table width="584" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width="250"><strong>Название: </strong></td>
                    <td width="315" valign="top">
                        <input name="title" type="text" id="title" style="width:300px" value="<?php echo @$mod['title']; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><strong>Тип: </strong></td>
                    <td valign="top"><label>
                            <select name="sign" id="sign" style="width:307px" onchange="toggleDiscountLimit()">
                                <option value="-1" <?php if (@$mod['sign'] == -1) {
                                    echo 'selected';
                                } ?>>Скидка
                                </option>
                                <option value="1" <?php if (@$mod['sign'] == 1) {
                                    echo 'selected';
                                } ?>>Наценка
                                </option>
                            </select> </label></td>
                </tr>
                <tr>
                    <td>
                        <strong>Значение: </strong>
                    </td>
                    <td valign="top">
                        <input name="amount" type="text" id="amount" style="width:80px" value="<?php if ($opt == 'edit_discount') {
                            echo $mod['amount'];
                        } ?>"/> <select name="is_percent" id="is_percent" style="width:60px">
                            <option value="1" <?php if ($mod['is_percent']) {
                                echo 'selected';
                            } ?>>%
                            </option>
                            <option value="0" <?php if (!$mod['is_percent']) {
                                echo 'selected';
                            } ?>><?php echo $cfg['currency']; ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Срок действия: </strong></td>
                    <td valign="top"><label> <select name="is_forever" id="sign" style="width:307px">
                                <option value="1" <?php if ($mod['is_forever']) {
                                    echo 'selected';
                                } ?>>Неограничен
                                </option>
                                <option value="0" <?php if (!$mod['is_forever']) {
                                    echo 'selected';
                                } ?>>До указанной даты
                                </option>
                            </select> </label></td>
                </tr>
                <tr>
                    <td>
                        <strong>Действует до: </strong>
                    </td>
                    <td valign="top">
                        <input name="date_until" type="text" id="date_until" style="width:142px" value="<?php echo $mod['date_until']; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <strong>Только для категорий:</strong><br/>
                        <span class="hinttext">Если не выбрано, действует<br/> для всех категорий магазина.</span> <br/>
                        <span class="hinttext">Можно выбрать несколько,<br/> удерживая CTRL</span>
                    </td>
                    <td valign="top">
                        <select name="cats[]" id="cats" style="width:307px" size="10" multiple="1">
                            <?php

                            $sql = "SELECT title, id, NSLevel, NSLeft
                                           FROM cms_shop_cats
                                           WHERE parent_id>0
                                           ORDER BY NSLeft";
                            $res = $inDB->query($sql);

                            if ($inDB->num_rows($res)) {
                                while ($cat = $inDB->fetch_assoc($res)) {
                                    $pad = str_repeat('--', $cat['NSLevel'] - 1);
                                    if (is_array($mod['cats'])) {
                                        $sel = in_array($cat['id'], $mod['cats']) ? 'selected="selected"' : '';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option value="' . $cat['id'] . '" ' . $sel . '>' . $pad . ' ' . $cat['title'] . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <strong>Только для групп:</strong><br/> <span class="hinttext">Если не выбрано, действует<br/> для всех пользователей</span>
                        <br/> <span class="hinttext">Можно выбрать несколько,<br/> удерживая CTRL</span>
                    </td>
                    <td valign="top">
                        <select name="groups[]" id="groups" style="width:307px" size="5" multiple="1">
                            <?php

                            $sql = "SELECT title, id
                                           FROM cms_user_groups
                                           WHERE alias <> 'guest'
                                           ORDER BY title";
                            $res = $inDB->query($sql);

                            if ($inDB->num_rows($res)) {
                                while ($group = $inDB->fetch_assoc($res)) {
                                    if (is_array($mod['groups'])) {
                                        $sel = in_array($group['id'], $mod['groups']) ? 'selected="selected"' : '';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option value="' . $group['id'] . '" ' . $sel . '>' . $group['title'] . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <p>
                <input name="add_mod" type="submit" id="add_mod" <?php if ($opt == 'add_discount') {
                    echo 'value="Создать"';
                } else {
                    echo 'value="Сохранить изменения"';
                } ?> />
                <input name="back3" type="button" id="back3" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
                <input name="opt" type="hidden" id="do" <?php if ($opt == 'add_discount') {
                    echo 'value="submit_discount"';
                } else {
                    echo 'value="update_discount"';
                } ?> />
                <?php
                if ($opt == 'edit_discount') {
                    echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                }
                ?>
            </p>
        </form>

        <script type="text/javascript">

            $(document).ready(function () {
                var datePickerOptions = {showStatus: true, showOn: "focus"};
                $('#date_until').datepicker({
                    showOn: "both",
                    buttonImage: "/admin/images/icons/calendar.png",
                    buttonImageOnly: true,
                    dateFormat: 'yy-mm-dd'
                });

            });

        </script>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_char' || $opt == 'edit_char') {

        $char_groups = $model->getCharGroups();

        if ($opt == 'add_char') {
            echo '<h3>Новая характеристика</h3>';
            cpAddPathway('Новая характеристика', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_char');
        } else {
            if (isset($_REQUEST['item_id'])) {
                $id = $_REQUEST['item_id'];
                $sql = "SELECT * FROM cms_shop_chars WHERE id = $id LIMIT 1";
                $result = $inDB->query($sql);
                if (mysqli_num_rows($result)) {
                    $mod = mysqli_fetch_assoc($result);
                    $mod['cats'] = array();
                    $catres = $inDB->query("SELECT cat_id FROM cms_shop_chars_bind WHERE char_id={$mod['id']}");
                    if (mysqli_num_rows($catres)) {
                        while ($cat = mysqli_fetch_assoc($catres)) {
                            $mod['cats'][] = $cat['cat_id'];
                        }
                    }

                    $mod['val_count'] = $model->getCharValuesCount($id);

                }
            }

            echo '<h3>' . $mod['title'] . '</h3>';
            cpAddPathway('Характеристики товаров', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_char&item_id=' . $_REQUEST['item_id']);
        }
        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">
            <?php if ($mod['val_count']) { ?>
                <table width="600" border="0" cellspacing="5" height="35" class="proptable" style="background:#ECECEC">
                    <tr>
                        <td width=""><strong>Характеристика используется: </strong></td>
                        <td width="315">
                            <?php echo spellcount($mod['val_count'], 'товар', 'товара', 'товаров'); ?> |
                            <a href="?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>&opt=edit_char_values&item_id=<?php echo $_REQUEST['item_id']; ?>"> Редактировать значения </a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <table width="600" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width=""><strong>Название: </strong></td>
                    <td width="315" valign="top">
                        <input name="title" type="text" id="title" style="width:300px" value="<?php echo htmlspecialchars($mod['title']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><strong>Тип характеристики: </strong></td>
                    <td valign="top">
                        <select name="fieldtype" id="fieldtype" style="width:307px" onchange="">
                            <option value="text" <?php if (@$mod['fieldtype'] == 'text') {
                                echo 'selected';
                            } ?>>Текстовое поле
                            </option>
                            <option value="int" <?php if (@$mod['fieldtype'] == 'int') {
                                echo 'selected';
                            } ?>>Число
                            </option>
                            <option value="cbox" <?php if (@$mod['fieldtype'] == 'cbox') {
                                echo 'selected';
                            } ?>>Набор опций
                            </option>
                            <option value="link" <?php if (@$mod['fieldtype'] == 'link') {
                                echo 'selected';
                            } ?>>Гиперссылка
                            </option>
                            <option value="email" <?php if (@$mod['fieldtype'] == 'email') {
                                echo 'selected';
                            } ?>>Адрес электронной почты
                            </option>
                            <option value="file" <?php if (@$mod['fieldtype'] == 'file') {
                                echo 'selected';
                            } ?>>Файл
                            </option>
                            <option value="gmap" <?php if (@$mod['fieldtype'] == 'gmap') {
                                echo 'selected';
                            } ?>>Адрес на Google Maps
                            </option>
                            <option value="ymap" <?php if (@$mod['fieldtype'] == 'ymap') {
                                echo 'selected';
                            } ?>>Адрес на Яндекс.Картах
                            </option>
                            <option value="user" <?php if (@$mod['fieldtype'] == 'user') {
                                echo 'selected';
                            } ?>>Ссылка на профиль пользователя
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="">
                        <strong>Группа: </strong>
                    </td>
                    <td width="315" valign="top">
                        <select name="fieldgroup" id="fieldgroup" style="width:307px">
                            <option value="">---</option>
                            <?php foreach ($char_groups as $group) { ?>
                                <option value="<?php echo $group; ?>" <?php if ($group == $mod['fieldgroup']) { ?>selected="selected"<?php } ?>><?php echo $group; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="">
                        <strong>Создать новую группу: </strong>
                    </td>
                    <td width="315" valign="top">
                        <input name="fieldgroup_new" type="text" id="fieldgroup_new" style="width:300px" value=""/>
                    </td>
                </tr>
                <tr>
                    <td width="">
                        <strong>Единица измерения: </strong><br/>
                        <span class="hinttext">Для числовых характеристик</span>
                    </td>
                    <td width="315" valign="top">
                        <input name="units" type="text" id="units" style="width:300px" value="<?php echo htmlspecialchars($mod['units']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><strong>Значение характеристики: </strong></td>
                    <td valign="top">
                        <input name="is_custom" type="radio" value="0" <?php if (@!$mod['is_custom']) {
                            echo 'checked="checked"';
                        } ?>/> Устанавливается продавцом<br/>
                        <input name="is_custom" type="radio" value="1" <?php if (@$mod['is_custom']) {
                            echo 'checked="checked"';
                        } ?>/> Выбирается покупателем
                    </td>
                </tr>
                <tr>
                    <td><strong>Показывать в товаре: </strong></td>
                    <td valign="top">
                        <input name="published" type="radio" value="1" <?php if (@$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Да <input name="published" type="radio" value="0" <?php if (@!$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Нет
                    </td>
                </tr>
                <tr>
                    <td><strong>Показывать в сравнении товаров: </strong></td>
                    <td valign="top">
                        <input name="is_compare" type="radio" value="1" <?php if (@$mod['is_compare']) {
                            echo 'checked="checked"';
                        } ?>/> Да <input name="is_compare" type="radio" value="0" <?php if (@!$mod['is_compare']) {
                            echo 'checked="checked"';
                        } ?>/> Нет
                    </td>
                </tr>
                <tr>
                    <td><strong>Показывать в фильтре: </strong></td>
                    <td valign="top">
                        <input name="is_filter" type="radio" value="1" <?php if (@$mod['is_filter']) {
                            echo 'checked="checked"';
                        } ?> onclick="$('input[name=is_filter_many]').attr('disabled', '');"/> Да
                        <input name="is_filter" type="radio" value="0" <?php if (@!$mod['is_filter']) {
                            echo 'checked="checked"';
                        } ?> onclick="$('input[name=is_filter_many]').attr('disabled', 'disabled');$('input[name=is_filter_many][value=0]').attr('checked', 'checked');"/> Нет
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Множественный выбор в фильтре: </strong>
                    </td>
                    <td valign="top">
                        <input name="is_filter_many" type="radio" value="1" <?php if (@$mod['is_filter_many'] && $mod['is_filter']) {
                            echo 'checked="checked"';
                        } ?> <?php if (!$mod['is_filter']) {
                            echo 'disabled="disabled"';
                        } ?>/> Да
                        <input name="is_filter_many" type="radio" value="0" <?php if (@!$mod['is_filter_many'] || !$mod['is_filter']) {
                            echo 'checked="checked"';
                        } ?> <?php if (!$mod['is_filter']) {
                            echo 'disabled="disabled"';
                        } ?>/> Нет
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top:5px">
                        <strong>Возможные значения: </strong><br/>
                        <span class="hinttext">Каждое значение с новой строки</span>
                    </td>
                    <td valign="top">
                        <textarea name="values" style="width:293px;" rows="5"><?php echo htmlspecialchars($mod['values']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top:5px">
                        <strong>Используется в категориях: </strong><br/>
                        <span class="hinttext">Можно выбрать несколько, удерживая CTRL</span>
                    </td>
                    <td valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="" style="margin-bottom:5px">
                            <tr>
                                <td width="16">
                                    <input type="checkbox" name="bind_all" id="bind_all" value="1" onclick="toggleBindAll()" <?php if ($mod['bind_all']) {
                                        echo 'checked="checked"';
                                    } ?>>
                                </td>
                                <td><label for="bind_all">Все категории</label></td>
                            </tr>
                        </table>
                        <select name="cats[]" id="cats" style="width:307px" size="10" multiple="1" <?php if ($mod['bind_all']) {
                            echo 'disabled="disabled"';
                        } ?>>
                            <?php

                            $sql = "SELECT title, id, NSLevel, NSLeft
                                           FROM cms_shop_cats
                                           WHERE parent_id>0
                                           ORDER BY NSLeft";
                            $res = $inDB->query($sql);

                            if ($inDB->num_rows($res)) {
                                while ($cat = $inDB->fetch_assoc($res)) {
                                    $pad = str_repeat('--', $cat['NSLevel'] - 1);
                                    $sel = in_array($cat['id'], $mod['cats']) ? 'selected="selected"' : '';
                                    echo '<option value="' . $cat['id'] . '" ' . $sel . '>' . $pad . ' ' . $cat['title'] . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <p>
                <input name="add_mod" type="submit" id="add_mod" <?php if ($opt == 'add_char') {
                    echo 'value="Создать"';
                } else {
                    echo 'value="Сохранить изменения"';
                } ?> />
                <input name="back3" type="button" id="back3" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
                <input name="opt" type="hidden" id="do" <?php if ($opt == 'add_char') {
                    echo 'value="submit_char"';
                } else {
                    echo 'value="update_char"';
                } ?> />
                <?php
                if ($opt == 'edit_char') {
                    echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                }
                ?>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'edit_char_values') {

        if (isset($_REQUEST['item_id'])) {
            $id = (int)$_REQUEST['item_id'];
            $sql = "SELECT * FROM cms_shop_chars WHERE id = $id LIMIT 1";
            $result = $inDB->query($sql);
            if (mysqli_num_rows($result)) {
                $mod = mysqli_fetch_assoc($result);
                $mod['items'] = $model->getCharItems($mod['id']);
            }
        }

        echo '<h3>' . $mod['title'] . ': <span style="color:gray">Значения</span></h3>';

        cpAddPathway('Характеристики товаров', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_chars&all=1');
        cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_char&item_id=' . $_REQUEST['item_id']);
        cpAddPathway('Значения', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_char_values&item_id=' . $_REQUEST['item_id']);

        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">
            <table width="600" border="0" cellspacing="5" class="proptable">
                <?php

                $curr_cat = '';

                foreach ($mod['items'] as $item) {

                    ?>
                    <?php if ($curr_cat != $item['category']) { ?>

                        <tr>
                            <td colspan="2" style="padding:4px;padding-bottom:0px;background:#ECECEC">
                                <div style="font-size:15px;font-weight:bold;padding-left:20px;background: url(/admin/images/icons/hmenu/cats.png) no-repeat;">
                                    <?php echo $item['category']; ?>
                                </div>
                            </td>
                        </tr>

                        <?php $curr_cat = $item['category'];
                    } ?>
                    <tr>
                        <td width="" style="padding-left:15px">
                            <a style="color:#09C" href="?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>&opt=edit_item&item_id=<?php echo $item['id']; ?>" target="_blank">
                                <?php echo $item['title']; ?></a>:
                        </td>
                        <td width="315" valign="top">
                            <?php if (!$mod['values']) { ?>
                                <input name="val[<?php echo $item['id']; ?>]" type="text" style="width:300px" value="<?php echo htmlspecialchars($item['val']); ?>"/>
                            <?php } ?>
                            <?php
                            if ($mod['values']) {
                                $values = explode("\n", $mod['values']);
                                ?>
                                <select name="val[<?php echo $item['id']; ?>]" style="width:100%">
                                    <?php foreach ($values as $value) { ?>
                                        <option value="<?php echo trim($value); ?>" <?php if (trim($value) == trim($item['val'])) {
                                            echo 'selected="selected"';
                                        } ?>><?php echo trim($value); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>

                        </td>
                    </tr>
                <?php } ?>
            </table>
            <p>
                <input name="item_id" type="hidden" value="<?php echo $mod['id']; ?>"/>
                <input name="add_mod" type="submit" id="add_mod" value="Сохранить изменения"/>
                <input name="back3" type="button" id="back3" value="Отмена" onclick="window.history.go(-1)"/>
                <input name="opt" type="hidden" id="opt" value="update_char_values"/>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'config_psys') {

        $item_id = $inCore->request('item_id', 'int', 0);

        $mod = $model->getPaymentSystem($item_id);

        echo '<h3><span style="color:gray">Настройки:</span> ' . $mod['title'] . '</h3>';
        cpAddPathway('Платежные системы', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_psys');
        cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=config_psys&item_id=' . $mod['id']);

        $config = false;

        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">

            <?php if ($mod['config']['currency']) { ?>
                <h3 style="margin-top:0px;font-weight:normal;font-size:16px">Курсы валют</h3>
                <table width="260" border="0" cellspacing="5" class="proptable">
                    <?php foreach ($mod['config']['currency'] as $currency => $kurs) { ?>
                        <?php if ($currency) { ?>
                            <tr>
                                <td width="100" align="right">
                                    <strong>1 <?php echo $currency; ?> = </strong>
                                </td>
                                <td>
                                    <input type="text" name="config[currency][<?php echo $currency; ?>]" value="<?php echo $kurs; ?>" style="width:60px"/> <?php echo htmlspecialchars($cfg['currency']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            <?php } ?>

            <?php if ($mod['config']) { ?>
                <h3 style="font-weight:normal;font-size:16px">Настройки системы</h3>
                <table width="700" border="0" cellspacing="5" class="proptable">
                    <?php foreach ($mod['config'] as $param_id => $param) { ?>
                        <?php if ($param['title']) {
                            $confg = true; ?>
                            <tr>
                                <td width="250">
                                    <strong><?php echo $param['title']; ?>:</strong>
                                    <input type="hidden" name="config[<?php echo $param_id; ?>][title]" value="<?php echo $param['title']; ?>"/>
                                </td>
                                <td>
                                    <input type="text" name="config[<?php echo $param_id; ?>][value]" value="<?php echo htmlspecialchars($param['value']); ?>" style="width:98%"/>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            <?php } ?>

            <?php if (!$confg) { ?>
                <p style="margin-top:0px;margin-bottom:20px;">Платежная система не имеет настроек.</p>
            <?php } ?>

            <p>
                <?php if ($confg) { ?>
                    <input name="add_mod" type="submit" id="add_mod" value="Сохранить изменения"/>
                <?php } ?>
                <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>&opt=list_psys';"/>
                <input name="opt" type="hidden" id="do" value="save_psys_config"/>
                <input name="item_id" type="hidden" value="<?php echo $mod['id']; ?>"/>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_vendor' || $opt == 'edit_vendor') {
        if ($opt == 'add_vendor') {
            echo '<h3>Новый производитель</h3>';
            cpAddPathway('Новый производитель', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_vendor');
        } else {
            if (isset($_REQUEST['item_id'])) {
                $id = $_REQUEST['item_id'];
                $sql = "SELECT * FROM cms_shop_vendors WHERE id = $id LIMIT 1";
                $result = $inDB->query($sql);
                if (mysqli_num_rows($result)) {
                    $mod = mysqli_fetch_assoc($result);
                }
            }

            echo '<h3>' . $mod['title'] . '</h3>';
            cpAddPathway('Производители', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_vendors');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_vendor&item_id=' . $_REQUEST['item_id']);
        }
        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">
            <table width="600" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width=""><strong>Название: </strong></td>
                    <td width="315" valign="top">
                        <input name="title" type="text" id="title" style="width:300px" value="<?php echo htmlspecialchars($mod['title']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td width=""><strong>Описание: </strong></td>
                    <td width="315" valign="top"><?php $inCore->insertEditor('descr', $mod['descr'], '200', '100%'); ?></td>
                </tr>
                <tr>
                    <td><strong>Показывать на сайте: </strong></td>
                    <td valign="top">
                        <input name="published" type="radio" value="1" <?php if (@$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Да <input name="published" type="radio" value="0" <?php if (@!$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Нет
                    </td>
                </tr>
            </table>
            <p>
                <input name="add_mod" type="submit" id="add_mod" <?php if ($opt == 'add_vendor') {
                    echo 'value="Создать"';
                } else {
                    echo 'value="Сохранить изменения"';
                } ?> />
                <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
                <input name="opt" type="hidden" id="do" <?php if ($opt == 'add_vendor') {
                    echo 'value="submit_vendor"';
                } else {
                    echo 'value="update_vendor"';
                } ?> />
                <?php
                if ($opt == 'edit_vendor') {
                    echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                }
                ?>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'add_delivery' || $opt == 'edit_delivery') {
        if ($opt == 'add_delivery') {
            echo '<h3>Новый способ доставки</h3>';
            cpAddPathway('Новый способ доставки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=add_delivery');
        } else {
            if (isset($_REQUEST['item_id'])) {
                $id = $_REQUEST['item_id'];
                $sql = "SELECT * FROM cms_shop_delivery WHERE id = $id LIMIT 1";
                $result = $inDB->query($sql);
                if (mysqli_num_rows($result)) {
                    $mod = mysqli_fetch_assoc($result);
                    $mod['description'] = str_replace('<br />', '', $mod['description']);
                }
            }

            echo '<h3>' . $mod['title'] . '</h3>';
            cpAddPathway('Способы доставки', '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=list_delivery');
            cpAddPathway($mod['title'], '?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=edit_vendor&item_id=' . $_REQUEST['item_id']);
        }
        ?>
        <form id="addform" name="addform" method="post" action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>">
            <table width="600" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width="200"><strong>Название: </strong></td>
                    <td width="" valign="top">
                        <input name="title" type="text" id="title" style="width:98%" value="<?php echo htmlspecialchars($mod['title']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><strong>Показывать на сайте: </strong></td>
                    <td valign="top">
                        <input name="published" type="radio" value="1" <?php if (@$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Да <input name="published" type="radio" value="0" <?php if (@!$mod['published']) {
                            echo 'checked="checked"';
                        } ?>/> Нет
                    </td>
                </tr>
                <tr>
                    <td width="200" valign="top"><strong>Описание: </strong></td>
                    <td width="" valign="top">
                        <textarea name="description" style="width:95%;height:200px"><?php echo htmlspecialchars($mod['description']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="200"><strong>Стоимость: </strong></td>
                    <td width="" valign="top">
                        <input name="price" type="text" id="price" style="width:100px" value="<?php echo htmlspecialchars($mod['price']); ?>"/> <?php echo $cfg['currency']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="200"><strong>Доступно при заказе от:</strong></td>
                    <td width="" valign="top">
                        <input name="minsumm" type="text" id="minsumm" style="width:100px" value="<?php echo htmlspecialchars($mod['minsumm']); ?>"/> <?php echo $cfg['currency']; ?>
                    </td>
                </tr>
                <tr>
                    <td width="200"><strong>Бесплатно при заказе от:</strong></td>
                    <td width="" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-right:2px">
                                    <input name="freesumm" type="text" id="freesumm" style="width:100px" value="<?php echo htmlspecialchars($mod['freesumm']); ?>"/> <?php echo $cfg['currency']; ?> или
                                </td>
                                <td width="16">
                                    <input type="checkbox" id="nofree" name="nofree" value="1" <?php if ($mod['nofree']) {
                                        echo 'checked="checked"';
                                    } ?>/></td>
                                <td><label for="nofree"><strong>Всегда платно</strong></label></td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
            <p>
                <input name="add_mod" type="submit" id="add_mod" <?php if ($opt == 'add_delivery') {
                    echo 'value="Создать"';
                } else {
                    echo 'value="Сохранить изменения"';
                } ?> />
                <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
                <input name="opt" type="hidden" id="do" <?php if ($opt == 'add_delivery') {
                    echo 'value="submit_delivery"';
                } else {
                    echo 'value="update_delivery"';
                } ?> />
                <?php
                if ($opt == 'edit_delivery') {
                    echo '<input name="item_id" type="hidden" value="' . $mod['id'] . '" />';
                }
                ?>
            </p>
        </form>
        <?php
    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'import_xls') {

        cpAddPathway('Импорт из MS Excel', $_SERVER['REQUEST_URI']);
        echo '<h3>Импорт из MS Excel</h3>';

        if ($inCore->inRequest('cat_id')) {
            //load category fields structure
            $cat = getFields('cms_uc_cats', 'id=' . $_REQUEST['cat_id'], 'title, fieldsstruct, view_type');
            $fstruct = unserialize($cat['fieldsstruct']);

            ?>
        <form action="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>" method="POST" enctype="multipart/form-data" name="addform">
            <p><strong>Рубрика:</strong>
                <a href="index.php?view=components&do=config&id=<?php echo $_REQUEST['id']; ?>&opt=import_xls"><?php echo $cat['title']; ?></a>
            </p>
            <p>Выберите файл Excel, в котором находится таблица с характеристиками записей</p>
            <table width="650" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width="300">
                        <strong>Файл таблицы Excel:</strong><br/> <span class="hinttext">В формате *.XLS</span>
                    </td>
                    <td><input type="file" name="xlsfile"/></td>
                </tr>
                <tr>
                    <td width="300">
                        <strong>Кодировка файла:</strong><br/>
                        <span class="hinttext">Зависит от пакета, в котором создавалась таблица</span>
                    </td>
                    <td>
                        <select name="charset" style="width:300px">
                            <option value="cp1251" selected>windows-1251 (MS Office)</option>
                            <option value="UTF-8">utf-8 (OpenOffice)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Количество записей (строк) для импорта:</strong><br/>
                        <span class="hinttext">Большие файлы рекомендуется импортировать по частям</span>
                    </td>
                    <td><input type="text" name="xlsrows" style="width:40px"/> шт.</td>
                </tr>
                <tr>
                    <td><strong>Номер листа с таблицей в файле:</strong></td>
                    <td><input type="text" name="xlslist" style="width:40px" value="1"/></td>
                </tr>
            </table>
            <p>
                Укажите числовые координаты первых ячеек с данными для каждого столбца.<br/> Если какую-либо характеристику нужно брать не из таблицы Excel, а сделать одинаковой для всех записей,<br/> то отметьте для нее галочку "Текст" и введите значение вручную.
            </p>
            <table width="650" border="0" cellspacing="5" class="proptable">
                <tr id="row_title">
                    <td width=""><strong>Название:</strong></td>
                    <td>Столбец:</td>
                    <td>
                        <input type="text" onkeyup="xlsEditCol()" id="title_col" name="cells[title][col]" style="width:40px"/>
                    </td>
                    <td>Строка:</td>
                    <td>
                        <input type="text" onkeyup="xlsEditRow()" id="title_row" name="cells[title][row]" style="width:40px"/>
                    </td>
                    <td width="90">
                        <input type="checkbox" id="ignore_title" name="cells[title][ignore]" onclick="ignoreRow('title')" value="1"/> Текст:
                    </td>
                    <td><input type="text" class="other" name="cells[title][other]" style="width:200px" disabled/></td>
                </tr>
                <?php
                $current = 0;
                foreach ($fstruct as $key => $value) {
                    //strip special markups
                    if (strstr($value, '/~h~/')) {
                        $value = str_replace('/~h~/', '', $value);
                    } elseif (strstr($value, '/~l~/')) {
                        $value = str_replace('/~l~/', '', $value);
                    } else {
                        $ftype = 'text';
                    }
                    if (strstr($value, '/~m~/')) {
                        $value = str_replace('/~m~/', '', $value);
                    }
                    //show field inputs
                    ?>
                    <tr id="row_<?php echo $current; ?>">
                        <td width="150"><strong><?php echo $value; ?>:</strong></td>
                        <td>Столбец:</td>
                        <td>
                            <input type="text" class="col" id="<?php echo $current; ?>" name="cells[<?php echo $current; ?>][col]" style="width:40px"/>
                        </td>
                        <td>Строка:</td>
                        <td>
                            <input type="text" class="row" name="cells[<?php echo $current; ?>][row]" style="width:40px"/>
                        </td>
                        <td>
                            <input type="checkbox" id="ignore_<?php echo $current; ?>" name="cells[<?php echo $current; ?>][ignore]" onclick="ignoreRow('<?php echo $current; ?>')" value="1"/> Текст:
                        </td>
                        <td>
                            <input type="text" class="other" name="cells[<?php echo $current; ?>][other]" style="width:200px" disabled/>
                        </td>
                    </tr>
                    <?php
                    $current++;
                }

                if ($cat['view_type'] == 'shop') {
                    ?>
                    <tr id="row_price">
                        <td width="250"><strong>Цена:</strong></td>
                        <td>Столбец:</td>
                        <td><input type="text" class="col" name="cells[price][col]" style="width:40px"/></td>
                        <td>Строка:</td>
                        <td><input type="text" class="row" name="cells[price][row]" style="width:40px"/></td>
                        <td>
                            <input type="checkbox" id="ignore_price" name="cells[price][ignore]" onclick="ignoreRow('price')" value="1"/> Текст:
                        </td>
                        <td><input type="text" class="other" name="cells[price][other]" style="width:200px" disabled/>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <p>Задайте остальные параметры записей:</p>
            <table width="650" border="0" cellspacing="5" class="proptable">
                <tr>
                    <td width="300">
                        <strong>Публиковать записи:</strong><br/>
                        <span class="hinttext">Если включено, записи сразу появятся на сайте</span>
                    </td>
                    <td>
                        <input name="published" type="radio" value="1" checked="checked"/> Да
                        <input name="published" type="radio" value="0"/> Нет
                    </td>
                </tr>
                <tr>
                    <td><strong>Разрешить комментарии:</strong></td>
                    <td>
                        <input name="is_comments" type="radio" value="1" checked="checked"/> Да
                        <input name="is_comments" type="radio" value="0"/> Нет
                    </td>
                </tr>
                <?php if ($cat['view_type'] == 'shop') { ?>
                    <tr>
                        <td>
                            <strong>Разрешить выбор количества:</strong><br/>
                            <span class="hinttext">При заказе товара</span>
                        </td>
                        <td>
                            <input name="canmany" type="radio" value="1" checked="checked"/> Да
                            <input name="canmany" type="radio" value="0"/> Нет
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        <strong>Тэги записей:</strong><br/> <span class="hinttext">Не обязательно</span>
                    </td>
                    <td>
                        <input type="text" name="tags" style="width:300px"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Изображение:</strong><br/> <span class="hinttext">Не обязательно</span>
                    </td>
                    <td>
                        <input type="file" name="imgfile"/>
                    </td>
                </tr>
            </table>

            <p>
                <input name="cat_id" type="hidden" id="cat_id" value="<?php echo (int)$_REQUEST['cat_id']; ?>"/>
                <input name="opt" type="hidden" id="opt" value="go_import_xls"/>
                <input name="save" type="submit" id="save" value="Импортировать"/>
                <input name="back" type="button" id="back" value="Отмена" onclick="window.history.go(-1);"/>
            </p>

            </form><?php

        } else {


            echo '<h4>Выберите рубрику для импорта записей:</h4>';

            $sql = "SELECT id, title, NSLeft, NSLevel, parent_id
                    FROM cms_uc_cats
                    WHERE parent_id > 0
                    ORDER BY NSLeft";
            $result = $inDB->query($sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<div style="padding:10px">';
                while ($cat = mysqli_fetch_assoc($result)) {
                    echo '<div style="padding:2px;padding-left:18px;margin-left:' . (($cat['NSLevel'] - 1) * 15) . 'px;background:url(/admin/images/icons/hmenu/cats.png) no-repeat">
                                  <a href="?view=components&do=config&id=' . $_REQUEST['id'] . '&opt=import_xls&cat_id=' . $cat['id'] . '">' . $cat['title'] . '</a>
                              </div>';
                }
                echo '</div>';
            }

//            $sql = "SELECT id, title FROM cms_uc_cats ORDER BY title";
//            $result = $inDB->query($sql);
//
//            if (mysqli_num_rows($result)>0){
//                echo '<p><strong>Выберите рубрику для импорта записей:</strong></p>';
//                echo '<ul>';
//                while ($cat = mysqli_fetch_assoc($result)){
//                    echo '<li><a href="?view=components&do=config&id='.$_REQUEST['id'].'&opt=import_xls&cat_id='.$cat['id'].'">'.$cat['title'].'</a></li>';
//                }
//                echo '</ul>';
//            }
        }

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'saveymlcfg') {
        $cfg['yml']['shop_name'] = time();

        $inCore->saveComponentConfig('shop', $cfg);

        $msg = 'Настройки успешно сохранены';


        $model->getKaspi();

        //$model->getMerch();


        $opt = 'ymlcfg';

    }

    if ($opt == 'savemerchantcfg') {
        $cfg['merchant']['shop_name'] = time();

        $inCore->saveComponentConfig('shop', $cfg);

        $msg = 'Настройки успешно сохранены';


        $model->getMerchant();


        $opt = 'ymlcfg';

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'saveconfig') {

        $cfg['is_shop'] = $inCore->request('is_shop', 'int', 1);
        $cfg['is_skip_pay'] = $inCore->request('is_skip_pay', 'int', 0);
        $cfg['track_qty'] = $inCore->request('track_qty', 'int', 0);
        $cfg['show_vendors'] = $inCore->request('show_vendors', 'int', 1);
        $cfg['show_cats'] = $inCore->request('show_cats', 'int', 1);
        $cfg['show_nested'] = $inCore->request('show_nested', 'int', 0);
        $cfg['show_items_nav'] = $inCore->request('show_items_nav', 'int', 0);
        $cfg['show_subcats'] = $inCore->request('show_subcats', 'int', 1);
        $cfg['subcats_order'] = $inCore->request('subcats_order', 'str', 'title');
        $cfg['qty_mode'] = $inCore->request('qty_mode', 'str', 'any');
        $cfg['show_desc'] = $inCore->request('show_desc', 'int', 1);
        $cfg['show_full_desc'] = $inCore->request('show_full_desc', 'int', 1);
        $cfg['show_thumb'] = $inCore->request('show_thumb', 'int', 1);
        $cfg['show_hit_img'] = $inCore->request('show_hit_img', 'int', 1);
        $cfg['show_decimals'] = $inCore->request('show_decimals', 'int', 2);
        $cfg['show_filter'] = $inCore->request('show_filter', 'int', 1);
        $cfg['show_filter_vendors'] = $inCore->request('show_filter_vendors', 'int', 1);
        $cfg['show_compare'] = $inCore->request('show_compare', 'int', 1);
        $cfg['show_char_grp'] = $inCore->request('show_char_grp', 'int', 1);
        $cfg['show_cat_chars'] = $inCore->request('show_cat_chars', 'int', 0);
        $cfg['show_comments'] = $inCore->request('show_comments', 'int', 0);
        $cfg['show_related'] = $inCore->request('show_related', 'int', 1);
        $cfg['related_count'] = $inCore->request('related_count', 'int', 5);
        $cfg['img_w'] = $inCore->request('img_w', 'int', 350);
        $cfg['img_h'] = $inCore->request('img_h', 'int', 350);
        $cfg['thumb_w'] = $inCore->request('thumb_w', 'int', 150);
        $cfg['thumb_h'] = $inCore->request('thumb_h', 'int', 150);
        $cfg['img_sqr'] = $inCore->request('img_sqr', 'int', 0);
        $cfg['thumb_sqr'] = $inCore->request('thumb_sqr', 'int', 1);
        $cfg['watermark'] = $inCore->request('watermark', 'int', 0);
        $cfg['currency'] = $inCore->request('currency', 'str', '');
        $cfg['notify_send'] = $inCore->request('notify_send', 'int', 0);
        $cfg['notify_send_customer'] = $inCore->request('notify_send_customer', 'int', 0);
        $cfg['notify_email'] = $inCore->request('notify_email', 'str', '');
        $cfg['items_orderby'] = $inCore->request('items_orderby', 'str', '');
        $cfg['items_orderto'] = $inCore->request('items_orderto', 'str', '');
        $cfg['after_cart'] = $inCore->request('after_cart', 'str', 'stay');
        $cfg['ord_req'] = $inCore->request('ord_req', 'array');
        $cfg['compare_prices'] = $inCore->request('compare_prices', 'int', 1);
        $cfg['ratings'] = $inCore->request('ratings', 'int', 1);

        if (!$cfg['ord_req']) {
            $cfg['ord_req'] = '';
        }

        $inCore->saveComponentConfig('shop', $cfg);

        $msg = 'Настройки успешно сохранены';

        if ($inCore->request('clear_carts', 'int', 0)) {
            $model->clearAllCarts();
            $msg .= '<br/>' . 'Корзины всех пользователей очищены';
        }

        if ($inCore->request('clear_orders', 'int', 0)) {
            $model->clearAllOrders();
            $msg .= '<br/>' . 'Все заказы удалены из базы данных';
        }

        if ($inCore->request('clear_compare', 'int', 0)) {
            $model->clearCompare();
            $msg .= '<br/>' . 'Таблица сравнений товаров очищена';
        }

        $opt = 'config';

    }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'config') {

        cpAddPathway('Настройки', $_SERVER['REQUEST_URI']);

        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/includes/jquery/tabs/jquery.ui.min.js"></script>';
        $GLOBALS['cp_page_head'][] = '<link href="/includes/jquery/tabs/tabs.css" rel="stylesheet" type="text/css" />';

        if ($msg) {
            echo '<p style="color:green">' . $msg . '</p>';
        }

        if (!$cfg['ord_req']) {
            $cfg['ord_req'] = array();
        }

        ?>
        <form action="index.php?view=components&amp;do=config&amp;id=<?php echo $_REQUEST['id']; ?>" method="post" name="optform" target="_self" id="form1">

            <div id="config_tabs" style="margin-top:12px;" class="uitabs">

                <ul id="tabs">
                    <li><a href="#general"><span>Общие настройки</span></a></li>
                    <li><a href="#items"><span>Товары</span></a></li>
                    <li><a href="#cats"><span>Категории</span></a></li>
                    <li><a href="#images"><span>Фотографии</span></a></li>
                    <li><a href="#orders"><span>Заказы</span></a></li>
                    <li><a href="#notify"><span>Уведомления</span></a></li>
                    <li><a href="#other"><span>Прочее</span></a></li>
                </ul>

                <div id="general">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="260">
                                <strong>Режим работы компонента:</strong><br/>
                                <span class="hinttext">В режиме каталога заказ товаров будет недоступен</span>
                            </td>
                            <td valign="top">
                                <label><input name="is_shop" type="radio" value="1" <?php if (@$cfg['is_shop']) {
                                        echo 'checked="checked"';
                                    } ?>/> Магазин</label>
                                <label><input name="is_shop" type="radio" value="0" <?php if (@!$cfg['is_shop']) {
                                        echo 'checked="checked"';
                                    } ?>/> Каталог</label>
                            </td>
                        </tr>
                        <tr>
                            <td width="260">
                                <strong>Режим вывода цен:</strong>
                            </td>
                            <td valign="top">
                                <label><input name="show_decimals" type="radio" value="2" <?php if (@$cfg['show_decimals'] == 2) {
                                        echo 'checked="checked"';
                                    } ?>/> Дробные (x.xx)</label>
                                <label><input name="show_decimals" type="radio" value="0" <?php if (@!$cfg['show_decimals']) {
                                        echo 'checked="checked"';
                                    } ?>/> Целые (x)</label>
                            </td>
                        </tr>
                        <tr>
                            <td width="260">
                                <strong>Валюта магазина:</strong>
                            </td>
                            <td valign="top">
                                <input type="text" name="currency" value="<?php echo $cfg['currency']; ?>" style="width:60px"/>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="items">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="280"><strong>Выбор количества при заказе: </strong></td>
                            <td>
                                <select id="qty_mode" name="qty_mode" style="width:280px">
                                    <option value="any" <?php if ($cfg['qty_mode'] == 'any') {
                                        echo 'selected="selected"';
                                    } ?>>любое количество
                                    </option>
                                    <option value="qty" <?php if ($cfg['qty_mode'] == 'qty') {
                                        echo 'selected="selected"';
                                    } ?>>в пределах наличия на складе
                                    </option>
                                    <option value="one" <?php if ($cfg['qty_mode'] == 'one') {
                                        echo 'selected="selected"';
                                    } ?>>весь товар штучный
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Сортировка товаров по-умолчанию: </strong></td>
                            <td>
                                <select id="items_orderby" name="items_orderby" style="width:130px">
                                    <option value="qty" <?php if ($cfg['items_orderby'] == 'qty') {
                                        echo 'selected="selected"';
                                    } ?>>по порядку
                                    </option>
                                    <option value="id" <?php if ($cfg['items_orderby'] == 'id') {
                                        echo 'selected="selected"';
                                    } ?>>по дате
                                    </option>
                                    <option value="title" <?php if ($cfg['items_orderby'] == 'title') {
                                        echo 'selected="selected"';
                                    } ?>>по названию
                                    </option>
                                    <option value="price" <?php if ($cfg['items_orderby'] == 'price') {
                                        echo 'selected="selected"';
                                    } ?>>по цене
                                    </option>
                                </select> <select id="items_orderto" name="items_orderto" style="width:147px">
                                    <option value="asc" <?php if ($cfg['items_orderto'] == 'asc') {
                                        echo 'selected="selected"';
                                    } ?>>по возрастанию
                                    </option>
                                    <option value="desc" <?php if ($cfg['items_orderto'] == 'desc') {
                                        echo 'selected="selected"';
                                    } ?>>по убыванию
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Вести учет количества на складе: </strong>
                            </td>
                            <td>
                                <input name="track_qty" type="radio" value="1" <?php if (@$cfg['track_qty']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="track_qty" type="radio" value="0" <?php if (@!$cfg['track_qty']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Показывать подробное описание: </strong></td>
                            <td>
                                <input name="show_full_desc" type="radio" value="1" <?php if (@$cfg['show_full_desc']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_full_desc" type="radio" value="0" <?php if (@!$cfg['show_full_desc']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать список категорий товара: </strong></td>
                            <td>
                                <input name="show_cats" type="radio" value="1" <?php if (@$cfg['show_cats']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_cats" type="radio" value="0" <?php if (@!$cfg['show_cats']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать отметки хитов: </strong></td>
                            <td>
                                <input name="show_hit_img" type="radio" value="1" <?php if (@$cfg['show_hit_img']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_hit_img" type="radio" value="0" <?php if (@!$cfg['show_hit_img']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать названия групп характеристик: </strong></td>
                            <td>
                                <input name="show_char_grp" type="radio" value="1" <?php if (@$cfg['show_char_grp']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_char_grp" type="radio" value="0" <?php if (@!$cfg['show_char_grp']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Разрешить комментарии: </strong></td>
                            <td>
                                <input name="show_comments" type="radio" value="1" <?php if (@$cfg['show_comments']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_comments" type="radio" value="0" <?php if (@!$cfg['show_comments']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Разрешить рейтинги:</strong></td>
                            <td>
                                <input name="ratings" type="radio" value="1" <?php if ($cfg['ratings']) {
                                    echo 'checked="checked"';
                                } ?> /> Да <input name="ratings" type="radio" value="0" <?php if (!$cfg['ratings']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать cледующий и предыдущий: </strong></td>
                            <td>
                                <input name="show_items_nav" type="radio" value="1" <?php if (@$cfg['show_items_nav']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_items_nav" type="radio" value="0" <?php if (@!$cfg['show_items_nav']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать связанные товары: </strong></td>
                            <td>
                                <input name="show_related" type="radio" value="1" <?php if (@$cfg['show_related']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_related" type="radio" value="0" <?php if (@!$cfg['show_related']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Количество связанных товаров: </strong></td>
                            <td>
                                <input type="text" name="related_count" value="<?php echo $cfg['related_count']; ?>" style="width:40px;"/>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="cats">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="300"><strong>Показывать дочерние категории: </strong></td>
                            <td>
                                <input name="show_subcats" type="radio" value="1" <?php if (@$cfg['show_subcats']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_subcats" type="radio" value="0" <?php if (@!$cfg['show_subcats']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Показывать объекты из дочерних категорий: </strong></td>
                            <td>
                                <input name="show_nested" type="radio" value="1" <?php if (@$cfg['show_nested']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_nested" type="radio" value="0" <?php if (@!$cfg['show_nested']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Cортировать дочерние категории: </strong></td>
                            <td>
                                <input name="subcats_order" type="radio" value="title" <?php if (@$cfg['subcats_order'] == 'title') {
                                    echo 'checked="checked"';
                                } ?>/> По алфавиту
                                <input name="subcats_order" type="radio" value="NSLeft" <?php if (@$cfg['subcats_order'] == 'NSLeft') {
                                    echo 'checked="checked"';
                                } ?>/> По порядку
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать фильтр товаров: </strong></td>
                            <td>
                                <input name="show_filter" type="radio" value="1" <?php if (@$cfg['show_filter']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_filter" type="radio" value="0" <?php if (@!$cfg['show_filter']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать производителей в фильтре: </strong></td>
                            <td>
                                <input name="show_filter_vendors" type="radio" value="1" <?php if (@$cfg['show_filter_vendors']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_filter_vendors" type="radio" value="0" <?php if (@!$cfg['show_filter_vendors']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать краткое описание товаров: </strong></td>
                            <td>
                                <input name="show_desc" type="radio" value="1" <?php if (@$cfg['show_desc']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_desc" type="radio" value="0" <?php if (@!$cfg['show_desc']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать фотографии товаров: </strong></td>
                            <td>
                                <input name="show_thumb" type="radio" value="1" <?php if (@$cfg['show_thumb']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_thumb" type="radio" value="0" <?php if (@!$cfg['show_thumb']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать названия производителей: </strong></td>
                            <td>
                                <input name="show_vendors" type="radio" value="1" <?php if (@$cfg['show_vendors']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_vendors" type="radio" value="0" <?php if (@!$cfg['show_vendors']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Сравнение товаров: </strong></td>
                            <td>
                                <input name="show_compare" type="radio" value="1" <?php if (@$cfg['show_compare']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_compare" type="radio" value="0" <?php if (@!$cfg['show_compare']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Цены в сравнении товаров: </strong></td>
                            <td>
                                <input name="compare_prices" type="radio" value="1" <?php if (@$cfg['compare_prices']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="compare_prices" type="radio" value="0" <?php if (@!$cfg['compare_prices']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td width=""><strong>Показывать характеристики товаров: </strong></td>
                            <td>
                                <input name="show_cat_chars" type="radio" value="1" <?php if (@$cfg['show_cat_chars']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="show_cat_chars" type="radio" value="0" <?php if (@!$cfg['show_cat_chars']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="images">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="260"><strong>Макс. размер большой фотографии: </strong></td>
                            <td>
                                <input name="img_w" type="text" id="img_w" size="5" value="<?php echo @$cfg['img_w']; ?>" style="text-align:center"/> x
                                <input name="img_h" type="text" id="img_h" size="5" value="<?php echo @$cfg['img_h']; ?>" style="text-align:center"/> пикс.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Макс. размер маленькой фотографии: </strong></td>
                            <td>
                                <input name="thumb_w" type="text" id="thumb_w" size="5" value="<?php echo @$cfg['thumb_w']; ?>" style="text-align:center"/> x
                                <input name="thumb_h" type="text" id="thumb_h" size="5" value="<?php echo @$cfg['thumb_h']; ?>" style="text-align:center"/> пикс.
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Обрезать большие фотографии <span style="color:gray">(квадрат)</span>: </strong>
                            </td>
                            <td>
                                <input name="img_sqr" type="radio" value="1" <?php if (@$cfg['img_sqr']) {
                                    echo 'checked="checked"';
                                } ?>/> Да <input name="img_sqr" type="radio" value="0" <?php if (@!$cfg['img_sqr']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Обрезать маленькие фотографии <span style="color:gray">(квадрат)</span>:
                                </strong></td>
                            <td>
                                <input name="thumb_sqr" type="radio" value="1" <?php if (@$cfg['thumb_sqr']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="thumb_sqr" type="radio" value="0" <?php if (@!$cfg['thumb_sqr']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Наносить водяной знак сайта: </strong></td>
                            <td>
                                <input name="watermark" type="radio" value="1" <?php if (@$cfg['watermark']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="watermark" type="radio" value="0" <?php if (@!$cfg['watermark']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="orders">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="280"><strong>При добавлении в корзину: </strong></td>
                            <td>
                                <select id="after_cart" name="after_cart" style="width:280px">
                                    <option value="cart" <?php if ($cfg['after_cart'] == 'cart') {
                                        echo 'selected="selected"';
                                    } ?>>переходить в корзину
                                    </option>
                                    <option value="stay" <?php if ($cfg['after_cart'] == 'stay') {
                                        echo 'selected="selected"';
                                    } ?>>оставаться на той же странице
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><strong>Поля обязательные для заполнения<br/> при создании заказа:</strong>
                            </td>
                            <td>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="name" <?php if (in_array('name', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> Имя, фамилия</label>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="phone" <?php if (in_array('phone', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> Контактный телефон</label>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="email" <?php if (in_array('email', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> E-mail</label>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="address" <?php if (in_array('address', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> Адрес доставки</label>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="org" <?php if (in_array('org', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> Организация</label>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="ord_req[]" value="inn" <?php if (in_array('inn', $cfg['ord_req'])){ ?>checked="checked"<?php } ?> /> ИНН</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Отключить выбор способа оплаты: </strong><br/>
                                <span class="hinttext">Заказы будут создаваться, но оплатить на сайте их будет нельзя. Покупатель будет видеть сообщение "Заказ принят".</span>
                            </td>
                            <td valign="top">
                                <label><input type="checkbox" name="is_skip_pay" value="1" <?php if ($cfg['is_skip_pay']){ ?>checked="checked"<?php } ?> /> Да</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="notify">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="320"><strong>Отправлять уведомление о заказе продавцу: </strong></td>
                            <td>
                                <input name="notify_send" type="radio" value="1" <?php if (@$cfg['notify_send']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="notify_send" type="radio" value="0" <?php if (@!$cfg['notify_send']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Отправлять уведомление о заказе покупателю: </strong></td>
                            <td>
                                <input name="notify_send_customer" type="radio" value="1" <?php if (@$cfg['notify_send_customer']) {
                                    echo 'checked="checked"';
                                } ?>/> Да
                                <input name="notify_send_customer" type="radio" value="0" <?php if (@!$cfg['notify_send_customer']) {
                                    echo 'checked="checked"';
                                } ?>/> Нет
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Адрес для уведомлений продавца: </strong><br/> <span class="hinttext">
                            Можно указать несколько адресов через запятую
                        </span>
                            </td>
                            <td>
                                <input name="notify_email" type="text" id="notify_email" value="<?php echo @$cfg['notify_email']; ?>" style="width:220px"/>
                            </td>
                        </tr>
                        <tr>
                            <td height="24"><strong>Шаблон письма уведомления: </strong></td>
                            <td>
                                <a href="/includes/letters/inshop-order.txt" target="_blank">/includes/letters/inshop-order.txt</a>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="other">
                    <table width="" border="0" cellpadding="5" cellspacing="0" class="proptable" style="border:none">
                        <tr>
                            <td width="260">
                                <label for="clear_carts"><strong>Очистить корзины всех пользователей: </strong></label>
                            </td>
                            <td>
                                <input type="checkbox" id="clear_carts" name="clear_carts" value="1"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="">
                                <label for="clear_orders"><strong>Очистить таблицу заказов: </strong></label>
                            </td>
                            <td>
                                <input type="checkbox" id="clear_orders" name="clear_orders" value="1"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="">
                                <label for="clear_compare"><strong>Очистить таблицу сравнений: </strong></label>
                            </td>
                            <td>
                                <input type="checkbox" id="clear_compare" name="clear_compare" value="1"/>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>

            <p>
                <input name="opt" type="hidden" value="saveconfig"/>
                <input name="save" type="submit" id="save" value="Сохранить"/>
                <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
            </p>

        </form>

    <?php }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'ymlcfg') {

        cpAddPathway('Экспорт прайса в XML', $_SERVER['REQUEST_URI']);

        if ($msg) {
            echo '<p style="color:green">' . $msg . '</p>';
        }

        $inConf = cmsConfig::getInstance();

        ?>
        <table width="100%" border="0">
            <tr>
                <td width="50%">
                    <form action="index.php?view=components&amp;do=config&amp;id=<?php echo $_REQUEST['id']; ?>" method="post" name="optform" target="_self" id="form1">

                        <div id="config_tabs" style="margin-top:12px;">
                            <?php $lastdate = getdate($cfg['yml']['shop_name']); ?>
                            <div id="url">
                                <p style="font-size:14px;color:#09C">1) Ссылка на прайс-лист для
                                    <b>Kaspi KZ</b> (последний от <?php echo $lastdate['mday'] . '.' . $lastdate['mon'] . '.' . $lastdate['year'] . ', ' . $lastdate['hours'] . ':' . $lastdate['minutes']; ?>):
                                </p>
                                <pre style="font-size:18px"><a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/price.xml">https://<?php echo $_SERVER['HTTP_HOST']; ?>/price.xml</a></pre>
                            </div>

                        </div>

                        <p>
                            <input name="opt" type="hidden" value="saveymlcfg"/>
                            <input name="save" type="submit" id="save" value="Обновить"/>
                        </p>

                    </form>
                </td>
                <td width="50%">
                    <form action="index.php?view=components&amp;do=config&amp;id=<?php echo $_REQUEST['id']; ?>" method="post" name="optform" target="_self" id="form2">

                        <div id="config_tabse" style="margin-top:12px;">
                            <?php $lastmdate = getdate($cfg['merchant']['shop_name']); ?>
                            <div id="urle">
                                <p style="font-size:14px;color:#09C">2) Ссылка на прайс-лист для
                                    <b>Google Merchant</b> (последний от <?php echo $lastmdate['mday'] . '.' . $lastmdate['mon'] . '.' . $lastmdate['year'] . ', ' . $lastmdate['hours'] . ':' . $lastmdate['minutes']; ?>):
                                </p>
                                <pre style="font-size:18px"><a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/merchant.xml">https://<?php echo $_SERVER['HTTP_HOST']; ?>/merchant.xml</a></pre>
                            </div>

                        </div>

                        <p>
                            <input name="opt" type="hidden" value="savemerchantcfg"/>
                            <input name="save" type="submit" id="save" value="Обновить"/>
                        </p>

                    </form>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <?php $vend = $model->getVendors(); ?>
                    <form action="/components/shop/csv.php" method="POST">
                        <p style="font-size:14px;color:#09C">3) Сформировать выгрузку эксель</p>
                        <select style="width:150px;" name="vens47jiklo">
                            <option value="0">Любой производитель</option>
                            <?php
                            foreach ($vend as $ven) {
                                echo '<option value="' . $ven['id'] . '">' . $ven['title'] . '</option>';
                            }
                            ?>
                        </select> <select style="width:150px;" name="catrehiu647uii">
                            <option value="0">Любая рубрика</option>
                            <?php

                            $sql = "SELECT title, id, NSLevel, NSLeft
                                           FROM cms_shop_cats
                                           WHERE parent_id>0
                                           ORDER BY NSLeft";
                            $res = $inDB->query($sql);

                            if ($inDB->num_rows($res)) {
                                while ($cat = $inDB->fetch_assoc($res)) {
                                    $pad = str_repeat('--', $cat['NSLevel'] - 1);
                                    echo '<option value="' . $cat['id'] . '">' . $pad . ' ' . $cat['title'] . '</option>';
                                }
                            }

                            ?>
                        </select>
                        <button type="submit">Получить файл</button>
                    </form>
                </td>
                <td width="50%">

                </td>
            </tr>
        </table>


    <?php }

//=================================================================================================//
//=================================================================================================//

    if ($opt == 'import') {

        cpAddPathway('Импорт', $_SERVER['REQUEST_URI']);

        $GLOBALS['cp_page_head'][] = '<script type="text/javascript" src="/includes/jquery/tabs/jquery.ui.min.js"></script>';
        $GLOBALS['cp_page_head'][] = '<link href="/includes/jquery/tabs/tabs.css" rel="stylesheet" type="text/css" />';

        if ($msg) {
            echo '<p style="color:green">' . $msg . '</p>';
        }

        ?>

        <h3 style="margin-bottom:0px">Импорт товаров</h3>
        <p style="margin-top:0px;color:gray;border-bottom:dotted 1px gray;padding-bottom:10px;">
            Выберите файл и укажите параметры импорта. Для импорта из Excel просто сохраните таблицу в формате CSV.<br/> Файлы по 100 позиций и более рекомендуется импортировать по частям.
        </p>


        <form action="index.php?view=components&amp;do=config&amp;id=<?php echo $_REQUEST['id']; ?>" method="post" id="import" target="_self" enctype="multipart/form-data">

            <table cellpadding="4" cellspacing="0" border="0" width="" class="proptable" style="border:none">
                <tr>
                    <td width="200">
                        <strong>CSV-файл для импорта:</strong>
                    </td>
                    <td width="200">
                        <input type="file" name="csvfile"/>
                    </td>
                </tr>
                <tr>
                    <td width=""><strong>Кодировка файла:</strong></td>
                    <td width="200">
                        <select id="encoding" name="encoding" style="width:290px">
                            <option value="CP1251">Кириллица (MS Office, Windows)</option>
                            <option value="UTF-8">Юникод (OpenOffice, Linux)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Разделитель полей:</strong></td>
                    <td>
                        <select id="separator" name="separator" style="width:290px">
                            <option value=",">Запятая</option>
                            <option value=";">Точка с запятой</option>
                            <option value=":">Двоеточие</option>
                            <option value=" ">Пробел</option>
                            <option value="t">Табуляция</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Разделитель текста:</strong></td>
                    <td>
                        <select id="quote" name="quote" style="width:290px">
                            <option value="quot">Двойные кавычки</option>
                            <option value="apos">Апострофы</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Категория по-умолчанию:</strong><br/> <span class="hinttext">
                    Если не указана в CSV-файле
                </span>
                    </td>
                    <td valign="top">
                        <select id="cat_id" name="cat_id" style="width:290px">
                            <?php echo $inCore->getListItemsNS('cms_shop_cats'); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Имеющиеся товары:</strong><br/> <span class="hinttext">При совпадении по артикулу</span>
                    </td>
                    <td valign="top">
                        <select id="update_items" name="update_items" style="width:290px">
                            <option value="1">Обновлять</option>
                            <option value="0">Все равно вставлять</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Начинать со строки:</strong>
                    </td>
                    <td>
                        <input type="text" id="rows_start" name="rows_start" value="1" style="width:50px"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Импортировать строк <span style="color:gray">(0 - все):</span></strong>
                    </td>
                    <td valign="top">
                        <input type="text" id="rows_count" name="rows_count" value="0" style="width:50px"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Скрыть товары после импорта:</strong>
                    </td>
                    <td>
                        <label><input type="checkbox" id="hide_items" name="hide_items" value="1" checked="checked"/> Да</label>
                    </td>
                </tr>
            </table>

            <h3 style="margin-bottom:0px">Шаблон cтруктуры данных</h3>
            <style type="text/css">em {
                    color: #333;
                }</style>
            <p style="margin-top:0px;color:gray;border-bottom:dotted 1px gray;padding-bottom:10px;">
                Здесь нужно задать шаблон для строк импортируемого CSV-файла. Это необходимо для того, чтобы скрипт понимал в каком порядке расположены данные.<br/> По сути, это просто перечисление колонок в импортируемой таблице. Вы можете добавлять поля в шаблон, используя выпадающие списки ниже.<br/> Например, если в CSV-файле колонки расположены в таком порядке:
                <em>Артикул</em>, <em>Название</em>, <em>Количество</em>, <em>Цена</em> - то шаблон будет:
                <em>art_no</em>, <em>title</em>, <em>qty</em>, <em>price</em>
            </p>

            <p>
                <input type="text" id="data_struct" name="data_struct" style="width:900px" value="art_no, title, qty, price"/>
            </p>

            <table cellpadding="2" cellspacing="0" border="0">
                <tr>
                    <td width="160">Параметры товара:</td>
                    <td>
                        <select id="data_param" name="data_param" style="width:635px">
                            <option value="art_no">Артикул</option>
                            <option value="title">Название</option>
                            <option value="shortdesc">Краткое описание</option>
                            <option value="description">Подробное описание</option>
                            <option value="price">Цена</option>
                            <option value="old_price">Старая цена</option>
                            <option value="category">Категория (название)</option>
                            <option value="category_id">Категория (id)</option>
                            <option value="sub_category">Дополнительная категория (название)</option>
                            <option value="sub_category_id">Дополнительная категория (id)</option>
                            <option value="vendor">Производитель (название)</option>
                            <option value="vendor_id">Производитель (id)</option>
                            <!-- <option value="image_path">Путь к изображению</option> -->
                            <!-- <option value="image_url">URL изображения</option> -->
                            <option value="is_hit">Хит (0..1)</option>
                            <option value="is_front">На витрине (0..1)</option>
                            <option value="is_spec">Спецпред (0..1)</option>
                            <option value="metakeys">Ключевые слова</option>
                            <option value="metadesc">Описание</option>
                            <option value="tags">Теги</option>
                            <option value="qty">Количество</option>
                            <option value="---">( пропустить колонку )</option>
                        </select>
                    </td>
                    <td style="padding-left:10px">
                        <input type="button" id="insert_data_param" name="insert_data_param" value="Вставить" onClick="addToCSVTemplate('data_param')"/>
                    </td>
                </tr>
                <tr>
                    <td width="">Характеристики товара:</td>
                    <td>
                        <select id="char_param" name="char_param" style="width:635px">
                            <?php $chars = $model->getChars(false); ?>
                            <?php foreach ($chars as $char) { ?>
                                <option value="c<?php echo $char['id']; ?>">[c<?php echo $char['id']; ?>] - <?php echo $char['title']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td style="padding-left:10px">
                        <input type="button" id="insert_data_param" name="insert_data_param" value="Вставить" onClick="addToCSVTemplate('char_param')"/>
                    </td>
                </tr>
            </table>

            <p style="margin-top:50px">
                <input name="opt" type="hidden" value="go_import_csv"/>
                <input name="save" type="button" id="save" value="Импортировать товары" onClick="checkImport()"/>
                <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
            </p>

        </form>

    <?php }

    if ($opt == 'remove_param') {

        $paramId = $inCore->request('param_id', 'int');

        $model->removeParamItem($paramId);

    }
}







