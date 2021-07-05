<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once __DIR__ . '/../classes/LoadPriceByEmail.php';

$path = __DIR__ . '/../tmp/';

$mailFileTypes = [
    'VND.MS-EXCEL',
    'VND.OPENXMLFORMATS-OFFICEDOCUMENT.SPREADSHEETML.SHEET'
];

$connect = new LoadPriceByEmail();
$imap = $connect->openImap();
$mailsId = $connect->fetchLetters($imap, 'UNSEEN');

$structure = [];

if ($mailsId) {


    foreach ($mailsId as $key => $num) {
//    $structure[$num] = $connect->fetchStructureLetters($imap, $num);
        $letter = $connect->getLetterToId($imap, $num);

        $structure[$num] = $connect->fetchStructureLetters($imap, $num);

        $catalogName[$num] = $letter['header']->from[0]->mailbox . '@' .  $letter['header']->from[0]->host;

        if (!is_dir($path . $catalogName[$num])) {
            mkdir($path . $catalogName[$num]);
        }

        $fromMail[$num] = $letter['header']->from[0]->mailbox . '@' .  $letter['header']->from[0]->host;
    }

    foreach ($structure as $numberMail => $mail) {

        if (isset($mail->parts)) {
            for ($i = 1, $j = 0, $f = 2; $i < count($mail->parts); $i++, $j++, $f++) {

                if (in_array($mail->parts[$i]->subtype, $mailFileTypes)) {

                    $mails_data[$i]["attaches"][$j]["type"] = $mail->parts[$i]->subtype;
                    $mails_data[$i]["attaches"][$j]["size"] = $mail->parts[$i]->bytes;
                    $mails_data[$i]["attaches"][$j]["name"] = $connect->getImapTitle($mail->parts[$i]->parameters[0]->value);
                    $mails_data[$i]["attaches"][$j]["file"] = $connect->structureEncoding($mail->parts[$i]->encoding, imap_fetchbody($imap, $numberMail, $f));

                    file_put_contents($path . DIRECTORY_SEPARATOR . $catalogName[$numberMail] . DIRECTORY_SEPARATOR . $mails_data[$i]["attaches"][$j]["name"], $mails_data[$i]["attaches"][$j]["file"]);
                }

            }
        }
    }


}  else {
    echo 'Новых писем нет';
}

$connect->closeConnection($imap);


$priceFiles = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

$handle = opendir($priceFiles);
$listFiles = [];

while (false !== ($file = readdir($handle))) {
    $tmpCurrentFile = pathinfo($file);
    if (array_key_exists('extension', $tmpCurrentFile) && ($tmpCurrentFile['extension'] == 'xls' || $tmpCurrentFile['extension'] == 'xlsx')) {
        $listFiles[] = $tmpCurrentFile;
    }
}
closedir($handle);

foreach ($listFiles as $index => $currenFile) {
    echo $currenFile . "<br />";

}

