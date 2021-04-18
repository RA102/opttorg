<?php

/*
 * Доступны объекты $inCore $inUser $inPage($this) $inConf $inDB
 */

// Получаем количество модулей на нужные позиции
$mod_count['top'] = $this->countModules('top');
$mod_count['topmenu'] = $this->countModules('topmenu');
$mod_count['sidebar'] = $this->countModules('sidebar');
$mod_count['sidebar-1'] = $this->countModules('sidebar-1');
$mod_count['accordeon'] = $this->countModules('accordeon');
// подключаем jQuery и js ядра в самое начало
$this->prependHeadJS('core/js/common.js');
$this->prependHeadJS('includes/jquery/jquery.js');
$this->autoIncludeFilesInDirectory('/templates/'. TEMPLATE .'/js/autoload');
//$this->addHeadJS('templates/' . TEMPLATE . '/js/popper.js');
$this->addHeadJS('templates/' . TEMPLATE . '/js/jquery.cookie.js');

//$this->addHeadJS('templates/' . TEMPLATE . '/js/bootstrap-4.js');
// Подключаем стили шаблона
$this->addHeadcss('templates/' . TEMPLATE . '/css/bootstrap.css');
$this->addHeadcss('templates/' . TEMPLATE . '/css/bootstrap-grid.css');
$this->addHeadcss('templates/' . TEMPLATE . '/css/bootstrap-reboot.css');
//$this->addHeadcss('templates/' . TEMPLATE . '/css/bootstrap-4.css');
$this->addHeadcss('templates/' . TEMPLATE . '/css/bootstrap-select v1.13.14.css');

$this->addHeadCSS('templates/' . TEMPLATE . '/css/all.css?v=' . rand(10, 1000));



$this->addHeadJS('templates/' . TEMPLATE . '/js/bootstrap-select.js');



// Подключаем colorbox (просмотр фото)
$this->addHeadJS('templates/' . TEMPLATE . '/js/lib_timer.js');
$this->addHeadJS('includes/jquery/colorbox/jquery.colorbox.js');
$this->addHeadJS('includes/jquery/colorbox/init_colorbox.js');
$this->addHeadJS('components/registration/js/check.js');
$this->addHeadJS('components/shop/js/delivery.js');
$this->addHeadJS('templates/'. TEMPLATE . '/js/custom.js');

$this->addHeadCSS('includes/jquery/colorbox/colorbox.css');
// LANG фразы для colorbox
$this->addHeadJsLang(array('CBOX_IMAGE', 'CBOX_FROM', 'CBOX_PREVIOUS', 'CBOX_NEXT', 'CBOX_CLOSE', 'CBOX_XHR_ERROR', 'CBOX_IMG_ERROR', 'CBOX_SLIDESHOWSTOP', 'CBOX_SLIDESHOWSTART'));
/*
if (isset($_POST['my_city'])) {
    $_SESSION['my_city'] = $_POST['my_city'];
}
if (isset($_SESSION['my_city'])) {
    $gorod = $_SESSION['my_city'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
    $quer = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip.'?lang=ru'));
    if($quer && $quer['status'] == 'success') {
        $gorod = $quer['city'];
    } else {
        $gorod = 'не определён';
    }
}
*/

