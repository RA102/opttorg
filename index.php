<?php
Error_Reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//Error_Reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');
header('X-Powered-By: InstantCMS');
define('PATH', dirname(__FILE__));
define('VALID_CMS', 1);

// Проверяем, что система установлена
if (!file_exists(PATH.'/includes/config.inc.php')) {
    header('location:/install/');
    die();
}

$referer = $_SERVER["HTTP_REFERER"];
$file = file_put_contents(PATH . '\RespLog.log', json_encode($referer));


session_start();

require(PATH.'/core/cms.php');
$inCore = cmsCore::getInstance();

// Загружаем нужные классы
cmsCore::loadClass('page');
cmsCore::loadClass('user');
cmsCore::loadClass('actions');

// Проверяем что директории установки и миграции удалены
if(is_dir(PATH.'/install') || is_dir(PATH.'/migrate')) {
    cmsPage::includeTemplateFile('special/installation.php');
    cmsCore::halt();
}

cmsCore::callEvent('GET_INDEX', '');

$inPage = cmsPage::getInstance();
$inConf = cmsConfig::getInstance();
$inUser = cmsUser::getInstance();

// автоматически авторизуем пользователя, если найден куки
$inUser->autoLogin();

// проверяем что пользователь не удален и не забанен и загружаем его данные
if (!$inUser->update() && !$_SERVER['REQUEST_URI']!=='/logout') {
    cmsCore::halt();
}

//Если сайт выключен и пользователь не администратор,
//то показываем шаблон сообщения о том что сайт отключен
if ($inConf->siteoff && !$inUser->is_admin && $_SERVER['REQUEST_URI']!='/login' && $_SERVER['REQUEST_URI']!='/logout' ) {
        cmsPage::includeTemplateFile('special/siteoff.php');
        cmsCore::halt();
}

// Мониторинг пользователей
$inUser->onlineStats();

//Проверяем доступ пользователя
//При положительном результате
//Строим тело страницы (запускаем текущий компонент)
if ($inCore->checkMenuAccess()) {
    $inCore->proceedBody();
}

//Проверяем нужно ли показать входную страницу (splash)
if(cmsPage::isSplash()) {
    //Показываем входную страницу
    cmsPage::showSplash();
} else {
    //показываем шаблон сайта
    $inPage->showTemplate();
}

