<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class forum_map extends comMaps{
    public $title = "Форум";
    public $link = "forum";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $today = date("Y-m-d H:i:s");
        $this->total = $this->inDB->rows_count("cms_forum_threads", "1=1");
        $this->total = $this->total + $this->inDB->rows_count("cms_forums", "published = 1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        if (!$this->generateMap and !$html){ return FALSE; }
        if ($this->generateMap){ $this->set_map_url(array($this->host . "/forum", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Главная страница Форума", $this->host . "/forum"); }
        $forums = $this->inDB->query("SELECT id, title,access_list FROM cms_forums WHERE published = 1 AND id != 1000 ORDER BY NSLeft ASC");
        while ($forum = $this->inDB->fetch_assoc($forums)){
            if(!$this->checkContentAccess($forum['access_list'])){ continue; }
            if ($this->generateMap){ $this->set_map_url(array($this->host . "/forum/" . $forum['id'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($forum['title'], $this->host . "/forum/" . $forum['id']); }
            $sql = "SELECT id, pubdate, title FROM cms_forum_threads WHERE forum_id = '".$forum['id']."'";
            $threads = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while ($thread = $this->inDB->fetch_assoc($threads)){
                $thread['pubdate'] = strtotime($thread['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $this->host . "/forum/thread" . $thread['id'] . ".html",
                        $thread['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $thread['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $thread['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item($thread['title'], $this->host . "/forum/thread" . $thread['id'] . ".html"); }
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