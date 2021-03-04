<?php

if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
}

if (!defined('PATH')) {
    define('PATH', $_SERVER['DOCUMENT_ROOT']);
}

cmsCore::request('do', 'str', 'view');

function applet_kaspiorders()
{
    if ($do = 'view') {
        echo 'view';
    }

}
