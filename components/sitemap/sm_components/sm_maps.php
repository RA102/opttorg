<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class maps_map extends comMaps{
    public $title = "Карта Объектов";
    public $link = "maps";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $today = date("Y-m-d H:i:s");
        $this->total = $this->inDB->rows_count("cms_map_items", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_map_cats", "published = 1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        if (!$this->generateMap and !$html){ return FALSE; }
        $cats = $this->getCategoryTree("cms_map_cats", $this->host . "/maps");
        foreach ($cats as $cat){
            if ($cat['id']==1){
                $cat['title'] = "Главная страница Карты объектов";
                $cat['seolink']	= $this->host . "/maps";
            }
            if ($this->generateMap){ $this->set_map_url(array($cat['seolink'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($cat['title'], $cat['seolink'], ($cat['NSLevel']-1)*20); }
            $sql = "SELECT pubdate, title, seolink FROM cms_map_items WHERE category_id = '".$cat['id']."' AND published = 1";
            $result = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while($item = $this->inDB->fetch_assoc($result)){
                $item['pubdate'] = strtotime($item['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $this->host . "/maps/" . $item['seolink'] . ".html",
                        $item['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $item['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $item['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item($item['title'], $this->host . "/maps/" . $item['seolink'] . ".html"); }
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