<?php
if(isset($_POST) && count($_POST) > 0) {
    $data = "";
    foreach ($_POST as $key => $value) {
        if (is_string($value) && strlen($value) > 2000) $value = substr($value, 0, 2000);
        $data .= $key . "=>" . $value . "\n";
    }
    $fp = fopen("/log/post-log" . $_SERVER['HTTP_HOST'] . "--" . date("Ymd") . ".log", "a");
    fwrite($fp, date("Y-m-d H:i:s")) . " " . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['SCRIPT_FILENAME'] . "\n" . $data . "-----------------------\n";
    fclose($fp);
    $data = "";
    reset($_POST);

}