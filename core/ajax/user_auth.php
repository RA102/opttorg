<?php

define('PATH', $_SERVER['DOCUMENT_ROOT']);
include(PATH.'/core/ajax/ajax_core.php');

cmsCore::loadLanguage('components/registration');

$login = cmsCore::request('login', 'str', '');
$password = cmsCore::request('pass', 'str', '');
$remember_pass = cmsCore::inRequest('remember');

if(!login || !password) {
    cmsCore::halt('Отсутствует логин или пароль');
}

$inUser = cmsUser::getInstance();

$user = $inUser->signInUser($login, $password, $remember_pass);

if (true){

    $sql    = "SELECT id, login FROM cms_users WHERE LOWER(login) = '".mb_strtolower($data)."' AND is_deleted = 0 LIMIT 1";
    $result = $inDB->query($sql);

    if($inDB->num_rows($result)==0){
        echo '<span style="color:green">'.$_LANG['YOU_LOGIN_COMPLETE'].'</span>';
    } else {
        echo '<span style="color:red">'.$_LANG['LOGIN'].' "'.$data.'" '.$_LANG['IS_BUSY'].'</span>';
    }

}

cmsCore::halt();
