<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class music_map extends comMaps{
    public $title = "Музыка";
    public $link = "music";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $today = date("Y-m-d H:i:s");
        $this->total = $this->inDB->rows_count("cms_music", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_music_category", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_music_singer", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_music_album", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_music_genre", "1=1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        $inCore	= cmsCore::getInstance();
        $cfg = $inCore->loadComponentConfig("music");
        if (!$this->generateMap and !$html){ return FALSE; }
        if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_album_url'], "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Страница Альбомов", $this->host."/".$cfg['component_url']."/".$cfg['component_album_url']."s"); }
        $albums = $this->inDB->query("SELECT album_name, seolink FROM cms_music_album WHERE published = 1");
        while ($album = $this->inDB->fetch_assoc($albums)){
            if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_album_url']."/".$album['seolink'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($album['album_name'], $this->host."/".$cfg['component_url']."/".$cfg['component_album_url']."/".$album['seolink'], 20); }
        }
        unset($albums); unset($album);
        if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_genre_url']."s", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Страница Жанров", $this->host."/".$cfg['component_url']."/".$cfg['component_genre_url']."s"); }
        $genres = $this->inDB->query("SELECT id, genre_name FROM cms_music_genre");
        while ($genre = $this->inDB->fetch_assoc($genres)){
            if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_genre_url']."s/".$cfg['component_genre_url']."-".$genre['id'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($genre['genre_name'], $this->host."/".$cfg['component_url']."/".$cfg['component_genre_url']."s/".$cfg['component_genre_url']."-".$genre['id'], 20); }
        }
        unset($genres); unset($genre);
        if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_genre_url']."s", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Страница Исполнителей", $this->host."/".$cfg['component_url']."/".$cfg['component_singer_url']."s"); }
        $singers = $this->inDB->query("SELECT id, singer_name, seolink FROM cms_music_singer WHERE published = 1");
        while ($singer = $this->inDB->fetch_assoc($singers)){
            if ($this->generateMap){ $this->set_map_url(array($this->host."/".$cfg['component_url']."/".$cfg['component_singer_url']."/".$singer['seolink'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($singer['singer_name'], $this->host."/".$cfg['component_url']."/".$cfg['component_singer_url']."/".$singer['seolink'], 20); }
        }
        unset($singers); unset($singer);
        $cats = $this->getCategoryTree("cms_music_category", $this->host . "/" . $cfg['component_url']);
        foreach ($cats as $cat){
            if ($cat['id']==1){
                if ($this->generateMap){ $this->set_map_url(array($this->host . "/" . $cfg['component_url'], "daily", "0.9")); }
                if ($html){ $this->set_html_cat("Главная страница музыки", $this->host . "/" . $cfg['component_url']); }
                $sql = "SELECT id, name, seolink, pubdate FROM cms_music WHERE (cat_id = '".$cat['id']."' OR cat_id = '' OR cat_id = 0) AND published = 1";
            }else{
                if ($this->generateMap){ $this->set_map_url(array($cat['seolink'], "daily", "0.9")); }
                if ($html){ $this->set_html_cat($cat['title'], $cat['seolink'], ($cat['NSLevel']-1)*20); }
                $sql = "SELECT id, name, seolink FROM cms_music WHERE cat_id = '".$cat['id']."' AND published = 1";
            }
            $result = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while($item = $this->inDB->fetch_assoc($result)){
                if (($cfg['seo_url'] == 1) and ($item['cat_id'] > 1)){
                    $mseolink = $cat['seolink'] . "/" . $item['seolink'];
                }else{
                    $mseolink = $this->host . "/" . $cfg['component_url'] . "/" . $item['seolink'];
                }
                $item['pubdate'] = strtotime($item['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $mseolink,
                        $item['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $item['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $item['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item($item['name'], $mseolink); }
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