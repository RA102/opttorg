<?php

if (!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

class cms_model_sphinx
{
    public $pdo;
    public $dns = '';
    public $cfg = [
        'host' => '185.116.194.174',
        'port' => '9207',
        'index' => [
            'idx_cats',
            'idx_items'
        ],
    ];
    private $user = '';
    private $password = '';

    public function __construct()
    {
//        $inCore = cmsCore::getInstance();

//        $defaultCfg = $this->cfg;
//        $cfg = $inCore->loadComponentConfig('sphinx');
//        $this->cfg = array_merge($defaultCfg, $cfg);
    }


    public function setConfig()
    {

        $inCore = cmsCore::getInstance();

        $defaultCfg = $this->cfg;
        $cfg = $inCore->loadComponentConfig('sphinx');
        return $this->cfg = array_merge($defaultCfg, $cfg);
    }



    public function connectSphinx()
    {
        $this->dns = 'mysql:host=' . $this->cfg['host'] . ';port=' . $this->cfg['port'] . ';charset=utf8';
        try {
            $this->pdo = new \PDO($this->dns, '', '');
            return $this->pdo;
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

    }




    public function searchByCategories($word)
    {
        $response = [];
        try {
            $query = "SELECT * FROM idx_cats WHERE MATCH ('" . $word . "')";

            if (false === $result = $this->pdo->query($query)) {
                return $this->pdo->errorInfo();
            } else {
                while ($row = $result->fetch()) {
                    $response[] = $row;
                }
            }

        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
        return $response;
    }

    public function searchByItems($word)
    {
        $response = [];
        try {
            $query = "SELECT * FROM idx_items WHERE MATCH ('" . $word . "')";

            if (false === $result = $this->pdo->query($query)) {
                return $this->pdo->errorInfo();
            } else {
                while ($row = $result->fetch()) {
                    $response[] = $row;
                }
            }

        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
        return $response;
        
    }

}