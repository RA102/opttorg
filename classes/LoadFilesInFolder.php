<?php

set_time_limit(600);

class LoadFilesInFolder
{
    protected $pathRoot;
    protected $pathToFolder;
    protected static $directoryIterator;

    public function __construct($pathToFolderFromRoot)
    {
        $this->pathRoot = dirname(__FILE__, 2);
        $this->pathToFolder = $this->pathRoot . DIRECTORY_SEPARATOR . $pathToFolderFromRoot;
    }

    public static function directoryIterator()
    {

    }

    public function fetchExcelFilesInDir()
    {
        $handle = opendir($this->pathFolder);
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

    public function getEntityInDirector($entity = '')
    {
        $folder = [];
        $pathFromDirectory = $this->pathToFolder . $entity;
        $directoryIterator = new DirectoryIterator($pathFromDirectory);

        foreach ($directoryIterator as $item) {
            if (!$item->isDot()) {
                $folder[] = $item->getFilename();
            }
        }
        return $folder;
    }

    public function getEntityUpdatingToday($entity)
    {
        $entity = [];

        $pathFromDirectory = $this->pathToFolder . $entity;
        $directoryIterator = new DirectoryIterator($pathFromDirectory);

        foreach ($directoryIterator as $item) {
            if (!$item->isDot()) {
                if ($this->isUpdateToday($item)) {
                    $pathDirectory = $item->getPathname();
                    $iterator = new DirectoryIterator($pathDirectory);
                    foreach ($iterator as $index => $files) {
                        if ($this->isUpdateToday($entity)) {
                            $entity[$item->getFilename()] = $files->getFilename();
                        } else {
                            continue;
                        }
                    }
                } else {
                   continue;
                }
            }
        }
        return $files;


    }

    public function isUpdateToday($item): bool
    {
        if (date('Y-m-d', $item->getMTime()) == date('Y-m-d') || date('Y-m-d', $item->getCTime()) == date('Y-m-d')) {
            return true;
        }
        return false;
    }

    public function getFilesUpdateToday($entity = '')
    {
        $pathFromDirectory = $this->pathToFolder . $entity;
        $iteratorDirectory = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->pathToFolder));

    }

//    public function getDirectioryUpdatedToday($path = '')
//    {
//        $folder = [];
//        $directoryIterator = new DirectoryIterator($this->pathToFolder);
//
//        foreach ($directoryIterator as $item) {
//            if (!$item->isDot()) {
//                if ($this->isUpdateToday($item)) {
//                    if ($item->isDir()) {
//
//                        $currentDirectory = $item->getPathname();
//
//                        $pathDirectory = $item->getPathname();
//                        $iterator = new DirectoryIterator($pathDirectory);
//                        foreach ($iterator as $index => $files) {
//                            if ($this->isUpdateToday($files)) {
//                                $folder[$item->getFilename()] = $files;
//                            } else {
//                                continue;
//                            }
//                        }
//                    }
//
//                } else {
//
//                    continue;
//
//                }
//            }
//        }
//        return $folder;
//    }


    public function getDirectioryUpdatedToday($path = '')
    {
        $listFiles = [];
        $directoryIterator = new DirectoryIterator($path);

        foreach ($directoryIterator as $item) {
            if (!$item->isDot()) {
                if ($this->isUpdateToday($item)) {
                    if ($item->isDir()) {

                        $currentDirectory = $item->getPathname();

                        $iterator = new DirectoryIterator($currentDirectory);

                        foreach ($iterator as $index => $file) {
                            if (!$file->isDot()) {
                                if ($this->isUpdateToday($file)) {
                                    $listFiles[$item->getFilename()]['files'][] = $file->getFilename();
                                }
                            }
                        }


                    } else {

                        continue;

                    }


                } else {

                    continue;

                }
            }
        }
        return $listFiles;
    }
}