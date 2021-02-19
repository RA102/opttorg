<?php
if (!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}


class cms_model_sitemap
{
    public $config = array();

    public function __construct()
    {
        $this->config = self::getconfig();
    }

    public static function getConfig()
    {
        $inCore = cmsCore::getinstance();
        $cfg = $inCore->loadComponentConfig("sitemap");
        return $cfg;
    }

    //Возвращает список поддерживаемых и установленных компонентов
    public function getSMComponents()
    {
        $inCore = cmsCore::getInstance();
        $sm_components = $this->getSMComponentsDirs();
        $components = $this->getComponents();
        if (!$sm_components) {
            return false;
        }
        foreach ($sm_components as $sm_component) {
            $installed = FALSE;
            if ($components[$sm_component]['link']) {
                $installed = TRUE;
            }
            if ($installed) {
                $components_list[] = $components[$sm_component];
            }
        }
        if (!$components_list) {
            return FALSE;
        }
        return $components_list;
    }

    //Возвращает список поддерживаемых компонентов
    public function getSMComponentsDirs()
    {
        $dir = PATH . '/components/sitemap/sm_components';
        $pdir = opendir($dir);
        $sm_components = array();
        while ($nextfile = readdir($pdir)) {
            if (($nextfile != '.') && ($nextfile != '..') && !is_dir($dir . '/' . $nextfile) && ($nextfile != '.svn') && (substr($nextfile, 0, 3) == 'sm_')) {
                $file_name = str_replace(array("sm_", ".php"), array("", ""), $nextfile);
                $sm_components[$file_name] = $file_name;
            }
        }
        if (!sizeof($sm_components)) {
            return false;
        }
        return $sm_components;
    }

    //Возвращает список установленных компонентов
    public function getComponents()
    {
        $inDB = cmsDatabase::getinstance();
        $sql = "SELECT title, link, published FROM cms_components WHERE 1 = 1";
        $result = $inDB->query($sql);
        if (!$inDB->num_rows($result)) {
            return FALSE;
        }
        $components = array();
        while ($component = $inDB->fetch_assoc($result)) {
            $components[$component['link']] = $component;
        }
        return $components;
    }

    //Функция генерации карты вызываемая по CRON 
    public function generateMap()
    {
        clearstatcache();
        $inCore = cmsCore::getInstance();
        $components = $this->getSMComponents();
        $site_map = $google_site_map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        foreach ($components as $component) {
            if (($this->config[$component['link']]['published'] == 1) and $component['published'] == 1) {
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


