<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Almaty');

const VALID_CMS = 1;

define('PATH', dirname(__DIR__, 1));

include_once __DIR__ .'/../core/cms.php';
include_once __DIR__ . '/phpexel/PHPExcel.php';
include_once __DIR__ . '/../core/classes/db.class.php';
include_once __DIR__ . '/../core/classes/config.class.php';
include_once PATH . '/classes/LoadFilesInFolder.php';

$instanceDb = cmsDatabase::getInstance();


$pathCatalog = PATH . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;


$readFiles = new LoadFilesInFolder($pathCatalog2);

$files = $readFiles->getDirectioryUpdatedToday2($pathCatalog);

var_dump('<pre>', $files, '</pre>');

