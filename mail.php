<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once __DIR__ . '/classes/LoadPriceByEmail.php';

$mailFileTypes = [
    'VND.MS-EXCEL',
];

$connect = new LoadPriceByEmail();
$imap = $connect->openImap();
$mailsId = $connect->fetchLetters($imap, 'ALL');

$structure = [];

foreach($mailsId as $key => $num) {
    $structure[$num] = $connect->fetchStructureLetters($imap, $num);
}
//var_dump('<pre>', $structure->parts, '</pre>');
foreach ($structure as $numberMail => $mail) {

    if (isset($mail->parts)) {

        for ($i = 0, $j = 0; $i < count($mail->parts); $i++, $j++) {

            $f = 2;
            if (in_array($mail->parts[$i]->subtype, $mailFileTypes)) {

                $mails_data[$i]["attachs"][$j]["type"] = $mail->parts[$i]->subtype;
                $mails_data[$i]["attachs"][$j]["size"] = $mail->parts[$i]->bytes;
                $mails_data[$i]["attachs"][$j]["name"] = $connect->getImapTitle($mail->parts[$i]->parameters[0]->value);
                $mails_data[$i]["attachs"][$j]["file"] = $connect->structureEncoding($mail->parts[$i]->encoding, imap_fetchbody($imap, $numberMail, $f));

//            var_dump('<pre>', $mails_data, '</pre>');

                file_put_contents("tmp" . DIRECTORY_SEPARATOR . $mails_data[$i]["attachs"][$j]["name"], $mails_data[$i]["attachs"][$j]["file"]);
            }
        }
    }
}


$connect->closeConnection($imap);





