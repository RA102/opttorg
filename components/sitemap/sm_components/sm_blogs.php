<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class blogs_map extends comMaps{
    public $title = "Блоги";
    public $link = "blogs";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $today = date("Y-m-d H:i:s");
        $this->total = $this->inDB->rows_count("cms_blogs", "allow_who = 'all'");
        $this->total = $this->total + $this->inDB->rows_count("cms_blog_posts", "allow_who = 'all' AND published = 1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        if (!$this->generateMap and !$html){ return FALSE; }
        if ($this->generateMap){ $this->set_map_url(array($this->host . "/blogs", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Главная страница Блогов", $this->host . "/blogs"); }
        $sql = "SELECT id, title, seolink, owner FROM cms_blogs WHERE allow_who = 'all'";
	$blogs = $this->inDB->query($sql);
        while ($bitem = $this->inDB->fetch_assoc($blogs)){
            $bseolink = $bitem['owner'] == "user" ? $this->host . "/blogs/" . $bitem['seolink'] : $this->host . "/clubs/" . $bitem['id'] . "_blog";
            if ($this->generateMap){ $this->set_map_url(array($bseolink, "daily", "0.9")); }
            if ($html){ $this->set_html_cat($bitem['title'], $bseolink, 20); }
            $sql = "SELECT pubdate, title, seolink FROM cms_blog_posts WHERE blog_id = '".$bitem['id']."' AND published = 1 AND allow_who = 'all'";
            $posts = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while ($pitem = $this->inDB->fetch_assoc($posts)){
                $pitem['pubdate'] = strtotime($pitem['pubdate']);
                $pseolink = $bitem['owner'] == "user" ? $this->host . "/blogs/" . $bitem['seolink'] . "/" . $pitem['seolink'] . ".html" : $this->host . "/clubs/" . $bitem['id'] . "_" . $pitem['seolink'] . ".html";
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $pseolink,
                        $pitem['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $pitem['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $pitem['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item($pitem['title'], $pseolink); }
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