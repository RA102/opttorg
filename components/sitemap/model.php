<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

class cms_model_sitemap {
    public $config = array();
    
    public function __construct(){
        $this->config = self::getconfig();
    }
    
    public static function getConfig(){
        $inCore = cmsCore::getinstance();
        $cfg = $inCore->loadComponentConfig("sitemap");
        return $cfg;
    }

    //Возвращает список поддерживаемых и установленных компонентов
    public function getSMComponents() {
        $inCore = cmsCore::getInstance();
        $sm_components = $this->getSMComponentsDirs();
        $components = $this->getComponents();
        if (!$sm_components) { return false; }
        foreach($sm_components as $sm_component){
            $installed = FALSE;
            if ($components[$sm_component]['link']){
                $installed = TRUE;
            }
            if ($installed){
                $components_list[] = $components[$sm_component];
            }
        }
        if (!$components_list){
            return FALSE;
        }
        return $components_list;
    }

    //Возвращает список поддерживаемых компонентов
    public function getSMComponentsDirs(){
        $dir = PATH . '/components/sitemap/sm_components';
        $pdir = opendir($dir);
        $sm_components = array();
        while ($nextfile = readdir($pdir)){
            if (($nextfile != '.') && ($nextfile != '..') && !is_dir($dir.'/'.$nextfile) && ($nextfile!='.svn') && (substr($nextfile, 0, 3)=='sm_')){
                $file_name = str_replace(array("sm_",".php"),array("",""),$nextfile);
                $sm_components[$file_name] = $file_name;
            }
        }
        if (!sizeof($sm_components)){ return false; }
        return $sm_components;
    }

    //Возвращает список установленных компонентов
    public function getComponents() {
        $inDB = cmsDatabase::getinstance();
        $sql = "SELECT title, link, published FROM cms_components WHERE 1 = 1";
        $result = $inDB->query($sql);
        if (!$inDB->num_rows($result)){
            return FALSE;
        }
        $components = array();
        while($component =  $inDB->fetch_assoc($result)){
            $components[$component['link']] = $component;
        }
        return $components;
    }

    //Функция генерации карты вызываемая по CRON 
    public function generateMap(){
        clearstatcache();
        $inCore = cmsCore::getInstance();
        $components = $this->getSMComponents();
        $site_map = $google_site_map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        foreach ($components as $component){
            if (($this->config[$component['link']]['published'] == 1) and $component['published'] == 1){
                // Подключаем класс генератора карт для компонента
                cmsCore::includeFile("components/sitemap/sm_components/sm_" . $component['link'] . ".php");
                // Инициализируем класс
                $map_class = $component['link'] . "_map";
                $maps = new $map_class();
                // Передаем классу конфигурацию, она доступна в классе в переменнов $this->config а через $this->config['config'] доступны дополнительные настройки из xml файла при его наличии
                $maps->config = $this->config[$component['link']];
                $maps->host = $this->config['host'];
                // Вызываем функцию получения данных из базы и составления html и xml карт
                $maps->FillMapsArray(FALSE);
                // Закрываем и записываем последний файл карт если он не был записан ранее
                $maps->map_end();
                // Генерируем список карт и присваиваем их к общему списку и списку для гугла
                $maps->genMapsList();
                $site_map .= $maps->maps_list;
                $google_site_map .= $maps->google_maps_list ? $maps->google_maps_list : $maps->maps_list;
            }
        }
        // Закрытие тега списка карт
        $site_map .= '</sitemapindex>';
        $google_site_map .= '</sitemapindex>';
        // Сохраняем списки карт
        // Сохраняем списки карт
        $maps_file = fopen(PATH . "/sitemap.xml", "w");
        fwrite($maps_file, $site_map);
        fclose($maps_file);
        return TRUE;
    }
}

abstract class comMaps{
    public $config; // Настройки генерации карт для текущего компонента
    public $host; // Ссылна сайта, не используется HOST так как при генерации CRON не работает
    public $maps_list; // Список ссылок на файлы карт
    public $google_maps_list=""; // Список ссылок на файлы карт предназначенных для гугла
    public $inDB; // Объект базы данных
    protected $total; // Общее число элементов
    protected $total_page; // Общее число фалов карт
    protected $page; // Номер текущего файла карт
    protected $max_items = 2000; // Максимальное число элементов в одном файле карт
    protected $num; // Номер текущего элемента по счету
    protected $maps_file; // Текущий открытый файл для записи
    protected $generateMap=FALSE; // Флаг указывающий нужно ли генерировать карту
    protected $html=""; // HTML код карты
    protected $maps='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; // Сам файл карт

