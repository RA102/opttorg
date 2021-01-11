<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class users_map extends comMaps{
    public $title = "Пользователи";
    public $link = "users";
    
    public function __construct() {
        $this->inDB = cmsDatabase::getInstance();
        $this->total = $this->inDB->rows_count("cms_users", "is_locked = 0 AND is_deleted = 0");
        $this->total = $this->total + $this->inDB->rows_count("cms_user_photos", "allow_who = 'all'");
    }

    public function FillMapsArray($html=FALSE){
        $this->map_start();
        if (!$this->generateMap and !$html){ return FALSE; }
        if ($this->generateMap){ $this->set_map_url(array($this->host . "/users", "daily", "0.9")); }
        if ($html){ $this->set_html_cat("Список Пользователей", $this->host . "/users"); }
	$users = $this->inDB->query("SELECT id, login, nickname FROM cms_users WHERE is_locked = 0 AND is_deleted = 0");
        while ($user = $this->inDB->fetch_assoc($users)){
            if ($this->generateMap){ $this->set_map_url(array($this->host . "/users/" . $user['login'], "daily", "0.9")); }
            if ($html){ $this->set_html_cat($user['nickname'], $this->host . "/users/" . $user['login']); }
            $sql = "SELECT id, pubdate, title FROM cms_user_photos WHERE user_id = '".$user['id']."' AND allow_who = 'all'";
            $result = $this->inDB->query($sql);
            if ($html){ $this->set_html_item_start(); }
            while ($item = $this->inDB->fetch_assoc($result)){
                $item['pubdate'] = strtotime($item['pubdate']);
                if ($this->generateMap){
                    $this->set_map_url(array(
                        $this->host . "/users/" . $user['id'] . "/photo" . $item['id'] . ".html",
                        $item['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly",
                        $item['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8",
                        date("Y-m-d", $item['pubdate'])
                    ));
                }
                if ($html){ $this->set_html_item($item['title'], $this->host . "/users/" . $user['id'] . "/photo" . $item['id'] . ".html"); }
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