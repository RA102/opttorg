<?php

// ========================================================================== //

    function info_component_shop(){

        //Описание компонента

        $_component['title']        = 'InstantShop';                        //название
        $_component['description']  = 'Магазин для InstantCMS';             //описание
        $_component['link']         = 'shop';                               //ссылка (идентификатор)
        $_component['author']       = 'InstantSoft';                        //автор
        $_component['internal']     = '0';                                  //внутренний (только для админки)? 1-Да, 0-Нет
        $_component['version']      = '2.2';                                //текущая версия

        //Настройки по-умолчанию
        $_component['config'] = array(
             'is_shop'=>1,
             'is_skip_pay'=>1,
             'show_vendors'=>1,
             'show_cats'=>1,
             'show_subcats'=>1,
             'show_desc'=>1,
             'show_full_desc'=>1,
             'show_thumb'=>1,
             'show_hit_img'=>1,
             'show_decimals'=>2,
             'show_filter'=>1,
             'show_filter_vendors'=>1,
             'show_compare'=>1,
             'show_char_grp'=>1,
             'show_comments'=>0,
             'show_related'=>1,
             'related_count'=>5,
             'img_w'=>350,
             'img_h'=>350,
             'thumb_w'=>150,
             'thumb_h'=>150,
             'img_sqr'=>0,
             'thumb_sqr'=>1,
             'watermark'=>0,
             'perpage'=>15,
             'currency'=>'руб.',
             'notify_send'=>0,
             'notify_send_customer'=>0,
             'notify_email'=>'orders@instantshop.ru',
             'qty_mode'=>'any',
             'subcats_order'=>'title',
             'show_cat_chars'=>0,
             'show_items_nav'=>0,
             'link_ttl'=>48,
//             'items_orderby'=>'ordering',
             'items_orderby'=>'qty',
             'items_orderto'=>'desc',
             'after_cart'=>'stay',
             'ord_req'=>array('name', 'email', 'org', 'inn', 'phone', 'email', 'address'),
             'track_qty'=>0,
             'compare_prices'=>1,
             'discount'=>'',
             'ratings'=>1
        );

        return $_component;

    }

// ========================================================================== //

    function install_component_shop(){

        $inCore     = cmsCore::getInstance();       //подключаем ядро
        $inDB       = cmsDatabase::getInstance();   //подключаем базу данных
        $inConf     = cmsConfig::getInstance();

        include($_SERVER['DOCUMENT_ROOT'].'/includes/dbimport.inc.php');

        dbRunSQL($_SERVER['DOCUMENT_ROOT'].'/components/shop/install.sql', $inConf->db_prefix);

        return true;

    }

// ========================================================================== //

    function upgrade_component_shop(){

        return true;

    }

// ========================================================================== //