    public abstract function FillMapsArray($html=FALSE);
    public abstract function user_map_start();
    public abstract function user_re_map_start();
    public abstract function user_set_map_url($item);
    public abstract function user_map_end();
    public abstract function user_genMapsList();

    public function map_start(){
        $this->total_page = ($this->total > $this->max_items) ? ceil($this->total/$this->max_items) : 1;
        $this->page = ((time() - $this->get_edit_time()) > $this->config['full_time']*86400) ? 1 : $this->total_page;
        if ($this->page == $this->total_page){
            if ((time() - $this->get_edit_time($this->page)) > $this->config['time']*3600){
                $this->generateMap = TRUE;
            }
        }else{
            $this->generateMap = TRUE;
        }
        if ($this->generateMap){
            $this->num = ($this->page-1)*$this->max_items;
            $prefix = ($this->page == 1) ? "" : "_".$this->page;
            $this->maps_file = fopen(PATH . "/sitemaps/" . $this->link . $prefix . ".xml", "w");
            $this->user_map_start();
        }
    }
    
    public function re_map_start(){
        if ($this->generateMap){
            $this->map_end();
            $this->page++;
            $this->maps = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $prefix = ($this->page == 1) ? "" : "_".$this->page;
            $this->maps_file = fopen(PATH . "/sitemaps/" . $this->link . $prefix . ".xml", "w");
            $this->user_re_map_start();
        }
    }

    public function set_map_url($item){
        if ($this->generateMap){
            $this->num++;
            if ($this->num > $this->page*$this->max_items){ $this->re_map_start(); }
            if (!isset($item[3])){ $item[3] = date('Y-m-d'); }
            $this->maps .= '<url><loc>'.$item[0].'</loc></url>';
            $this->user_set_map_url($item);
        }
    }

    public function map_end(){
        if ($this->generateMap){
            if ($this->maps_file){
                $this->maps .= "</urlset>";
                fwrite($this->maps_file, $this->maps);
                unset($this->maps);
                fclose($this->maps_file);
            }
            $this->user_map_end();
        }
    }
    
    public function genMapsList(){
        $page = 1;
        while ($page <= $this->total_page){
            $prefix = ($page == 1) ? "" : "_".$page;
            $this->maps_list .= '<sitemap><loc>https://sanmarket.kz/sitemaps/' . $this->link . $prefix . '.xml</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>';
            $page++;
        }
        $this->user_genMapsList();
    }
    
    public function html(){
        return '<h1 class="con_heading">Карта сайта</h1>'.$this->html;
    }
    
    public function get_edit_time($num=1){
        @clearstatcache();
        $prefix = ($num == 1) ? "" : "_".$num;
        if (!file_exists(PATH . "/sitemaps/" . $this->link . $prefix . ".xml")){
            return 0;
        }
        return filemtime(PATH . "/sitemaps/" . $this->link . $prefix . ".xml");
    }
    
    protected function set_html_cat($title, $url, $padding=0){
        $this->html .= '<div style="padding-left:' . $padding . 'px;" class="cat_link"><a href="' . $url . '" title="' . $title . '">&bull; ' . $title . '</a></div>';
    }
    
    protected function set_html_item_start(){ /*$this->html .= '<ul style="list-style-type: none;">';*/ }
    
    protected function set_html_item($title, $url){ /*$this->html .= '<li><a href="' . $url . '">' . $title . '</a></li>';*/ }
    
    protected function set_html_item_end(){ /*$this->html .= '</ul>';*/ }
    
    public function checkContentAccess($access_list){
        if (!$access_list) { return true; }
        $access_list = cmsCore::yamlToArray($access_list);
        if (!is_array($access_list)) { return true; }
        return in_array(8, $access_list);
    }

    public function getCategoryTree($sql_table, $link, $id=FALSE){
        $sql = "SELECT * FROM ".$sql_table." WHERE published = 1 ORDER BY NSLeft";
        $result = $this->inDB->query($sql);
        if (!$this->inDB->num_rows($result)){
            return FALSE;
        }
        $cats = array();
        while ($cat = $this->inDB->fetch_assoc($result)){
            if ($id){
                $cat['seolink'] = $link."/".$cat['id'];
            }else{
                $cat['seolink'] = $link."/".$cat['seolink'];
            }
            $cats[] = $cat;
        }
        return $cats;
    }
}
