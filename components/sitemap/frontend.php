<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

function sitemap(){
    $inPage = cmsPage::getInstance();
    $inPage->addPathway("Карта Сайта");
    $inPage->setTitle("Карта Сайта");
    cmsCore::loadModel("sitemap");
    $model = new cms_model_sitemap();
    $do = cmsCore::request("do", "str", "generate_map");
    if ($do == "generate_map"){
        // Получаем список поддерживаемых компонентов
        $components = $model->getSMComponents();
        // Открытие тега списка карт
        $site_map = $google_site_map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        // Перебираем список поддерживаемых компонентов и проверям разрешена ли генерация карты для них
        foreach ($components as $component){
            if (($model->config[$component['link']]['published'] == 1) and $component['published'] == 1){
                // Подключаем класс генератора карт для компонента
                cmsCore::includeFile("components/sitemap/sm_components/sm_" . $component['link'] . ".php");
                // Инициализируем класс
                $map_class = $component['link'] . "_map";
                $maps = new $map_class();
                // Передаем классу конфигурацию, она доступна в классе в переменнов $this->config а через $this->config['config'] доступны дополнительные настройки из xml файла при его наличии
                //$maps->setConfig($model->config[$component['link']]);
                $maps->config = $model->config[$component['link']];
                $maps->host = $model->config['host'];
                // Вызываем функцию получения данных из базы и составления html и xml карт
                $maps->FillMapsArray(TRUE);
                // Закрываем и записываем последний файл карт если он не был записан ранее
                $maps->map_end();
                // Генерируем список карт и присваиваем их к общему списку и списку для гугла
                $maps->genMapsList();
                $site_map .= $maps->maps_list;
                $google_site_map .= $maps->google_maps_list ? $maps->google_maps_list : $maps->maps_list;
                // Выводим html карту
                echo $maps->html();
            }
        }
        // Закрытие тега списка карт
        $site_map .= '</sitemapindex>';
        $google_site_map .= '</sitemapindex>';
        // Сохраняем списки карт        
        $maps_file = fopen(PATH . "/sitemap.xml", "w");
        fwrite($maps_file, $site_map);
        fclose($maps_file);
        return;
    }
}
?>
