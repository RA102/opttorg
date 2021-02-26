<?php

if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }

function shop() {

    global $_LANG;
    global $_CFG;

    setlocale(LC_NUMERIC, 'POSIX');

    //подключим нужные классы
    $inConf     = cmsConfig::getInstance();
    $inCore     = cmsCore::getInstance();       //ядро
    $inPage     = cmsPage::getInstance();       //страница
    $inDB       = cmsDatabase::getInstance();   //база данных
    $inUser     = cmsUser::getInstance();       //пользователь

    //получим ID текущего пункта меню
	$menuid     = $inCore->menuId();
    $menutitle  = $inCore->menuTitle();

    if ($menuid == 1){ $menutitle = ''; }

    //загружаем модель
    $inCore->loadModel('shop');
    $model = new cms_model_shop();

    //загрузим конфиг компонента
    $cfg = $model->getConfig();

    //получаем входные параметры
	$id         = $inCore->request('id', 'int', 0);
	$seolink    = $inCore->request('seolink', 'str', '');
	$do         = $inCore->request('do', 'str', 'view');

	$page       = $inCore->request('page', 'int', 1);
	$perpage    = $cfg['perpage']; 


    //Подключаем CSS к странице
	$inPage->addHeadCSS('templates/'.$inConf->template.'/css/inshop.css');
    $inPage->addPathway($inCore->getComponentTitle(), '/shop');

//============================================================================//
//============================================================================//

    //
    // ПРОСМОТР КАТЕГОРИИ МАГАЗИНА
    //

	if ($do=='view') {
		$inPage->addHead('<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate">');

        // -------- получаем категорию --------------

        if (!$seolink){
            //Корневая категория
            $root_cat           = $model->getRootCategory();
            $root_cat['title']  = 'Каталог сантехники';
			$root_cat['pagetitle']  = 'Каталог сантехники | интернет-магазин SanMarket.kz';
			$root_cat['meta_desc'] = 'Качественная сантехника от лучших производителей ➥ Покупка сантехники в рассрочку. ➥ Прайс лист ➥ Каталог ⛟ Доставка → Алматы, Нур-Султан (Астана), Караганда, Шымкент, Костанай, по всему Казахстану.';
			
			$rootcats = '1';
        }

        if ($seolink){
            //Внутренняя (не корневая) категория
            $root_cat   = $model->getCategoryByLink($seolink);
            $path_list  = $model->getCategoryPath($root_cat['NSLeft'], $root_cat['NSRight']);
        }

        //Если не найдена - 404
        if (!$root_cat){ cmsCore::error404(); }

        if (!$root_cat['published']) { cmsCore::error404(); }

        $_SESSION['inshop_last_url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['inshop_last_cat_id'] = $root_cat['id'];

        //Ставим заголовки страницы
		if ($root_cat['pagetitle']) { 
			$inPage->setTitle($root_cat['pagetitle']) ; 
			} else { 
				if ($root_cat['pagetitle']) {
					$inPage->setTitle($root_cat['pagetitle']);
					$inPage->addHead('<meta property="og:title" content="'.$root_cat['pagetitle'].'" />');
				} else {
					$inPage->setTitle($root_cat['title'].' – купить в Караганде, Нур-Султан (Астане), Алматы | интернет-магазин SanMarket.kz');
					$inPage->addHead('<meta property="og:title" content="'.$root_cat['title'].' – купить в Караганде, Нур-Султан (Астане), Алматы | интернет-магазин SanMarket.kz" />');
				}
				
			}

       //SET META KEYWORDS AND DESCRIPTION
		$inPage->setKeywords($root_cat['meta_keys']);
		if ($rootcats == 1) {
			$inPage->setDescription($root_cat['meta_desc']);
			} else { 
				if ($root_cat['meta_desc']) { 
					$inPage->setDescription($root_cat['meta_desc']);
					$inPage->addHead('<meta property="og:description" content="'.$root_cat['meta_desc'].'" />');
				} else {
					$inPage->setDescription($root_cat['title'].' – продажа по лучшим ценам ✔ Широкий ассортимент ✔ Гарантия качества ⛟ Доставка → Алматы, Нур-Султан (Астана), Караганда, Шымкент, Костанай, по всему Казахстану.');
					$inPage->addHead('<meta property="og:description" content="'.$root_cat['title'].' – продажа по лучшим ценам ✔ Широкий ассортимент ✔ Гарантия качества ⛟ Доставка → Алматы, Нур-Султан (Астана), Караганда, Шымкент, Костанай, по всему Казахстану." />');
				}
			}
		$inPage->addHead('<meta property="og:image" content="https://sanmarket.kz/templates/basic_free/img/logo.png" />');
		$inPage->addHead('<meta property="og:url" content="https://sanmarket.kz/shop/'.$root_cat['seolink'].'" />');
        //Если у категории есть родители, выводим их в глубиномере
        if ($path_list){
            foreach($path_list as $pcat){
                $inPage->addPathway($pcat['title'], '/shop/'.$pcat['seolink']);
            }
        }

        //получаем подкатегории
        $subcats = $model->getSubCats($root_cat['id']);

        //получаем производителей для фильтра
        $vendors = $model->getCatVendors($root_cat['id']);

        //получаем хар-ки категории
        $chars = $model->getCatChars($root_cat['id']);

        // ------- очищаем фильтры других категорий -----------------
        if (is_array($_SESSION['shop_filters'])){
            foreach ($_SESSION['shop_filters'] as $f_cat_id=>$f){
                if ($f_cat_id != $root_cat['id']){
                    unset($_SESSION['shop_filters'][$f_cat_id]);
                }
            }
            //if(!mb_strpos($_SERVER['REQUEST_URI'],'page')) {
            // unset($_SESSION['shop_filters'][$root_cat['id']]);
           //}
        }

        // ------- получаем значения фильтров -----------------

        if($inCore->inRequest('all')) {
            unset($_SESSION['shop_filters'][$root_cat['id']]);
            $inCore->redirect('/shop/'.$root_cat['seolink']);
        }

        $filter     = array();
        $filter_str = $_SESSION['shop_filters'][$root_cat['id']];

        if ($filter_str){ $filter = $model->parseFilterString($filter_str); }
        if ($inCore->inRequest('filter')) {
            $filter = $inCore->request('filter', 'array');
            unset($_SESSION['shop_filters']);
        }

        if (is_array($filter)){

            foreach($filter as $key=>$val){

                if ($val && $key){

                    //производители
                    if ($key == 'vendors'){
                        $model->whereVendorIn($val);
                        continue;
                    }

                    //характеристика с одним значением (select)
                    if (!is_array($val)){
                        $val = trim($val);
                        switch($key){
                            case 'pfrom':  $model->wherePriceFrom($val); break;
                            case 'pto':    $model->wherePriceTo($val); break;
                            default:
                                if ($chars[$key]['values']){
//                                    $model->whereCharIs($key, $val);
                                    $model->whereCharIn($key, $val);
                                } else {
                                    $model->whereCharLike($key, $val);
                                }
                                break;
                        }
                    }

                    //характеристика с множеством значений или диапазон
                    if (is_array($val)){
                        if (isset($val['from']) || isset($val['to'])){
                            $model->whereCharBetween($key, $val);
                        } else {
                            $model->whereCharIn($key, $val);
                        }
                    }


                }

            }
            if (!$filter_str) {
                $filter_str = $model->makeFilterString($filter);
            }

        }

        if ($filter_str){
            $_SESSION['shop_filters'][$root_cat['id']] = $filter_str;
        }

        // ------- получаем товары -----------------

        //устанавливаем нужную категорию
        if ($root_cat['id']==1 || ($root_cat['id']>1 && !$cfg['show_nested'])){
            $model->whereCatIs($root_cat['id']);
        } else {
            $model->whereRecursiveCatIs($root_cat['id'], array('NSLeft'=>$root_cat['NSLeft'], 'NSRight'=>$root_cat['NSRight']));
        }

        $model->groupBy('i.id');

        //узнаем сколько всего подходящих товаров в базе
        $total = $model->getItemsCount();

        //устанавливаем сортировку
        $orderby = $_SESSION['inshop_orderby'] ? $_SESSION['inshop_orderby'] : $cfg['items_orderby'];
        $orderto = $_SESSION['inshop_orderto'] ? $_SESSION['inshop_orderto'] : $cfg['items_orderto'];
//        $model->orderByItemsWithPriceAndCount();
        $model->orderBy($orderby, $orderto);
        $model->wherePriceFrom(1);

        $order_types = array();

        foreach (array('ordering', 'price', 'title', 'id') as $order){

            switch ($order){
                case 'ordering': $name = $_LANG['SHOP_SORT_ORDERING']; break;
                case 'price': $name = $_LANG['SHOP_SORT_PRICE']; break;
                case 'title': $name = $_LANG['SHOP_SORT_TITLE']; break;
                case 'id': $name = $_LANG['SHOP_SORT_DATE']; break;
            }

            $order_types[] = array(
                'order' => $order,
                'name' => $name,
                'selected' => ($orderby==$order)
            );

        }

        //устанавливаем номер текущей страницы и кол-во товаров на странице
        $model->limitPage($page, $perpage);

        //получим все подходящие товары на текущей странице
        $items = $model->getItems();

        //считаем конечное число страниц 
        $pages = ceil($total / $perpage);

        $pages_url = '/shop/'.$root_cat['seolink'].'/page-%page%';

        $pagebar = cmsPage::getPagebar($total, $page, $perpage, $pages_url);

		if ($page==1) { 
			$is_pager=1;
		} else {
			$inPage->addHead('<link rel="canonical" href="https://sanmarket.kz/shop/'.$root_cat['seolink'].'" />');
			$inPage->addHead('<meta name="yandex" content="noindex, follow" />');
			$is_pager=0;
		}
		
        //проверяем что задан шаблон
        if (!$root_cat['tpl']) { $root_cat['tpl'] = 'com_inshop_view.tpl'; }

		
		$topbanner = $model->getBanner(11);
		$leftbanner = $model->getBanner(12);
		$itembanner = $model->getBanner1(13);
		
        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', $root_cat['tpl']);
		$smarty->assign('topbanner', $topbanner);
		$smarty->assign('leftbanner', $leftbanner);
		$smarty->assign('itembanner', $itembanner);
		$smarty->assign('cfg', $cfg);
		$smarty->assign('is_pager', $is_pager);
		$smarty->assign('subcats', $subcats);
		$smarty->assign('items', $items);
		$smarty->assign('chars', $chars);
		$smarty->assign('vendors', $vendors);
		$smarty->assign('filter', $filter);
        $smarty->assign('filter_str', $filter_str);
		$smarty->assign('total', $total);
		$smarty->assign('pages', $pages);
		$smarty->assign('page', $page);
		$smarty->assign('pagebar', $pagebar);
		$smarty->assign('orderby', $orderby);
		$smarty->assign('orderto', $orderto);
		$smarty->assign('order_types', $order_types);
		$smarty->assign('root_cat', $root_cat);
		$smarty->assign('is_user', $inUser->id);
		$smarty->display($root_cat['tpl']);

	}

//============================================================================//
//============================================================================//

    //
    // ПРОСМОТР ТОВАРА
    //

    if ($do == 'item') {
        $inPage->addHead('<meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate">');
        //если нет ссылки - ошибка
        if (!$seolink) {
            cmsCore::error404();
        }

        //получаем товар по ссылке
        $item = $model->getItemBySeolink($seolink);

        //если товар не найден - ошибка
        if (!$item) {
            cmsCore::error404();
        }

        if ($item['images']) {
            $inPage->addHeadJS('includes/jquery/lightbox/js/jquery.lightbox.js');
            $inPage->addHeadCSS('includes/jquery/lightbox/css/jquery.lightbox.css');
        }

        $_SESSION['inshop_last_url'] = $_SERVER['REQUEST_URI'];

        //находим следующий и предыдущий товары
        $nav = array();
        if ($cfg['show_items_nav']) {
            $nav = $model->getItemNav($item['id'], $item['category_id']);
        }

        //получаем путь к товару (список категорий)
        $path_list = $model->getCategoryPath($item['category']['NSLeft'], $item['category']['NSRight']);

        //Если у категории есть родители, выводим их в глубиномере
        if ($path_list) {
            foreach ($path_list as $pcat) {
                $inPage->addPathway($pcat['title'], '/shop/' . $pcat['seolink']);
            }
        }

        $inPage->addPathway($item['title']);

        //Устанавливаем заголовок страницы
        $inPage->setTitle($item['title'] . ' – купить в интернет-магазине SanMarket.kz');

        if ($item['metakeys']) {
            $inPage->setKeywords($item['metakeys']);
        }
        if ($item['metadesc']) {
            $inPage->setDescription($item['metadesc']);
        } else {
            $inPage->setDescription($item['title'] . 'Широкий ассортимент, Лучшая цена, Гарантия качества, Доставка Караганда, Нур-Султан (Астана), Алматы, Шымкент, Костанай, по всему Казахстану.');
        }

        //ищем связанные товары
        if ($cfg['show_related']){
            $relatedItems = $model->getRelatedItems($item['id']);
        } else {
            $ralatedItems = '';
        }

        $sims = $model->selectSimilars($item['shortdesc']);
        $rels = $model->selectRelatives($item['category_id'], $item['id']);

        $inPage->addHead('<link rel="canonical" href="https://sanmarket.kz/shop/' . $item['seolink'] . '.html" />');

        $inPage->addHead('
			<meta property="og:title" content="' . $item['title'] . ' – купить в интернет-магазине sanmarket.kz" />
			<meta property="og:description" content="' . $item['title'] . ' Широкий ассортимент Лучшая цена Гарантия качества Доставка Караганда, Нур-Султан (Астана), Алматы, Шымкент, Костанай, по всему Казахстану." />
			<meta property="og:image" content="https://sanmarket.kz/images/photos/small/shop' . $item['id'] . '.jpg" />
			<meta property="og:url" content="https://sanmarket.kz/shop/' . $item['seolink'] . '.html" />
		
		
		');


        $topbanner = $model->getBanner(11);
        $leftbanner = $model->getBanner(12);

        //проверяем что задан шаблон
        if (!$item['tpl']) {
            $item['tpl'] = 'com_inshop_item.tpl';
        }

        $qty = $item['qty'];
        $qty_from_vendor = $item['qty_from_vendor'];

        //передаем все в шаблон
        $smarty = cmsPage::initTemplate('components', $item['tpl']);
        $smarty->assign('cfg', $cfg);
        $smarty->assign('qty', $qty);
        $smarty->assign('qty_from_vendor', $qty_from_vendor);
        $smarty->assign('item', $item);
        $smarty->assign('topbanner', $topbanner);
        $smarty->assign('leftbanner', $leftbanner);
        $smarty->assign('sims', $sims);
        $smarty->assign('rels', $rels);
        $smarty->assign('nav', $nav);
        $smarty->assign('related_items', $relatedItems);
        $smarty->assign('is_user', $inUser->id);
        $smarty->display($item['tpl']);

        if ($inCore->isComponentInstalled('comments') && $cfg['show_comments']) {
            $inCore->includeComments();
            comments('shopitem', $item['id']);
        }

    }

//============================================================================//
//============================================================================//

    if ($do=='download') {

        $link_key = $inCore->request('link_key', 'str');

        $item = $model->getDigitalDownload($link_key);

        if (!$item){ cmsCore::error404(); }

        if ($item['is_loaded']){
            $loaded_msg  = "<p>Файл уже был загружен. Повторная загрузка невозможна.</p>";
            $loaded_msg .= "<p>При необходимости обратитесь в <a href=\"/\">службу поддержки</a> магазина.</p>";
            $loaded_msg .= "<p><strong>Номер вашего заказа: #{$item['order_id']}</strong></p>";
            $inCore->halt($loaded_msg);
        }

        $file = '/upload/userfiles/'.$item['filename'];

        if (!file_exists(PATH. $file)) { $inCore->halt('Файл не найден. Обратитесь в службу поддержки магазина. Номер вашего заказа: #'.$item['order_id']); }

        header('Content-Disposition: attachment; filename='.$item['filename_orig'] . "\n");
        header('Content-Type: application/x-force-download; name="'.$file.'"' . "\n\n");

        echo file_get_contents(PATH . $file);

        $ip = $_SERVER['REMOTE_ADDR'];

        $inDB->query("UPDATE cms_shop_loads SET is_loaded=1, load_date = NOW(), load_ip='{$ip}' WHERE id = '{$item['id']}'");

        $inCore->halt();

    }

//============================================================================//
//============================================================================//

    if ($do=='compare') {

        $inPage->setTitle($_LANG['SHOP_COMPARE']);
        $inPage->addPathway($_LANG['SHOP_COMPARE'], '/shop/compare.html');

        $add_item_id = $inCore->request('item_id', 'int', 0);

        if ($add_item_id) {
            $model->addCompareItem($add_item_id);
            $inCore->redirect('/shop/compare.html');
        }

        $items = $model->getCompareItems();
        $chars = $model->getChars(true, '', true); //only_published, all groups, only_compare

        $cmp_chars = array();

        foreach($chars as $char_id=>$char){
            if ($char['is_compare']){
                foreach($items as $num=>$item){
                    if ($item['chars'][$char_id]){
                        $cmp_chars[$char['title']][$item['id']] = $item['chars'][$char_id]['value'];
                    }
                }
            }
        }

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_compare.tpl');
        $smarty->assign('cfg', $cfg);
		$smarty->assign('items', $items);
		$smarty->assign('cmp_chars', $cmp_chars);
        $smarty->assign('last_url', $_SESSION['inshop_last_url']);
        $smarty->display('com_inshop_compare.tpl');

    }

    if ($do=='compare_remove'){

        $item_id = $inCore->request('item_id', 'int', 0);

        $model->deleteCompare($item_id);

        $inCore->redirectBack();

    }

//============================================================================//
//============================================================================//

    //
    // СПИСОК ПРОИЗВОДИТЕЛЕЙ
    //

    if ($do=='vendors'){

        //Ставим заголовки страницы
        $inPage->setTitle($_LANG['SHOP_VENDORS']);
        $inPage->addPathway($_LANG['SHOP_VENDORS'], '/shop/vendors.html');

        //получаем производителей
        $vendors = $model->getVendors();

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_vendors.tpl');
        $smarty->assign('cfg', $cfg);
		$smarty->assign('vendors', $vendors);
		$smarty->display('com_inshop_vendors.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ПРОСМОТР ТОВАРОВ ОДНОГО ПРОИЗВОДИТЕЛЯ
    //

	if ($do=='view_vendor'){

        //получаем производителя
        $vendor_id = $inCore->request('vendor_id', 'int', 0);
        $vendor    = $model->getVendor($vendor_id);

        //Если не найден - 404
        if (!$vendor){ cmsCore::error404(); }

        $_SESSION['inshop_last_url'] = $_SERVER['REQUEST_URI'];

        //Ставим заголовки страницы
        $inPage->setTitle('Сантехника '.$vendor['title'].' – купить в интернет-магазине SanMarket.kz');
		$inPage->setDescription('Сантехника '.$vendor['title'].' ✔ Широкий ассортимент ✔ Лучшие цены ⛟ Доставка → Алматы, Нур-Султан (Астана), Караганда, Шымкент, Костанай, по всему Казахстану.');
        $inPage->addPathway($_LANG['SHOP_VENDORS'], '/shop/vendors.html');
        $inPage->addPathway($vendor['title']);

        // ------- получаем товары -----------------

        //устанавливаем категорию и нужного производителя
        $model->where('i.category_id = c.id');
        $model->whereVendorIs($vendor_id);

        //узнаем сколько всего подходящих товаров в базе
        $total = $model->getItemsCount();

        //устанавливаем сортировку "по порядку"
        $model->orderBy('ordering', 'asc');

        //устанавливаем номер текущей страницы и кол-во товаров на странице
        $model->limitPage($page, $perpage);

        //получим все подходящие товары на текущей странице
        $items = $model->getItems();

        //считаем конечное число страниц
        $pages = ceil($total / $perpage);

        $pagebar = cmsPage::getPagebar($total, $page, $perpage, '/shop/vendors/%vendor_id%/page-%page%', array('vendor_id'=>$vendor_id));

		if ($page==1) { $is_pager=1; $inPage->addHead('<link rel="canonical" href="https://sanmarket.kz/shop/vendors/'.$vendor_id.'" />'); } else {$is_pager=0;}
		
		
        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_vendor.tpl');
        $smarty->assign('cfg', $cfg);
		$smarty->assign('is_pager', $is_pager);
		$smarty->assign('vendor', $vendor);
		$smarty->assign('items', $items);
		$smarty->assign('total', $total);
		$smarty->assign('pages', $pages);
		$smarty->assign('page', $page);
		$smarty->assign('pagebar', $pagebar);
		$smarty->display('com_inshop_vendor.tpl');

	}

//============================================================================//
//============================================================================//

    //
    // СОЗДАНИЕ ЗАКАЗА И ВЫБОР СИСТЕМЫ ОПЛАТЫ
    //

    if ($do=='payment'){

        //Устанавливаем заголовок страницы
        $inPage->setTitle($_LANG['SHOP_SELECT_PAYSYS']);
        $inPage->addPathway($_LANG['SHOP_SELECT_PAYSYS']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');
        // ---- CОХРАНЕНИЕ ЗАКАЗА ----

        // Получаем все товары из корзины для текущей сессии
        $items = $model->getCartItems($cfg);
        if (!$items) {
            cmsCore::error404();
        }

        // Получаем тип доставки
        $d_type = $inCore->request('d_type', 'int', 0);

        // Получить стоимость доставки
        $priceDelivery = $inCore->request('price_delivery', 'str');


        // Получаем код скидки
        $giftcode = $inCore->request('giftcode', 'int', 0);
		
		

        // Получаем поля заказа
        $order['secret_key']        = md5(session_id());

        $customer_type              = $inCore->request('cust_type', 'str', 'fis');

        $order['customer_name']     = $inCore->request('customer_name', 'str', '');
        $order['customer_org']      = $inCore->request('customer_org', 'str', '');
        $order['customer_inn']      = $inCore->request('customer_inn', 'str', '');
        $order['customer_phone']    = $inCore->request('customer_phone', 'str', '');
        $order['customer_email']    = $inCore->request('customer_email', 'str', '');
        $order['customer_address']  = $inCore->request('customer_address', 'str', '');
        $order['customer_comment']  = $inCore->request('customer_comment', 'str', '');

        $order['items']             = $inCore->arrayToYaml($items);
        $order['giftcode']          = $giftcode;
        $order['status']            = 1;
        $order['user_id']           = $inUser->id;
//        $order['summ']              = $model->calculateOrderSumm($items, $d_type, $giftcode);
        $order['summ'] = $model->calculateOrderSumm($items, $priceDelivery, $giftcode);

        if ($d_type){
            $delivery_types         = $model->getDeliveryTypes($order['summ']);
            $order['d_type']        = $d_type;
//            $order['d_price']       = $delivery_types[$d_type]['price'];
            $order['d_price'] = $priceDelivery;
        } else {
            $order['d_type']        = $d_type;
            $order['d_price']       = 0;
        }

        //удаляем старые заказы для этой сессии
        $model->deleteExpiredOrders(session_id());

        //сохраняем данные пользователя
        if ($inUser->id){
            $customer_data['customer_name']     = $order['customer_name'];
            $customer_data['customer_org']      = $order['customer_org'];
            $customer_data['customer_inn']      = $order['customer_inn'];
            $customer_data['customer_phone']    = $order['customer_phone'];
            $customer_data['customer_email']    = $order['customer_email'];
            $customer_data['customer_address']  = $order['customer_address'];
            $model->saveCustomerData($inUser->id, $customer_data);
        }



        //проверяем что заполнена информация покупателя
        if (!$order['customer_name'] && in_array('name', $cfg['ord_req'])){
            $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_NAME'], 'error');
        }
        if (!$order['customer_phone'] && in_array('phone', $cfg['ord_req'])){
            $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_PHONE'], 'error');
        }
        if (!$order['customer_email'] && in_array('email', $cfg['ord_req'])){
            $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_EMAIL'], 'error');
        }
        if (!$order['customer_address'] && in_array('address', $cfg['ord_req'])){
            $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_ADDRESS'], 'error');
        }
        if ($customer_type == 'org'){
            if (!$order['customer_org'] && in_array('org', $cfg['ord_req'])){
                $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_ORG'], 'error');
            }
            if (!$order['customer_inn'] && in_array('inn', $cfg['ord_req'])){
                $errors = true; cmsCore::addSessionMessage($_LANG['SHOP_ERR_REQ_INN'], 'error');
            }
        }

        if ($errors) { $inCore->redirectBack(); }
		
        //сохраняем новый заказ
        $order['id']                = $model->addOrder($order);
		
		if ($giftcode > 0) {
			$today = date("Y-m-d");
			$inDB->query("UPDATE `cms_coins` SET `is_used`='1', `usedate`='{$today}' WHERE `userid`='{$inUser->id}'");
		}		
		
        $order['description']       = $_LANG['SHOP_ORDER'].' #'.$order['id'];

        if ($cfg['is_skip_pay']){
            $model->setOrderStatus($order['id'], $order['secret_key'], 1);
            cmsUser::sessionPut('order_id', $order['id']);
            $inCore->redirect('/shop/order-accept.html');
        }

        // ---- ПОЛУЧАЕМ ФОРМЫ ПЛАТЕЖНЫХ СИСТЕМ ----

        $p_systems = $model->getPaymentSystems();

        if ($p_systems) {
            $inCore->includeFile('components/shop/payments/paysys.class.php');
        }

        $is_billing = $inCore->isComponentInstalled('billing');
        if (!$is_billing){ unset($p_systems['balance']); }

        foreach ($p_systems as $sys_id=>$p_sys){

            $inCore->includeFile('components/shop/payments/'.$sys_id.'/'.$sys_id.'.php');
            $inCore->includeFile('components/shop/payments/'.$sys_id.'/info.php');
            eval('$sys = new ps_'.$sys_id.'($order, $p_sys[\'config\']);');

            if($p_sys['config']['currency']){
                foreach($p_sys['config']['currency'] as $currency=>$kurs){
                    if($kurs){
                        $p_systems[$sys_id]['forms'][$currency] = $sys->getHtmlForm($order, $currency);
                        $p_systems[$sys_id]['config']['currency'][$currency] = round($order['summ']/$kurs, 2);
                    }
                }
            }

        }
		

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_pay.tpl');
        $smarty->assign('cfg', $cfg);
		$smarty->assign('p_systems', $p_systems);
		$smarty->assign('order', $order);
		$smarty->display('com_inshop_pay.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ПРОСМОТР ЗАКАЗА
    //

    if ($do=='view_order'){

        //сохраняем кол-во товаров в корзине
        $qty_arr = $inCore->request('qty', 'array');
        if ($qty_arr) {
            $model->saveCart($qty_arr);
            $inCore->redirect($_SERVER['REQUEST_URI']);
        }

        //получаем ID заказа (на случай если мы вернулись сюда из выбора оплаты)
        $order_id = $inCore->request('order_id', 'int', 0);

        //если заказ уже создавался, получаем его данные
        //и удаляем заказ (т.к. при переходе к выбору оплаты будет создан новый)
        if ($order_id){
            $order = $model->getOrder($order_id, md5(session_id()));
            if ($order){
                $model->deleteOrder($id, $order['secret_key']);
            }
        } else {
            $model->deleteExpiredOrders(session_id());
        }

        //Устанавливаем заголовок страницы
        $inPage->setTitle($_LANG['SHOP_START_ORDER']);
        $inPage->addPathway($_LANG['SHOP_START_ORDER']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');


        //получаем все товары из корзины для текущей сессии
        $items = $model->getCartItems($cfg);

        $itemsId = [];
        foreach ($items as $index => $item) {
            array_push($itemsId, $item['item_id']);
        }

        $paramsItems = $model->getParamsItems($itemsId);

        $totalsumm = 0;

        foreach($items as $item){
            $totalsumm += ($item['price'] * $item['cart_qty']);
        }
		$usrid = $inUser->id;
		$is_coin = $inDB->get_fields('cms_coins', "userid = '{$usrid}'", '*');
		if (($is_coin['coin']>0) && ($is_coin['is_used']==0)) {
			$discount_size = $is_coin['coin'];
		} else {		
			$discount_size = $model->getOrderDiscountSize($totalsumm);
		}
        $totalsumm = $model->getOrderSummDiscounted($totalsumm, $discount_size);

        //получаем способы доставки
        if ($items){
            $delivery_types = $model->getDeliveryTypes($totalsumm);
        }

        //получаем данные покупателя
        if ($inUser->id){
            $customer_data = $model->getCustomerData($inUser->id);
            if ($customer_data && !$order){
                $order = array();
                $order['customer_name']     = $customer_data['customer_name'];
                $order['customer_org']      = $customer_data['customer_org'];
                $order['customer_inn']      = $customer_data['customer_inn'];
                $order['customer_phone']    = $customer_data['customer_phone'];
                $order['customer_email']    = $customer_data['customer_email'];
                $order['customer_address']  = $customer_data['customer_address'];
            }
        }

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_order.tpl');
        $smarty->assign('cfg', $cfg);
        $smarty->assign('user_id', $inUser->id);
        $smarty->assign('customer_data', $customer_data);
		$smarty->assign('readonly', true);
        if (isset($order)) {
            $smarty->assign('order', $order);
        }
		$smarty->assign('items', $items);
        $smarty->assign('itemsParams', $paramsItems);
		$smarty->assign('delivery_types', $delivery_types);
		$smarty->assign('discount_size', $discount_size);
		$smarty->assign('totalsumm', round($totalsumm, 0));
		$smarty->assign('last_url', $_SESSION['inshop_last_url']);
		$smarty->display('com_inshop_order.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ПРОСМОТР КОРЗИНЫ
    //

    if ($do=='view_cart'){
		
        //Устанавливаем заголовок страницы
        $inPage->setTitle($_LANG['SHOP_CART']);
        $inPage->addPathway($_LANG['SHOP_CART']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');
        //получаем все товары из корзины для текущей сессии
        $items = $model->getCartItems($cfg);

        $totalsumm = 0;

        foreach($items as $item){
            $totalsumm += ($item['price'] * $item['cart_qty']);
        }
		
		$usrid = $inUser->id;
		$is_coin = $inDB->get_fields('cms_coins', "userid = '{$usrid}'", '*');
		if (($is_coin['coin']>0) && ($is_coin['is_used']==0)) {
			$discount_size = $is_coin['coin'];
		} else {		
			$discount_size = $model->getOrderDiscountSize($totalsumm);
		}
        $totalsumm = $model->getOrderSummDiscounted($totalsumm, $discount_size);

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_cart.tpl');
		$smarty->assign('readonly', false);
        $smarty->assign('cfg', $cfg);
		$smarty->assign('items', $items);
		$smarty->assign('discount_size', $discount_size);
		$smarty->assign('totalsumm', round($totalsumm, 0));
		$smarty->assign('last_url', $_SESSION['inshop_last_url']);
		$smarty->display('com_inshop_cart.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ
    //

    if ($do=='add_to_cart'){

        $item_id    = $inCore->request('add_to_cart_item_id', 'int', 0);
        $var_art_no = $inCore->request('var_art_no', 'str', '');
        $qty        = $inCore->request('qty', 'int', 1);
        $chars      = $inCore->request('chars', 'array', false);

        $model->addToCart($item_id, $var_art_no, $qty, $chars);

        if ($cfg['after_cart'] == 'stay'){
            $inCore->redirectBack();
        }

        if ($cfg['after_cart'] == 'cart'){
            $inCore->redirect('/shop/cart.html');
        }

        $inCore->redirectBack();

    }

//============================================================================//
//============================================================================//

    //
    // УДАЛЕНИЕ ТОВАРА ИЗ КОРЗИНЫ
    //

    if ($do=='delete_from_cart'){

        $item_id    = $inCore->request('delete_from_cart_item_id', 'int', 0);

        $model->deleteFromCart($item_id);

        $inCore->redirectBack();

    }

//============================================================================//
//============================================================================//

    //
    // ПРОХОЖДЕНИЕ ОПЛАТЫ (result-url для платежной системы)
    //

    if ($do=='process_payment'){

        $result = '';

        //проверяем платежную систему
        $psys_id = $inCore->request('psys_id', 'str', '');
        if (!$psys_id || mb_strstr($psys_id, '.')) { $inCore->halt("ERR: НЕВЕРНАЯ ПЛАТЕЖНАЯ СИСТЕМА"); }

        $psys = $model->getPaymentSystem($psys_id);

        if (!$psys) { $inCore->halt("ERR: НЕИЗВЕСТНАЯ ПЛАТЕЖНАЯ СИСТЕМА: $psys_id"); }

        //проверяем что заказ существует и он не оплачен
        $order_id = $inCore->request('order_id', 'int', 0);
        //робокасса возвращает InvId в качестве номера заказа
        if (!$order_id) { $order_id = $inCore->request('InvId', 'int', 0); }

        $order    = $model->getOrder($order_id);

        if (!$order) {
            $inCore->halt("ERR: НЕВЕРНЫЙ НОМЕР ЗАКАЗА");
        }

        $inCore->includeFile('components/shop/payments/paysys.class.php');
        $inCore->includeFile('components/shop/payments/'.$psys['link'].'/'.$psys['link'].'.php');

        $model->setOrderPaymentSystem($order_id, $psys['title']);
        $order['psys_title'] = $psys['title'];

        eval('$sys = new ps_'.$psys['link'].'($order, $psys[\'config\']);');

        $result = $sys->processPayment($model);

        echo $result;

    }

//============================================================================//
//============================================================================//

    //
    // УСПЕШНАЯ ОПЛАТА (success-url для платежной системы)
    //

    if ($do=='order_success'){

        $inPage->setTitle($_LANG['SHOP_ORDER_SUCCESS']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');
        $order_id = $inCore->request('order_id', 'int', 0);

        //робокасса возвращает InvId в качестве номера заказа
        if (!$order_id) { $order_id = $inCore->request('InvId', 'int', 0); }

        //интеркасса возвращает ik_payment_id в качестве номера заказа
        if (!$order_id) { $order_id = $inCore->request('ik_payment_id', 'int', 0); }

        //интеркасса 2.0 возвращает ik_pm_no в качестве номера заказа
        if (!$order_id) { $order_id = $inCore->request('ik_pm_no', 'int', 0); }	

		if (!$order_id) { $order_id = $_SESSION['orderid']; }
		
        $order = $model->getOrder($order_id);

		$order_items = $model->getCartItems($cfg);
		
		if ($order_items) {
		
        $orders  = "<script>";
        $orders  .= "window.dataLayer = window.dataLayer || [];";
        $orders  .= "dataLayer.push({";
        $orders  .= "'ecommerce': {";
        $orders  .= "  'currencyCode': 'KZT',";
        $orders  .= "  'purchase': {";
        $orders  .= "     'actionField': {";
        $orders  .= "      'id': '{$order['secret_key']}',";
        $orders  .= "      'affiliation': 'sanmarket.kz',";
        $orders  .= "      'revenue': '{$order['summ']}'";
        $orders  .= "    },";
        $orders  .= "    'products': [";
		$totals = count($order_items);
		$counters = 0;
        foreach($order_items as $item){	
		$counters++;
        $orders  .= "{";
			$orders  .= "'name': '{$item['title']}',";
			$orders  .= "'id': '{$item['art_no']}',";
			$orders  .= "'price': '{$item['price']}',";
			$orders  .= "'quantity': '{$item['cart_qty']}'";
        $orders  .= "}";	 
		if($counters < $totals){ $orders  .= ",";}		
        }		
				
        $orders  .= "	 ]";
        $orders  .= "  }";
        $orders  .= "},";
        $orders  .= "'event': 'gtmUaEvent',";
        $orders  .= "'gtmUaEventCategory': 'Enhanced Ecommerce',";
        $orders  .= "'gtmUaEventAction': 'Purchase',";
        $orders  .= "'gtmUaEventNonInteraction': 'False'";
        $orders  .= "});";	
		
	
		$orders .= "</script>";
		
		
        $showorders  = '<table class="table table-bordered">';

        foreach($order_items as $item){	
			$showorders  .= '<tr>';
			$showorders  .= '<td>'.$item['title'].'</td>';
			$showorders  .= '<td>'.$item['cart_qty'].' x</td>';
			$showorders  .= '<td>'.$item['price'].' kzt</td>';
			$showorders .= '</tr>';
        }		
	
		$showorders .= '</table>';
		if ($order['giftcode']>0) { $itogo = round($order['summ']-($order['summ']*$order['giftcode']/100),0); $gift = ', со скидкой '.$order['giftcode'].'% = '.$itogo.' kzt'; }
		$showorders .= '<div style="margin-top:15px;font-size:18px;text-align:right;">Итого: '.$order['summ'].' kzt'.$gift.' </div>';
		}	
		
        $model->clearCart(session_id());

        if ($order && ($order['status'] >= 1))  {
            $model->sendOrder($order, 'success', $cfg);
        }

        $message_text  = $_LANG['SHOP_ORDER_SUCCESS_TEXT'];

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_pay_result.tpl');
		$smarty->assign('success', true);
        $smarty->assign('cfg', $cfg);
		$smarty->assign('message_text', $message_text);
		$smarty->assign('order', $order);
		$smarty->assign('orders', $orders);
		$smarty->assign('showorders', $showorders);
		$smarty->assign('order_id', $order_id);
		$smarty->display('com_inshop_pay_result.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // НЕ УСПЕШНАЯ ОПЛАТА (fail-url для платежной системы)
    //

    if ($do=='order_fail'){

        $inPage->setTitle($_LANG['SHOP_ORDER_FAIL']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');
        $message_text = $_LANG['SHOP_ORDER_FAIL_TEXT'];

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_pay_result.tpl');
		$smarty->assign('success', false);
        $smarty->assign('cfg', $cfg);
		$smarty->assign('message_text', $message_text);
		$smarty->display('com_inshop_pay_result.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ОПЛАТА НЕ ТРЕБУЕТСЯ (для наличных и тп)
    //

    if ($do=='order_accept'){

        $inPage->setTitle($_LANG['SHOP_ORDER_ACCEPTED_TEXT']);
		$inPage->addHead('<meta name="robots" content="noindex, nofollow" />');
        $order_id   = $inCore->request('order_id', 'int', 0);
        //если оплата была отключена
        if ($cfg['is_skip_pay']) {
            $order_id = cmsUser::sessionGet('order_id');
            cmsUser::sessionDel('order_id');
        }

		if (!$order_id) { $order_id = $_SESSION['orderid']; }	
		
        $order    = $model->getOrder($order_id);

		$order_items = $model->getCartItems($cfg);
		
		if ($order_items) {
		
        $orders  = "<script>";
        $orders  .= "window.dataLayer = window.dataLayer || [];";
        $orders  .= "dataLayer.push({";
        $orders  .= "'ecommerce': {";
        $orders  .= "  'currencyCode': 'KZT',";
        $orders  .= "  'purchase': {";
        $orders  .= "     'actionField': {";
        $orders  .= "      'id': '{$order['secret_key']}',";
        $orders  .= "      'affiliation': 'sanmarket.kz',";
        $orders  .= "      'revenue': '{$order['summ']}'";
        $orders  .= "    },";
        $orders  .= "    'products': [";
		$totals = count($order_items);
		$counters = 0;
        foreach($order_items as $item){	
		$counters++;
        $orders  .= "{";
			$orders  .= "'name': '{$item['title']}',";
			$orders  .= "'id': '{$item['art_no']}',";
			$orders  .= "'price': '{$item['price']}',";
			$orders  .= "'quantity': '{$item['cart_qty']}'";
        $orders  .= "}";	 
		if($counters < $totals){ $orders  .= ",";}		
        }		
				
        $orders  .= "	 ]";
        $orders  .= "  }";
        $orders  .= "},";
        $orders  .= "'event': 'gtmUaEvent',";
        $orders  .= "'gtmUaEventCategory': 'Enhanced Ecommerce',";
        $orders  .= "'gtmUaEventAction': 'Purchase',";
        $orders  .= "'gtmUaEventNonInteraction': 'False'";
        $orders  .= "});";	
		
	
		$orders .= "</script>";
		
		
        $showorders  = '<table class="table table-bordered" style="max-width:600px;">';

        foreach($order_items as $item){	
			$showorders  .= '<tr>';
			$showorders  .= '<td>'.$item['title'].'</td>';
			$showorders  .= '<td>'.$item['cart_qty'].' x</td>';
			$showorders  .= '<td>'.$item['price'].' kzt</td>';
			$showorders .= '</tr>';
        }		
	
		$showorders .= '</table>';
		$showorders .= '<div style="max-width:600px;margin-top:15px;font-size:18px;text-align:right;">Итого: '.$order['summ'].' kzt</div>';		
		
		}
		
        $model->clearCart(session_id());
		
        if ($order) { $model->sendOrder($order, 'accept', $cfg); }

        $message_text = $_LANG['SHOP_ORDER_ACCEPTED_TEXT'];

        //передаем все в шаблон
		$smarty = cmsPage::initTemplate('components', 'com_inshop_pay_result.tpl');
		$smarty->assign('accept', true);
        $smarty->assign('cfg', $cfg);
		$smarty->assign('order_id', $order_id);
		$smarty->assign('showorders', $showorders);		
		$smarty->assign('orders', $orders);
		$smarty->assign('message_text', $message_text);
		$smarty->display('com_inshop_pay_result.tpl');

    }

//============================================================================//
//============================================================================//

    //
    // ЗАГРУЗКА ФАЙЛА ХАРАКТЕРИСТИКИ
    //

    if ($do=='download_char'){

        $item_id = $inCore->request('item_id', 'int', 0);
        $char_id = $inCore->request('char_id', 'int', 0);

        if (!$item_id || !$char_id) { $inCore->halt('no item'); }

        $file = '/upload/userfiles/shop-char-'.$item_id.'-'.$char_id.'.file';

        if (!file_exists(PATH. $file)) { $inCore->halt('no file'); }

        $data = $inDB->get_field('cms_shop_chars_val', "item_id={$item_id} AND char_id={$char_id}", 'val');

        $data = $inCore->yamlToArray($data);

        if (!is_array($data)) { $inCore->halt('no data'); }

        header('Content-Disposition: attachment; filename='.$data['name'] . "\n");
        header('Content-Type: application/x-force-download; name="'.$file.'"' . "\n\n");

        echo file_get_contents(PATH . $file);

        $inCore->halt();

    }

//============================================================================//
//============================================================================//

    //
    // Генерация квитанции Сбербанка
    //

    if ($do=='sberbank'){

        $sbrf = $model->getPaymentSystem('sberbank');
        if (!$sbrf) { $inCore->halt(); }

        $order_id   = $inCore->request('order_id', 'int', 0);
        $order      = $model->getOrder($order_id);
        if (!$order) { $inCore->halt(); }

        $currency_kurs  = $sbrf['config']['currency']['RUR'];
        $order['summ']  = round($order['summ']/$currency_kurs, 2);

        $order['title']         = 'Оплата заказа №'.$order_id;
        $order['summ_parts']    = explode('.', $order['summ']);

        $month = mb_strtolower(cmsCore::intMonthToStr(date('F')));

        for($i=0; $i<10; $i++){
            if (!isset($sbrf['config']['SBRF_SHOP_INN']['value'][$i])){
                $sbrf['config']['SBRF_SHOP_INN']['value'][$i] = '&nbsp;';
            }
            if (!isset($sbrf['config']['SBRF_SHOP_BIK']['value'][$i])){
                $sbrf['config']['SBRF_SHOP_BIK']['value'][$i] = '&nbsp;';
            }
        }

        for($i=0; $i<20; $i++){
            if (!isset($sbrf['config']['SBRF_SHOP_ACC']['value'][$i])){
                $sbrf['config']['SBRF_SHOP_ACC']['value'][$i] = '&nbsp;';
            }
            if (!isset($sbrf['config']['SBRF_SHOP_KS']['value'][$i])){
                $sbrf['config']['SBRF_SHOP_KS']['value'][$i] = '&nbsp;';
            }
        }

        if ($order['summ_parts'][1]=='') { $order['summ_parts'][1] = '00'; }

        if (!$order['customer_name']) { $order['customer_name'] = '&nbsp;'; }
        if (!$order['customer_address']) { $order['customer_address'] = '&nbsp;'; }

        $model->setOrderPaymentSystem($order_id, 'СберБанк РФ');

        include(PATH.'/components/shop/payments/sberbank/template.php');

        $inCore->halt();

    }

//============================================================================//
//============================================================================//

    //
    // Генерация счета для оплаты по безналу
    //

    if ($do=='beznal'){

        $bill = $model->getPaymentSystem('bill');
        if (!$bill) { $inCore->halt(); }

        $order_id   = $inCore->request('order_id', 'int', 0);
        $order      = $model->getOrder($order_id);
        if (!$order) { $inCore->halt(); }

        $order['summ_parts']    = explode('.', $order['summ']);

        $month = mb_strtolower(cmsCore::intMonthToStr(date('F')));

        if ($order['summ_parts'][1]=='') { $order['summ_parts'][1] = '00'; }

        $model->setOrderPaymentSystem($order_id, 'Безналичный расчет');

        $currency_kurs  = $bill['config']['currency']['RUR'];
        $order['summ']  = round($order['summ']/$currency_kurs, 2);

        include(PATH.'/components/shop/payments/bill/template.php');

        $inCore->halt();

    }

//============================================================================//
//============================================================================//

    //
    // Оплата баллами биллинга
    //

    if ($do=='balance'){

        $is_billing = $inCore->isComponentInstalled('billing');

        if ($is_billing) {
            $inCore->loadClass('billing');
        } else {
            $inCore->halt('Требуется <a href="http://www.instantcms.ru/billing/about.html">Биллинг пользователей</a>');
        }

        $order_id   = $inCore->request('order_id', 'int', 0);
        $order      = $model->getOrder($order_id);

        if (!$order){ $inCore->halt(); }

        $bill = $model->getPaymentSystem('balance');

        $currency_kurs  = $bill['config']['currency']['RUR'];

        $summ = round($order['summ']/$currency_kurs, 2);
        $balance = $inUser->balance;

        $comment = $_LANG['SHOP'].': '.$_LANG['SHOP_ORDER'].' #'.$order_id;

        if ($balance < $summ){

            $billing_ticket = array(
                'action' => $comment,
                'cost'   => $summ,
                'amount' => $summ-$balance,
                'url'    => $_SERVER['REQUEST_URI']
            );
            cmsUser::sessionPut('billing_ticket', $billing_ticket);

            $inCore->redirect('/billing/pay');
            return;

        }

        if ($balance >= $summ){
            cmsBilling::pay($inUser->id, $summ, $comment, false);
            $model->setOrderStatus($order['id'], $order['secret_key'], 2);
            $order['status'] = 2;
            $model->sendOrder($order, 'accept', $inCore->loadComponentConfig('shop'));
            $model->clearCart(session_id());
            $inCore->redirect('/shop/order-success.html');
        }

    }

//============================================================================//
//============================================================================//

    if ($do=='set_sort'){

        $orderby = $inCore->request('orderby', 'str', 'ordering');
        $orderto = $inCore->request('orderto', 'str', 'asc');

        $_SESSION['inshop_orderby'] = $orderby;
        $_SESSION['inshop_orderto'] = $orderto;

        $inCore->redirectBack();

    }

//============================================================================//
//============================================================================//

    if ($do == 'rate_item'){

        $item_id    = $inCore->request('item_id', 'int');
        $points     = $inCore->request('points', 'int');

        $user_id    = $inUser->id;

        $model->rateItem($item_id, $user_id, $points);

        $inCore->redirectBack();

    }

//============================================================================//
//============================================================================//

    if ($do == 'export_yml'){

        $inConf = cmsConfig::getInstance();

        if (!$cfg['yml']['shop_name']) { $cfg['yml']['shop_name'] = $inConf->sitename; }
        if (!$cfg['yml']['shop_url']) { $cfg['yml']['shop_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/'; }
        if (!$cfg['yml']['base_curr']) { $cfg['yml']['base_curr'] = 'RUR'; }
        if (!$cfg['yml']['curr']['RUR']) { $cfg['yml']['curr']['RUR'] = 'CBRF'; }
        if (!$cfg['yml']['curr']['UAH']) { $cfg['yml']['curr']['UAH'] = 'CBRF'; }
        if (!$cfg['yml']['curr']['BYR']) { $cfg['yml']['curr']['BYR'] = 'CBRF'; }
        if (!$cfg['yml']['curr']['KZT']) { $cfg['yml']['curr']['KZT'] = 'CBRF'; }
        if (!$cfg['yml']['curr']['USD']) { $cfg['yml']['curr']['USD'] = 'CBRF'; }
        if (!$cfg['yml']['curr']['EUR']) { $cfg['yml']['curr']['EUR'] = 'CBRF'; }
        if (!$cfg['yml']['ldc']) { $cfg['yml']['ldc'] = 0; }
        if (!isset($cfg['yml']['store'])) { $cfg['yml']['store'] = -1; }
        if (!isset($cfg['yml']['pickup'])) { $cfg['yml']['pickup'] = -1; }
        if (!isset($cfg['yml']['delivery'])) { $cfg['yml']['delivery'] = -1; }

        $cats = $model->getCategories();

        $model->groupBy('i.id');
        $model->limitIs(10000);
        $items = $model->getItems(true);

        $file = 'components/com_inshop_yml.php';

        echo '<?xml version="1.0" encoding="utf-8"?>'."\n";

        if (file_exists(TEMPLATE_DIR.$file)){
            include(TEMPLATE_DIR.$file);
        } else {
            include(DEFAULT_TEMPLATE_DIR.$file);
        }

        exit;

    }

//============================================================================//
//============================================================================//

}
