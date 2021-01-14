<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }


class video_map extends comMaps{
    public $title = "Видео";
    public $link = "video";
    

    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $this->total = $this->inDB->rows_count("cms_video_movie", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_video_category", "published = 1");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        $inCore = cmsCore::getInstance();
        $cfg = $inCore->loadComponentConfig("video");
        if (!$this->generateMap and !$html){ return FALSE; }
        $cats = $this->getCategoryTree("cms_video_category", $this->host . "/video");
        foreach ($cats as $cat){
            if ($cat['id']==1){
                $cat['title'] = "Главная страница видео каталога";
                $cat['seolink'] = $this->host . "/video";
            }else{
                $cat['seolink'] = $cfg['is_seo_url']==1 ? $cat['seolink'] : $this->host . "/video/" . $cat['id'];
            }
            if ($this->generateMap){ $this->set_map_url(array($cat['seolink'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($cat['title'], $cat['seolink'], ($cat['NSLevel']-1)*20); }
            $sql = "SELECT m.id, m.pubdate, m.img, m.duration, m.title, m.provider, m.description, m.hits, m.user_id, m.seolink, u.login as login, u.nickname as nickname FROM cms_video_movie m LEFT JOIN cms_users u ON u.id = m.user_id WHERE cat_id = '".$cat['id']."' AND published = 1";
            $result = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while($item = $this->inDB->fetch_assoc($result)){
                if ($cfg['is_seo_url']==1){
                    if ($cfg['short_seo_url']==1){
                        $item['seolink'] = $this->host . "/video/" . $item['seolink'] . ".html";
                    }else{
                        $item['seolink'] = $cat['seolink'] . "/" . $item['seolink'] . ".html";
                    }
                }else{
                    $item['seolink'] = $this->host . "/video/movie" . $item['id'] . ".html";
                }
                $item['pubdate'] = strtotime($item['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $item['seolink'],
                        $item['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $item['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $item['pubdate']),
                        "id" => $item['id'],
                        "img" => $item['img'],
                        "title" => $item['title'],
                        "description" => $item['description'],
                        "duration" => $item['duration'],
                        "hits" => $item['hits'],
                        "seolink" => $item['seolink'],
                        "cat_title" => $cat['title'],
                        "cat_seolink" => $cat['seolink'],
                        "login" => $item['login'],
                        "nickname" => $item['nicname']
                    ));
                }
                if ($html){ $this->set_html_item($item['title'], $item['seolink']); }
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