if ((isset($_POST['price1'])) && (isset($_POST['ttl']))) {
    $usr = $_POST['yname'];
    $usr = htmlspecialchars($usr);
    $usr = urldecode($usr);
    $usr = trim($usr);
    $phn = $_POST['ytel'];
    $phn = htmlspecialchars($phn);
    $phn = urldecode($phn);
    $phn = trim($phn);
    $qty = $_POST['qtyy1'];
    $prc = $_POST['price1'];
    $ttl = $_POST['ttl'];
    $art = $_POST['arts'];
    $mail = $_POST['email'];
    $city = $_POST['city'];
    $link = $_SERVER['HTTP_ORIGIN']."{$_POST['seolink']}";
    $tot = $qty * $prc;
    $subject = 'Запрос с сайта';
    $message = '
	<p>От: ' . $usr . '</p>
	<p>Перезвонить: ' . $phn . '</p>
	<p>АРТ: ' . $art . ': ' . $ttl . ' - ' . $qty . ' x ' . $prc . ' = ' . $tot . ' kzt</p>
	<p>Город: ' . $city .'</p>
	<p>Email: ' . $mail .'</p>
	<p><a href="'.$link.'">'.$ttl.'</a></p>
	';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'To: <santehopttorg00@mail.ru>' . "\r\n";
    $headers .= 'From: <santehopttorg00@mail.ru>' . "\r\n";
    mail('santehopttorg00@mail.ru', $subject, $message, $headers);
}
?>
<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
<head>
    <?php $LastModified_unix = strtotime(date("D, d M Y H:i:s", filectime($_SERVER['SCRIPT_FILENAME'])));
    $LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
    $IfModifiedSince = false;
    if (isset($_ENV['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
    if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
        exit;
    }
    header('Last-Modified: ' . $LastModified);
    header('Vary: User-Agent'); ?>
    <meta charset="utf-8">
    <meta name="yandex-verification" content="312a4cd886e70dca"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="DYDKBWosEuCVKRJ67c6OqTsTAZoxC2pionvAzroxARs"/>
    <?php $this->printHead(); ?>


    <!--  новый слайдер   -->
    <script type="text/javascript" src="/templates/basic_free/js/modernizr.custom.46884.js"></script>
    <script type="text/javascript" src="/templates/basic_free/js/jquery.slicebox.js"></script>
    <!--  /новый слайдер  -->

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NZN89PK');
    </script>
    <!-- /Google Tag Manager -->


    <meta property="og:locale" content="ru_KZ"/>

    <?php if (!$this->page_body) { ?>
        <meta http-equiv="Cache-Control" content="max-age=86400, must-revalidate">
        <link rel="canonical" href="https://sanmarket.kz"/>
        <meta property="og:title" content="Интернет магазин сантехники в Казахстане — SanMarket.kz"/>
        <meta property="og:description" content="Хотите купить сантехнику? Большой магазин сантехники SanMarket.kz☝ ➥ Низкие цены ➥ Все для ванной. ➥ Широкий ассортимент. Покупай онлайн и недорого! ⛟ Доставка → по Казахстану."/>
        <meta property="og:url" content="https://sanmarket.kz"/>
        <meta property="og:image" content="https://sanmarket.kz/templates/<?php echo TEMPLATE; ?>/img/logo.png"/>
    <?php } ?>
    <?php
    $inUser = cmsUser::getInstance();
    if ($inUser->is_admin) {
        ?>
        <script src="/admin/js/modconfig.js" type="text/javascript"></script>
        <link href="/templates/<?php echo TEMPLATE; ?>/css/modconfig.css" rel="stylesheet" type="text/css"/>
    <?php } ?>
    <!--[if lt IE 9] -->
            <script src="/templates/<?php echo TEMPLATE; ?>/js/html5shiv.js"></script>
            <script src="/templates/<?php echo TEMPLATE; ?>/js/respond.min.js"></script>
            <script src="/templates/<?php echo TEMPLATE; ?>/js/css3-mediaqueries.js"></script>
<!--            <script src="/templates/--><?php //echo TEMPLATE; ?><!--/js/jquery.cookie.js"></script>-->


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">




    <link rel="stylesheet" href="/templates/<?php echo TEMPLATE; ?>/css/ie.css" type="text/css" media="all" />
        <!-- [endif]-->
    <link rel="icon" type="image/svg" href="/images/favicon.svg"/>
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico"/>

    <!--  Новый слайдер  -->

    <link rel="stylesheet" type="text/css" href="/templates/basic_free/css/slicebox.css" />
    <!--    <link rel="stylesheet" type="text/css" href="/templates/basic_free/css/custom.css" />-->

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">



    <script src="/templates/<?php echo TEMPLATE; ?>/js/fixedsticky.js"></script>
    <script src="/templates/<?php echo TEMPLATE; ?>/js/seohide.js"></script>
    <script src="/templates/<?php echo TEMPLATE; ?>/js/fish.js"> </script>
    <script src="/templates/<?php echo TEMPLATE; ?>/js/custom.js"></script>

    <!-- VueJS and Vuetify  -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

    <!-- /VueJS and Vuetify -->
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>
    <!--/Axios-->

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-393443092"></script>

    <meta name="mailru-domain" content="JfeuTFsOLTPijEWd"/>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '218958602915744');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=218958602915744&ev=PageView&noscript=1"/></noscript>
    <!-- / Facebook Pixel Code -->

    <script>
        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-393443092/htXHCNua8_8BEJTuzbsB',
                'event_callback': callback
            });
            return false;
        }
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-393443092"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'AW-393443092');
    </script>

