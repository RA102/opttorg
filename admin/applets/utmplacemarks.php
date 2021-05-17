<?php
if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
}

if (!defined('PATH')) {
    define('PATH', $_SERVER['DOCUMENT_ROOT']);
}

function applet_utmplacemarks()
{
    cmsCore::loadClass('shop');
    $do = cmsCore::request('do', 'str', 'view');
    if ($do == 'view') {
        echo 'ok';
    }

}
