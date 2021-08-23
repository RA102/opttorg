<?php

include_once PATH . "/components/sitemap/sm_components/sm_commaps.php";

if (!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

class shop_map extends comMaps
{
    public $title = "Интернет магазин";
    public $link = "shop";

    public function __construct()
    {
        $this->inDB = cmsDatabase::getInstance();
        $this->total = $this->inDB->rows_count("cms_shop_items", "published = 1");
        $this->total = $this->total + $this->inDB->rows_count("cms_shop_cats", "published = 1");
    }

    public function FillMapsArray($html = FALSE)
    {
        $this->map_start();
        if (!$this->generateMap and !$html) {
            return FALSE;
        }
        $cats = $this->getCategoryTree("cms_shop_cats", $this->host . "/shop");
        $this->html .= '<div class="well">';
        foreach ($cats as $cat) {
            if ($cat['id'] == 1) {
                $cat['title'] = "Корневой раздел магазина";
                $cat['seolink'] = $this->host . "/shop";
            }
            if ($this->generateMap) {
                $this->set_map_url(array($cat['seolink'], "daily", "0.9"));
            }
            if ($html) {
                $this->set_html_cat($cat['title'], $cat['seolink'], ($cat['NSLevel'] - 1) * 20);
            }
            $sql = "SELECT pubdate, title, seolink FROM cms_shop_items WHERE category_id = '" . $cat['id'] . "' AND published = 1";
            $result = $this->inDB->query($sql);
            if ($html) {
                $this->set_html_item_start();
            }
            while ($item = $this->inDB->fetch_assoc($result)) {
                $item['pubdate'] = strtotime($item['pubdate']);
                if ($this->generateMap) {
                    $this->set_map_url(array($this->host . "/shop/" . $item['seolink'] . ".html", $item['pubdate'] >= strtotime("-1 week") ? "daily" : "weekly", $item['pubdate'] >= strtotime("-1 week") ? "0.9" : "0.8", date("Y-m-d", $item['pubdate'])));
                }
                //if ($html){ $this->set_html_item($item['title'], $this->host . "/shop/" . $item['seolink'] . ".html"); }
            }
            if ($html) {
                $this->set_html_item_end();
            }

        }
        $this->html .= '</div>';
    }

    public function user_map_start()
    {
        return FALSE;
    }

    public function user_re_map_start()
    {
        return FALSE;
    }

    public function user_set_map_url($item)
    {
        return FALSE;
    }

    public function user_map_end()
    {
        return FALSE;
    }

    public function user_genMapsList()
    {
        return FALSE;
    }
}
