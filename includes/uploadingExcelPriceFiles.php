<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", 1);

define('VALID_CMS', 1);

define('PATH', dirname(__DIR__, 1));

include_once PATH . '/core/classes/config.class.php';
//include_once PATH . '/includes/config.inc.php';
include_once PATH . '/core/classes/db.class.php';
include_once PATH . '/classes/LoadPriceByEmail.php';
include_once PATH . '/classes/LoadFilesInFolder.php';
include_once PATH . '/classes/ParsingPriceFile.php';

$path = PATH . '/tmp/';

$mailFileTypes = [
    'VND.MS-EXCEL',
    'VND.OPENXMLFORMATS-OFFICEDOCUMENT.SPREADSHEETML.SHEET'
];

#region Загрузка файлов по email

//$connect = new LoadPriceByEmail();
//$imap = $connect->openImap();
//$mailsId = $connect->fetchLetters($imap, 'UNSEEN');
//
//$structure = [];
//
//
//
//
//if ($mailsId) {
//
//    foreach ($mailsId as $key => $num) {
//        $structure[$num] = $connect->fetchStructureLetters($imap, $num);
//        $letter = $connect->getLetterToId($imap, $num);
//
//        $structure[$num] = $connect->fetchStructureLetters($imap, $num);
//
//        $catalogName[$num] = $letter['header']->from[0]->mailbox . '@' .  $letter['header']->from[0]->host;
//
//        if (!is_dir($path . $catalogName[$num])) {
//            mkdir($path . $catalogName[$num]);
//        }
//
//        $fromMail[$num] = $letter['header']->from[0]->mailbox . '@' .  $letter['header']->from[0]->host;
//    }
//
//    foreach ($structure as $numberMail => $mail) {
//
//        if (isset($mail->parts)) {
//            for ($i = 1, $j = 0, $f = 2; $i < count($mail->parts); $i++, $j++, $f++) {
//
//                if (in_array($mail->parts[$i]->subtype, $mailFileTypes)) {
//
//                    $mails_data[$i]["attaches"][$j]["type"] = $mail->parts[$i]->subtype;
//                    $mails_data[$i]["attaches"][$j]["size"] = $mail->parts[$i]->bytes;
//                    $mails_data[$i]["attaches"][$j]["name"] = $connect->getImapTitle($mail->parts[$i]->parameters[0]->value);
//                    $mails_data[$i]["attaches"][$j]["file"] = $connect->structureEncoding($mail->parts[$i]->encoding, imap_fetchbody($imap, $numberMail, $f));
//                    file_put_contents($path . DIRECTORY_SEPARATOR . $catalogName[$numberMail] . DIRECTORY_SEPARATOR . $mails_data[$i]["attaches"][$j]["name"], $mails_data[$i]["attaches"][$j]["file"]);
//                }
//
//            }
//        }
//    }
//
//
//}  else {
//    $connect->closeConnection($imap);
//    exit('Новых писем нет');
//}
//
//$connect->closeConnection($imap);

#endregion

/*
 *  блок чтения фалов из каталога
 */

$pathCatalog = PATH . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;


$readFiles = new LoadFilesInFolder($pathCatalog);

$files = $readFiles->getDirectioryUpdatedToday($pathCatalog);

/*
 * блок парсинга excel файлов
 */

$listFolders = array_keys($files);

$parsingExcelFile = new ParsingPriceFile();
foreach ($listFolders as $index => $folderName) {
    foreach ($files[$folderName]['params'] as $index => $arrayParamBrand) {

    }

    $parsingExcelFile->folderName = $folderName;
    foreach ($files[$folderName]['files'] as $index => $fileNameWithExtension) {
        $fileName = explode('.', $fileNameWithExtension);
        if(!$parsingExcelFile->getParamsBrand($folderName, $fileName)) {
            $parsingExcelFile->parsingFile();
        } else {
            break;
        }
    }

}
