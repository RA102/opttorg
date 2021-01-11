<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class faq_map extends comMaps{
    public $title = "Вопросы и Ответы";
    public $link = "faq";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $today = date("Y-m-d H:i:s");
        $this->total = $this->inDB->rows_count("cms_faq_quests", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_faq_cats", "published = 1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        if (!$this->generateMap and !$html){ return FALSE; }
        $cats = $this->inDB->query("SELECT id, title FROM cms_faq_cats WHERE published = 1");
        if ($this->generateMap){ $this->set_map_url(array($this->host . "/faq", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Главная страница Вопросов и Ответов", $this->host . "/faq"); }
        while ($cat = $this->inDB->fetch_assoc($cats)){
            if ($this->generateMap){ $this->set_map_url(array($this->host . "/faq/" . $cat['id'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($cat['title'], $this->host . "/faq/" . $cat['id'] . "/faq"); }
            $sql = "SELECT id, pubdate, quest FROM cms_faq_quests WHERE category_id = '".$item['id']."' AND published = 1";
            $quests = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while ($quest = $this->inDB->fetch_assoc($quests)){
                $quest['pubdate'] = strtotime($quest['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $this->host . "/faq/quest" . $quest['id'] . ".html",
                        $quest['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $quest['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $quest['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item(substr($quest['quest'], 0, 50), $this->host . "/faq/quest" . $quest['id'] . ".html"); }
            }
            if ($html){ $this->set_html_item_end(); }
        }
    }
    
    public function user_map_start(){ return FALSE; }
    public function user_re_map_start(){ return FALSE; }
    public function user_set_map_url($item){ return FALSE; }
    public function user_map_end(){ return FALSE; }
    public function user_genMapsList(){ return FALSE; }
}
?>