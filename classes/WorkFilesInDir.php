<?php


class WorkFilesInDir
{
    public $pathDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

    public function __construct()
    {
    }

    public function fetchExcelFilesInDir()
    {
        $handle = opendir($this->pathDir);
        $listFiles = [];

        while (false !== ($file = readdir($handle))) {
            $tmpCurrentFile = pathinfo($file);
            if (array_key_exists('extension', $tmpCurrentFile) && ($tmpCurrentFile['extension'] == 'xls' || $tmpCurrentFile['extension'] == 'xlsx')) {
                $listFiles[] = $tmpCurrentFile;
            }
        }

        closedir($handle);

        return $listFiles;
    }


}