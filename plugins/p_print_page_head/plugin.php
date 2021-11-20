<?php

class p_print_page_head extends cmsPlugin
{
    public function __construct(){

        $this->info['plugin']      = 'p_print_page_head';
        $this->info['title']       = 'Добавление файлов в конец массива head ';
        $this->info['description'] = '';
        $this->info['author']      = 'RA';
        $this->info['version']     = '1.0';

        $this->events[] = 'PRINT_PAGE_HEAD';

        parent::__construct();

    }

    public function execute($event='', $arrayHead=[])
    {
        if ($this->inPage->page_keys == 1) {
            $this->inPage->clearingPathway();
            array_push($arrayHead, '<link href="/templates/basic_free/css/black-friday.css" rel="stylesheet" type="text/css" />');
            return $arrayHead;
        }
        return $arrayHead;
    }

}