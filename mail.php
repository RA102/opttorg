<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once __DIR__ . '/includes/LoadPriceOnEmail.php';

$mailFileTypes = [
    'XML'
];

$connect = new LoadPriceOnEmail();
$imap = $connect->openImap();
$mailsId = $connect->fetchLetters($imap, 'ALL');


foreach($mailsId as $key => $num) {
    $structure = $connect->fetchStructureLetters($imap, $num);
}
//var_dump('<pre>', $structure->parts, '</pre>');

if(isset($structure->parts)){

    for($i = 0, $j = 0; $i < count($structure->parts); $i++, $j++){

        $f = 2;
        if(in_array($structure->parts[$i]->subtype, $mailFileTypes)){

            $mails_data[$i]["attachs"][$j]["type"] = $structure->parts[$i]->subtype;
            $mails_data[$i]["attachs"][$j]["size"] = $structure->parts[$i]->bytes;
            $mails_data[$i]["attachs"][$j]["name"] = $connect->getImapTitle($structure->parts[$i]->parameters[0]->value);
            $mails_data[$i]["attachs"][$j]["file"] = $connect->structureEncoding($structure->parts[$i]->encoding, imap_fetchbody($imap, 6, $f));

//            var_dump('<pre>', $mails_data, '</pre>');

            file_put_contents("tmp/".iconv("utf-8", "cp1251", $mails_data[$i]["attachs"][$j]["name"]), $mails_data[$i]["attachs"][$j]["file"]);
        }
    }
}



$connect->closeConnection($imap);