</head>
<body>
<div class="body-wrapper">
    <div id="mass" style="position:fixed;top:0;left:0;background:#dedede;z-index:9999;font-size:8px;padding:1px;"></div>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NZN89PK" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- /Google Tag Manager (noscript) -->
    <a name="top"></a>
    <?php
    $inConf = cmsConfig::getInstance();
    if ($inConf::getConfig('marquee')) {
        ?>
        <div class="marquee-container">
            <div class="container">
                <div class="marquee"><span><?php echo $inConf::getConfig('marquee'); ?></span></div>
            </div>
        </div>
    <?php } ?>
    <div class="top-line">
        <div class="container">
			<span class="pull-left">
				<span class="d-md-none d-sm-none d-none">ИНТЕРНЕТ-МАГАЗИН САНТЕХНИКИ</span>
				<a class="d-lg-none" href="/shop/cart.html"><?php $this->printModules('b-cart'); ?></a>
				<a class="d-lg-none" href="#" data-toggle="modal" data-target="#search_modal"><span class="glyphicon glyphicon-search"></span></a>
				<a class="d-lg-none" href="#" data-toggle="modal" data-target="#city_modal"><span class="glyphicon glyphicon-map-marker"></span></a>
				<a class="d-lg-none" href="tel:+77775409927"><span class="glyphicon glyphicon-phone"></span></a>
			</span>
        </div>
    </div>

    <header class="navbar-nav navbar-expand">
        <div class="main-body">
            <div class="container-fluid ">
                <div class="row px-0 header-row">
                    <!--  logo    -->
                    <div class="col-6 col-lg-6 col-xl-3 mt-auto">
                        <a class="navbar-brand" href="/" rel="home" title="Интернет-магазин сантехники sanmarket">
                            <img class="" src="/templates/<?php echo TEMPLATE; ?>/images/LOGO_full_blue.svg" alt="SanMarket интернет-магазин сантехники в Казахстане"/>
                        </a>
                    </div>
                    <!-- /logo -->

                    <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block col-xl-9 px-0" >
                        <div class="row">
                            <div class=" col-xl-8 mt-auto">
                                <div class="input-group">
                                    <input id="main-search" name="referal" class="input-search form-control position-relative" type="search" placeholder="Начать поиск...">
                                    <div class="input-group-append">
                                        <button id="icon-search" class="btn btn-secondary" type="button" >
                                            <img class="" src="/templates/<?php echo TEMPLATE; ?>/images/glass.png" width="32" height="32" alt="search" />
                                        </button>
                                    </div>
                                    <ul class="search_result list-search"></ul>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-4 mt-auto" >
                                <div class="d-block">
                                    <div class="d-block mb-2 wrapper-login">
                                        <img class="d-inline-block mr-2" src="/templates/<?php echo TEMPLATE; ?>/images/user_img.png" alt="userImg" width="26" height="26">
                                        <?php $userlogs = $inUser->login;
                                        $usgro = $inUser->group_id;
                                        ?>
                                        <?php if ($userlogs) { ?>
                                            <div id="logout-wrapper">
                                                <a id="user-name" style="font-size: 16px; font-weight: 700;" href="/users/<?php echo $userlogs; ?>"><?php echo $userlogs; ?> </a>
                                                <div class="jlreg_auth_lgogout" style="display: inline-block;">
                                                    <img class="mx-2" src="/templates/<?php echo TEMPLATE; ?>/images/logout.png" alt="exit" width="18" height="18">
                                                    <a id="logout-exit" href="/logout">Выход</a>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="d-inline-block">
                                                <span id="btn-login" class="login" style="background-color: #ffffff;" data-toggle="modal" data-target="#modalLogin">Войти</span>
                                                <span class="mx-2">/</span>
                                                <span id="registration" class="registration" data-toggle="modal" data-target="#modalAuth">Регистрация</span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <a class="btn-order-call ml-auto" href="#" data-toggle="modal" data-target="#order-call" >Заказать звонок</a> <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--    иконки мобильная версия (акции, телефон, корзина)     -->
                    <div class="col-6 col-md-6 col-lg-6 d-flex d-lg-flex d-xl-none justify-content-flex-end mobile-block">
                        <div class="header-icon">
                            <a href="https://wa.me/77775409927">
                                <img class="img-icon img-fluid" src="/templates/basic_free/images/top/chat1.png" alt="chat">
                            </a>
                        </div>
                        <div class="header-icon">
                            <!--					<a href="tel:+77212503272">+7 7212 47 78 24</a><br />-->
                            <a href="tel:+77775409927">
                                <img class="img-icon " src="/templates/basic_free/images/top/PHONE.png" alt="phone">
                            </a>
                        </div>
                        <div class="header-icon">
                            <span class="hlink" data-href="<?php echo base64_encode('/shop/cart.html'); ?>"><?php $this->printModules('b-cart'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="d-none">
                </div>

                <nav class="row d-none d-sm-none d-md-none d-lg-none d-xl-flex border-top justify-content-between">
                    <div class="position-relative">
                        <?php $this->printModules('top'); ?>
                    </div>

                    <div class="d-inline-flex align-items-center">
                        <div class="icon-top-bar">
                            <img src="/templates/basic_free/images/stock.png" alt="Акции" width="30">
                            <a href="/shop/akcii">Акции</a>
                        </div>
                        <div class="icon-top-bar" style="">
                            <!--					<a href="tel:+77212503272">+7 7212 47 78 24</a><br />-->
                            <img src="/templates/basic_free/images/top/PHONE.png" alt="phone" width="30">
                            <a href="https://wa.me/77775409927">+7 777 540 99 27</a>
                        </div>
                        <div class="icon-top-bar">
                            <span class="hlink" data-href="<?php echo base64_encode('/shop/cart.html'); ?>"><?php $this->printModules('b-cart'); ?></span>
                        </div>
                    </div>
                </nav>

            </div>
        </div>
    </header>

    <div id="toast-wrap" class="d-none" aria-live="polite" aria-atomic="true" style="position: fixed; top: 10%; right: 0; z-index: 11000;">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"  data-autohide="true" data-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto">Заказ в один клик</strong>
<!--                <small>sanmarket.kz</small>-->
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" style="padding: 20px 30px;">
                Заявка отправлена
            </div>
        </div>
    </div>
    <div class="main-body">
        <div class="container-fluid d-block d-lg-block d-xl-none mt-5 mb-5">
            <div class="search-mobile">
                <input class="search-mobile-input search-all" type="text" placeholder="Начать поиск...">
                <ul class="search_result list-search"></ul>
                <button id="icon-search" class="btn-search-mobile " type="submit">
                    <img class="" src="/templates/<?php echo TEMPLATE; ?>/images/glass.png" width="32" height="32" alt="search" />
                </button>
            </div>
        </div>
        <?php if ($this->pathway['1']['link'] == '/den-rozhdenie.html') { ?>
            <main class="main" style="margin-top: 0; background-color: #ffffff">

                <div class="component">
                    <div class="">
                        <?php $messages = cmsCore::getSessionMessages(); ?>
                        <?php $this->printBody(); ?>
                    </div>
                </div>
            </main>
        <?php } elseif ($this->page_body) { ?>
            <main class="main">
                <div class="component">
                    <div class="container mobile-container">
                        <?php $this->printPathway('&rarr;'); ?>
                        <?php $messages = cmsCore::getSessionMessages(); ?>
                        <?php if ($messages) { ?>
                            <div class="alert alert-warning text-center" id="sess_messages">
                                <?php foreach ($messages as $message) { ?>
                                    <?php echo $message; ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if ((isset($_POST['price1'])) && (isset($_POST['ttl']))) { ?>
                            <div class="alert alert-warning text-center" id="sess_messages">
                                Ваш заказ принят! Мы Вам перезвоним!
                            </div>
                        <?php } ?>

                        <?php $this->printBody(); ?>
                    </div>
                </div>
            </main>
        <?php } else { ?>
            <?php
            $inDB = cmsDatabase::getInstance();
            $banners_top = $inDB->query("SELECT * FROM `cms_banners` WHERE `published` = '1' ORDER BY `position` DESC LIMIT 5");
            $banner1 = $inDB->get_fields('cms_banners', "position = 'banner1' AND published = 1", '*');
            $banner2 = $inDB->get_fields('cms_banners', "position = 'banner2' AND published = 1", '*');
            $banner3 = $inDB->get_fields('cms_banners', "position = 'banner3' AND published = 1", '*');
            $banner4 = $inDB->get_fields('cms_banners', "position = 'banner4' AND published = 1", '*');
            $banner5 = $inDB->get_fields('cms_banners', "position = 'banner5' AND published = 1", '*');
            $banner6 = $inDB->get_fields('cms_banners', "position = 'banner6' AND published = 1", '*');
            $banner7 = $inDB->get_fields('cms_banners', "position = 'banner7' AND published = 1", '*');
            $banner8 = $inDB->get_fields('cms_banners', "position = 'banner8' AND published = 1", '*');
            $banner9 = $inDB->get_fields('cms_banners', "position = 'banner9' AND published = 1", '*');
            $banner10 = $inDB->get_fields('cms_banners', "position = 'banner10' AND published = 1", '*');
            /*
            while($bt = $inDB->fetch_assoc($banners_top)){

            }
            */

            $arrayBannerItems = [];

            array_push($arrayBannerItems, $banner1);
            array_push($arrayBannerItems, $banner2);
            array_push($arrayBannerItems, $banner3);
            array_push($arrayBannerItems, $banner4);
            array_push($arrayBannerItems, $banner5);
            array_push($arrayBannerItems, $banner6);
            array_push($arrayBannerItems, $banner7);
            array_push($arrayBannerItems, $banner8);
            array_push($arrayBannerItems, $banner9);
            array_push($arrayBannerItems, $banner10);

            ?>
            <?php if ($banner1) { ?>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <section class="main-banner">
                            <!--  Слайдер html  -->
                            <div class="wrapper">
                                <!--                            <div id="carousel-1" class="carousel slide carousel-fabe" data-ride="carousel" data-interval="0">-->
                                <!--                            <ol id="indicators" class="carousel-indicators">-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="0" class="active"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="1"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="2"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="3"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="4"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="5"></li>-->
                                <!--                                <li data-target="#carousel-1" data-slide-to="6"></li>-->
                                <!--                            </ol>-->
                                <ul id="sb-slider" class="sb-slider">
                                    <li>
                                        <a href="<?php echo $banner1['link']; ?>" title="<?php echo $banner1['title']; ?>">
                                            <img src="/images/banners/<?php echo $banner1['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner1['title']; ?>"/>
                                        </a>
                                        <!-- <a href="--><?php //echo $banner1['link']; ?><!--" title="--><?php //echo $banner1['title']; ?><!--">-->
                                        <!-- <img src="/images/banners/--><?php //echo $banner1['fileurl2']; ?><!--" class="img-fluid d-lg-none d-md-none d-block img-carousel" alt="--><?php //echo $banner1['title']; ?><!--"/>-->
                                        <!-- </a>-->

                                    </li>

                                    <?php if ($banner2) { ?>

                                        <li>
                                            <a href="<?php echo $banner2['link']; ?>" title="<?php echo $banner2['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner2['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner2['title']; ?>" />
                                            </a>
                                            <!-- <a href="--><?php //echo $banner2['link']; ?><!--" title="--><?php //echo $banner2['title']; ?><!--">-->
                                            <!-- <img  src="/images/banners/--><?php //echo $banner2['fileurl2']; ?><!--" class="img-fluid d-lg-none d-md-none d-block img-carousel" alt="--><?php //echo $banner2['title'];  ?><!--"/>-->
                                            <!-- </a>-->

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner3) { ?>

                                        <li>
                                            <a href="<?php echo $banner3['link']; ?>" title="<?php echo $banner3['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner3['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner3['title']; ?>" />
                                            </a>
                                            <!-- <a href="--><?php //echo $banner3['link']; ?><!--" title="--><?php //echo $banner3['title']; ?><!--">-->
                                            <!-- <img src="/images/banners/--><?php //echo $banner3['fileurl2']; ?><!--" class="img-fluid d-lg-none d-md-none d-block img-carousel" alt="--><?php //echo $banner3['title']; ?><!--"/>-->
                                            <!-- </a>-->

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner4) { ?>

                                        <li>
                                            <a href="<?php echo $banner4['link']; ?>" title="<?php echo $banner4['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner4['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner4['title']; ?>"/>
                                            </a>
                                            <!-- <a href="--><?php //echo $banner4['link']; ?><!--" title="--><?php //echo $banner4['title']; ?><!--">-->
                                            <!-- <img src="/images/banners/--><?php //echo $banner4['fileurl2']; ?><!--" class="img-fluid d-lg-none d-md-none d-block img-carousel" alt="--><?php //echo $banner4['title']; ?><!--"/>-->
                                            <!-- </a>-->

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner5) { ?>

                                        <li>
                                            <a href="<?php echo $banner5['link']; ?>" title="<?php echo $banner5['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner5['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner5['title']; ?>" />
                                            </a>
                                            <!-- <a href="--><?php //echo $banner5['link']; ?><!--" title="--><?php //echo $banner5['title']; ?><!--">-->
                                            <!-- <img src="/images/banners/--><?php //echo $banner5['fileurl2']; ?><!--" class="img-fluid d-lg-none d-md-none d-block img-carousel" alt="--><?php //echo $banner5['title']; ?><!--"/>-->
                                            <!-- </a>-->

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner6) { ?>

                                        <li>
                                            <a href="<?php echo $banner6['link']; ?>" title="<?php echo $banner6['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner6['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner6['title']; ?>" />
                                            </a>

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner7) { ?>

                                        <li>
                                            <a href="<?php echo $banner7['link']; ?>" title="<?php echo $banner7['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner7['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner7['title']; ?>" />
                                            </a>

                                        </li>


                                    <?php } ?>
                                    <?php if ($banner8) { ?>

                                        <li>
                                            <a href="<?php echo $banner8['link']; ?>" title="<?php echo $banner8['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner8['fileurl']; ?>" class=" img-carousel" alt="<?php echo $banner8['title']; ?>" />
                                            </a>

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner9) { ?>

                                        <li>
                                            <a href="<?php echo $banner9['link']; ?>" title="<?php echo $banner9['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner9['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner9['title']; ?>"/>
                                            </a>

                                        </li>

                                    <?php } ?>
                                    <?php if ($banner10) { ?>

                                        <li>
                                            <a href="<?php echo $banner10['link']; ?>" title="<?php echo $banner10['title']; ?>">
                                                <img src="/images/banners/<?php echo $banner10['fileurl']; ?>" class="img-carousel" alt="<?php echo $banner10['title']; ?>" />
                                            </a>

                                        </li>

                                    <?php } ?>
                                </ul>
                                <div id="shadow" class="shadow-slider"></div>
                                <?php if ($banner2 || $banner3 || $banner4 || $banner5 || $banner6 || $banner7 || $banner8 || $banner9 || $banner10) { ?>
                                    <div id="nav-arrows" class="nav-arrows">
                                        <a href="#">Next</a>
                                        <a href="#">Previous</a>
                                    </div>
                                <?php } ?>
                                <div id="nav-dots" class="nav-dots">
                                    <span class="nav-dot-current"></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>

                            <!--  END слайдер                   -->

                        </section>
                    </div>
                </div>
            <?php } ?>
            <div class="container mt-2">
                <?php $this->printModules('mobile-menu') ?>
            </div>
            <main class="main">
                <div class="container-fluid">
                    <div class="row">
                        <?php $this->printModules('mainbottom'); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="side-bottom">
                    <div class="container">
                        <?php $this->printModules('maintop'); ?>
                    </div>
                </div>
            </main>
        <?php } ?>
        <footer class="site-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 foo-right col-sm-push-4">
                        <div class="reviews">
                            <?php $this->printModules('reviews'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <img class="logo-footer" src="/templates/<?php echo TEMPLATE; ?>/images/LOGO_white.svg" />
                    </div>
                    <?php $this->printModules('footer'); ?>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="socials">
                            <div class="h4">Мы в соцсетях</div>
                            <a href="https://instagram.com/sanmarket.kz?igshid=1ku2ccq4wb7fi" rel="nofollow"
                               target="_blank"><img style="width: 30px;"
                                                    src="/templates/<?php echo TEMPLATE; ?>/images/new_icon/instagram.svg"/></a>
                            <a href="https://ok.ru/group/56887491428360" rel="nofollow" target="_blank"><img
                                        style="width: 30px;"
                                        src="/templates/<?php echo TEMPLATE; ?>/images/new_icon/ok.svg"/></a>
                            <a href="https://www.facebook.com/SanMarketkz-110702453979789/?ref=bookmarks" rel="nofollow"
                               target="_blank"><img style="width: 30px;"
                                                    src="/templates/<?php echo TEMPLATE; ?>/images/new_icon/facebook.svg"/></a>
                            <a href="https://vk.com/public195362114" rel="nofollow" target="_blank">
                                <img style="width: 30px;" src="/templates/<?php echo TEMPLATE; ?>/images/new_icon/vk.svg"/></a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="socials">
                            <div class="h4">Поделитесь нашим сайтом с друзьями!</div>
                            <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                            <script src="//yastatic.net/share2/share.js"></script>
                            <div class="ya-share2 yashasha"
                                 data-services="instagram,facebook,odnoklassniki,whatsapp,telegram"
                                 data-counter=""></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <p class="">www.sanmarket.kz &copy; 2016-<?php echo date('Y'); ?></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div id="back-top" class="">
        <a href="#top">
            <img src="/templates/<?php echo TEMPLATE; ?>/img/totop.png"/>
        </a>
    </div>

    <script src="/templates/<?php echo TEMPLATE; ?>/js/truncatelines.js"></script>
    <script src="/templates/<?php echo TEMPLATE; ?>/js/jquery.nicescroll.js"></script>
    <script src="/templates/<?php echo TEMPLATE; ?>/js/jquery.barrating.min.js"></script>

    <script>
        $(document).ready(function () {
            var nice = $(".nice").niceScroll();
        });
    </script>
    <?php if ($inConf::getConfig('marquee')) { ?>
        <script>
            $(window).scroll(function () {
                if ($(window).scrollTop() > 64) {
                    $('.nav-bar').addClass('fix-top');
                    $('.main-body').addClass('mrg-top');
                } else {
                    $('.nav-bar').removeClass('fix-top');
                    $('.main-body').removeClass('mrg-top');
                }
            });
        </script>
    <?php } else { ?>
        <script>
            $(window).scroll(function () {
                if ($(window).scrollTop() > 32) {
                    $('.nav-bar').addClass('fix-top');
                    $('.main-body').addClass('mrg-top');
                } else {
                    $('.nav-bar').removeClass('fix-top');
                    $('.main-body').removeClass('mrg-top');
                }
            });
        </script>
    <?php } ?>
    <script>
        jQuery('ul.nav > li').hover(function () {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(10).fadeIn();
        }, function () {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(10).fadeOut();
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                $("#back-top").hide();
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 300) {
                        $("#back-top").fadeIn();
                    } else {
                        $("#back-top").fadeOut();
                    }
                });
                $("#back-top a").click(function () {
                    $("body,html").animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
            });
        });
    </script>

    <noindex>
        
        <!-- start Modal authorization-->

        <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true" style="margin-top: 20%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal-body" class="modal-body">
                        <div class="body-page">
                            <div class="row flex-column justify-content-start align-items-center">
                                <h1 class="con_heading text-center">Вход на сайт</h1>
                                <div class="">
                                    <p id="error-auth" class="red-text"></p>
                                    <div class="clearfix">

                                        <form id="login-form" method="post" role="form" class="form-horizontal">
                                            <input type="hidden" name="csrf_token" value=""/>
                                            <div class="form-group has-feedback">
                                                <div class="col-md-12 px-0 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" title="Логин или E-mail">
                                                            <i class="glyphicon glyphicon-user"></i>
                                                        </span>
                                                        <input type="text" name="login" id="login_field" tabindex="1" class="form-control" placeholder="Логин или E-mail" required/>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback"></span>
                                                    <div class="error-login red-text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <div class="col-md-12 px-0 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" title="Пароль">
                                                            <i class="glyphicon glyphicon-th"></i>
                                                        </span>
                                                        <input type="password" name="pass" id="pass_field" tabindex="2" class="form-control" placeholder="Пароль" required/>
                                                    </div>
                                                    <span class="glyphicon form-control-feedback"></span>
                                                    <div class="error-password red-text"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12 px-0">
                                                    <!--                                                    <input id="submit-btn-login" type="submit" name="login_btn" class="btn btn-main btn-block" value="Войти" tabindex="4"/>-->
                                                    <button id="submit-btn-login" type="button" class="btn btn-main d-block" style="width: 100%;">Войти</button>
                                                    <label for="remember" style="color: black;">
                                                        <input type="checkbox" name="remember" value="1" checked="checked" id="remember" tabindex="3"/> Запомнить меня
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="clearfix text-center small">
                                        <a href="/passremind.html" class="">Забыли пароль</a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Modal authorization -->

        <!-- Modal Registration  -->

        <div id="modalAuth" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div id="modal-body-authorization" class="modal-body">

                    </div>
                </div>
            </div>
        </div>

        <!-- /Modal Registration   -->


        <?php $this->printModules('coin'); ?>

        <!-- Begin Verbox {literal} -->
        <script type='text/javascript'>
            (function (d, w, m) {
                window.supportAPIMethod = m;
                var s = d.createElement('script');
                s.type = 'text/javascript';
                s.id = 'supportScript';
                s.charset = 'utf-8';
                s.async = true;
                var id = '74a9a7ea51b25fad462ecf6f83545718';
                s.src = '//admin.verbox.ru/support/support.js?h=' + id;
                var sc = d.getElementsByTagName('script')[0];
                w[m] = w[m] || function () {
                    (w[m].q = w[m].q || []).push(arguments);
                };
                if (sc) sc.parentNode.insertBefore(s, sc);
                else d.documentElement.firstChild.appendChild(s);
            })(document, window, 'Verbox');
        </script>
        <!-- {/literal} End Verbox -->
    </noindex>
    <script>
        $(".ex-click").click(function () {
            $(this).siblings(".ex-slide").slideToggle("slow");
        });
    </script>

    <!-- Yandex.Metrika counter Вебвизор-->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(51363598, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true,
            ecommerce:"dataLayer"
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/51363598" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "Интернет-магазин sanmarket.kz",
            "url": "https://sanmarket.kz/",
            "logo": "https://sanmarket.kz/templates/basic_free/images/LOGO_fuLL_blue.svg",
            "sameAs": [
                "https://www.instagram.com/sanmarket.kz/",
                "https://ok.ru/group/56887491428360",
                "https://www.facebook.com/sanmarket.kz/"
            ]
        }
    </script>

</div>

<div class="d-none tapbar pt-2 pb-2 d-lg-none"> <!--fixed-bottom-->
    <div class="d-flex justify-content-around">
        <div class="">
            <a href="/"><img src="/templates/basic_free/images/tapbar/home.png" alt="" class="" width="30"></a>
        </div>
        <div class="">
            <a href="#" data-toggle="modal" data-target="#search_modal"><img src="/templates/basic_free/images/tapbar/search.png" alt="" class="" width="30"></a>
        </div>
        <div class="">
            <a href="/shop"><img src="/templates/basic_free/images/tapbar/catalog.png" alt="" class="" width="30"></a>
        </div>
        <div class="">
            <span class="hlink" data-href="<?php echo base64_encode('/shop/cart.html'); ?>"><img src="/templates/basic_free/images/tapbar/cart.svg" alt="" class="" width="30"></span>
        </div>
        <div class="">
            <span class="">
                <img src="/templates/basic_free/images/tapbar/user.png" alt="" class="" width="30">
            </span>
        </div>
    </div>
</div>

<div class=" cookies-notification d-none">
    <p class="cookies-notification__text">
        Cайт sanmarket.kz использует файлы cookie и другие технологии для вашего удобства пользования сайтом, анализа
        использования наших товаров и услуг и повышения качества рекомендаций.
        <a href="<?php $_SERVER['SERVER_NAME'] ?>/politika-konfidencialnosti.html">Подробнее</a>
    </p>
    <button id="btn-cookies" class="btn btn-success">Хорошо</button>
</div>


<div class="overlay entered"></div>


<div id="darkening"></div>

<div id="order-call" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Заказать звонок</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="callback-form">
                <div class="modal-body">
                    <div class="my-4">
                        <span class="text-center text-muted">Введите номер телефона и мы перезвоним вам через 30 секунд!</span>
                    </div>

                    <input type="text" class="form-control callback-input" name="phonecallback"  placeholder="Ваш номер*" required/>

                    <div class="my-4">
                        <small class="text-muted">введите номер в международном формате (7 *** *** ** **)</small>
                    </div>
                    <button id="btn-callback" class="btn text-white btn-callback" type="submit">Позвонить мне</button>
                </div>

                <div class="modal-footer">


                </div>
            </form>
        </div>
    </div>
</div>

<div id="app"></div>
<script>

    $('#btn-callback').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/',
            type: 'post',
            success: function (data) {
                $('#order-call .close').trigger('click');
            }
        });

    });

    $('#order-call .close').click(function () {
        $('input[name=phonecallback]').val('');
    })

    $(function() {
        var Page = (function() {
            var $navArrows = $( '#nav-arrows' ).hide(),
                $navDots = $( '#nav-dots' ).hide(),
                $nav = $navDots.children( 'span' ),
                $shadow = $( '#shadow' ).hide(),
                slicebox = $( '#sb-slider' ).slicebox( {
                    onReady : function() {

                        $navArrows.show();
                        $navDots.show();
                        $shadow.show();

                    },

                    onBeforeChange : function( pos ) {

                        $nav.removeClass( 'nav-dot-current' );
                        $nav.eq( pos ).addClass( 'nav-dot-current' );

                    },
                    orientation : 'h',
                    cuboidsCount : 1,
                    autoplay: true,
                    size: {
                        width: 890,
                        height: 367
                    }
                } ),

                init = function() {

                    initEvents();

                },
                initEvents = function() {

                    // add navigation events
                    $navArrows.children( ':first' ).on( 'click', function() {

                        slicebox.next();
                        return false;

                    } );

                    $navArrows.children( ':last' ).on( 'click', function() {

                        slicebox.previous();
                        return false;

                    } );

                    $nav.each( function( i ) {

                        $( this ).on( 'click', function( event ) {

                            var $dot = $( this );

                            if( !slicebox.isActive() ) {

                                $nav.removeClass( 'nav-dot-current' );
                                $dot.addClass( 'nav-dot-current' );

                            }

                            slicebox.jump( i + 1 );
                            return false;

                        } );

                    } );

                };

            return { init : init };

        })();

        Page.init();

    });

</script>

</body>
</html>

