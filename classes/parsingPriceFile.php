<?php


class parsingPriceFile
{
    public PHPExcel $phpExel;
    protected $pathFile;

    function __construct($pathFile)
    {
        $this->pathFile = $pathFile;
    }

    /**
     * @throws PHPExcel_Reader_Exception
     */
    public function workFile()
    {
        include_once __DIR__ . DIRECTORY_SEPARATOR . 'phpexel/PHPExcel.php';
        return PHPExcel_IOFactory::load($this->pathFile);

    }











}