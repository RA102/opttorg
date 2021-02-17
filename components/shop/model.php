<?php
if (!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

class cms_model_shop
{

    private $where = '';
    private $group_by = '';
    private $order_by = '';
    private $limit = '100';

    /* ========================================================================== */
    /* ========================================================================== */

    function __construct()
    {
        $this->inDB = cmsDatabase::getInstance();
    }

    /* ========================================================================== */
    /* ========================================================================== */

    public static function getDefaultConfig()
    {

        $cfg = array('is_shop' => 1, 'is_skip_pay' => 1, 'show_vendors' => 1, 'show_cats' => 1, 'show_subcats' => 1, 'show_desc' => 1, 'show_full_desc' => 1, 'show_thumb' => 1, 'show_hit_img' => 1, 'show_decimals' => 2, 'show_filter' => 1, 'show_filter_vendors' => 1, 'show_compare' => 1, 'compare_prices' => 1, 'show_char_grp' => 1, 'show_comments' => 0, 'show_related' => 1, 'related_count' => 5, 'img_w' => 350, 'img_h' => 350, 'thumb_w' => 150, 'thumb_h' => 150, 'img_sqr' => 0, 'thumb_sqr' => 1, 'watermark' => 0, 'perpage' => 15, 'currency' => 'тг.', 'notify_send' => 0, 'notify_send_customer' => 0, 'notify_email' => 'orders@instantshop.ru', 'qty_mode' => 'any', 'subcats_order' => 'title', 'show_cat_chars' => 0, 'show_items_nav' => 0, 'link_ttl' => 48, 'items_orderby' => 'ordering', 'items_orderto' => 'asc', 'after_cart' => 'stay', 'ord_req' => array('name', 'email', 'org', 'inn', 'phone', 'email', 'address'), 'track_qty' => 0, 'ratings' => 1);

        return $cfg;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getConfig()
    {

        $inCore = cmsCore::getInstance();

        $default_cfg = $this->getDefaultConfig();
        $cfg = $inCore->loadComponentConfig('shop');
        $cfg = array_merge($default_cfg, $cfg);

        return $cfg;

    }


    /* ========================================================================== */
    /* ========================================================================== */

    public function getCommentTarget($target, $target_id)
    {

        $result = array();

        switch ($target) {

            case 'shopitem':
                $item = $this->inDB->get_fields('cms_shop_items', "id={$target_id}", 'title, seolink');
                $result['link'] = '/shop/' . $item['seolink'] . '.html';
                $result['title'] = $item['title'];
                break;

        }

        return ($result ? $result : false);

    }


    /* ========================================================================== */
    /* ========================================================================== */
    /* ==============                                           ================= */
    /* ==============         УСЛОВИЯ ОТБОРА ТОВАРОВ            ================= */
    /* ==============                                           ================= */
    /* ========================================================================== */
    /* ========================================================================== */

    private function resetConditions()
    {

        $this->where = '';
        $this->group_by = '';
        $this->order_by = '';
        $this->limit = '';

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function where($condition)
    {
        $this->where .= ' AND (' . $condition . ')' . "\n";
    }

    public function whereCatsIs($cats)
    {
        $this->where .= " AND (";
        foreach ($cats as $key => $cat_id) {
            $this->where .= "i.category_id={$cat_id}";
            if ($key < sizeof($cats) - 1) {
                $this->where .= " OR ";
            }
        }
        $this->where .= ")\n";
        return;
    }

    public function wherePriceFrom($price)
    {
        $this->where("i.price >= '{$price}'");
    }

    public function wherePriceTo($price)
    {
        $this->where("i.price <= '{$price}'");
    }

    public function whereCharIs($char_id, $value)
    {
        $value = trim($value);
        $this->where .= " AND EXISTS (
                            SELECT 1
                            FROM cms_shop_chars_val
                            WHERE   cms_shop_chars_val.char_id = {$char_id} AND
                                    cms_shop_chars_val.val = '$value' AND
                                    cms_shop_chars_val.item_id = i.id
                          )" . "\n";
    }

    public function whereCharLike($char_id, $value)
    {
        if (is_array($value)) {
            $value = trim($value[0]);
        } else {
            $value = trim($value);
        }
        $this->where .= " AND EXISTS (
                            SELECT 1
                            FROM cms_shop_chars_val
                            WHERE   cms_shop_chars_val.char_id = {$char_id} AND
                                    cms_shop_chars_val.val LIKE '%$value%' AND
                                    cms_shop_chars_val.item_id = i.id
                          )" . "\n";
    }

    public function whereCharBetween($char_id, $range)
    {

        $conditions = array();

        if ($range['from']) {
            $value = intval($range['from']);
            $conditions[] = "cms_shop_chars_val.val >= $value";
        }

        if ($range['to']) {
            $value = intval($range['to']);
            $conditions[] = "cms_shop_chars_val.val <= $value";
        }

        if (!$conditions) {
            return;
        }

        $conditions = implode(" AND ", $conditions);

        $this->where .= " AND EXISTS (
                            SELECT 1
                            FROM cms_shop_chars_val
                            WHERE   cms_shop_chars_val.char_id = {$char_id} AND
                                    {$conditions} AND
                                    cms_shop_chars_val.item_id = i.id
                          )" . "\n";

    }

    public function whereCharIn($char_id, $values)
    {

        if (sizeof($values) == 1) {
            $this->whereCharLike($char_id, $values);
            return;
        }

        $this->where .= " AND (" . "\n";

        foreach ($values as $key => $value) {
            $value = trim($value);
            $this->where .= "EXISTS (
                                SELECT 1
                                FROM cms_shop_chars_val
                                WHERE   cms_shop_chars_val.char_id = {$char_id} AND
                                        cms_shop_chars_val.val LIKE '%$value%' AND
                                        cms_shop_chars_val.item_id = i.id
                             )";

            if ($key < sizeof($values) - 1) {
                $this->where .= " OR ";
            }

        }

        $this->where .= ")";

    }

    public function whereCatIs($cat_id)
    {
        $this->where .= "AND (ic.category_id = c.id AND ic.item_id = i.id)
                         AND (ic.category_id={$cat_id})\n";
        return;
    }

    public function whereRecursiveCatIs($cat_id)
    {
        $keys = $this->inDB->get_fields('cms_shop_cats', "id={$cat_id}", 'NSLeft, NSRight');
        $this->where .= "AND (ic.category_id = c.id AND ic.item_id = i.id)
                         AND (c.NSLeft>={$keys['NSLeft']} AND c.NSRight<={$keys['NSRight']})
                         \n";
        return;
    }

    public function whereOrderStatusIs($status)
    {
        $this->where .= " AND o.status = {$status}";
    }

    public function whereVendorIs($vendor_id)
    {
        $this->where .= " AND (i.vendor_id={$vendor_id})\n";
        return;
    }

    public function whereVendorIn($vendors)
    {

        if (is_array($vendors)) {
            $vendors_range = rtrim(implode(',', $vendors), ',');
            $this->where .= " AND (i.vendor_id IN ({$vendors_range}))";
        } else {
            $this->where .= " AND (i.vendor_id = '{$vendors}')";
        }
        return;

    }

    public function groupBy($field)
    {
        $this->group_by = 'GROUP BY ' . $field;
    }

    public function orderBy($field, $direction = 'ASC')
    {
        $this->order_by = 'ORDER BY ' . $field . ' ' . $direction;
    }

    public function limitIs($from, $howmany = '')
    {
        $this->limit = (int)$from;
        if ($howmany) {
            $this->limit .= ', ' . $howmany;
        }
    }

    public function limitPage($page, $perpage)
    {
        $this->limitIs(($page - 1) * $perpage, $perpage);
    }

    /* ========================================================================== */
    /* ========================================================================== */
    /* ==============                                           ================= */
    /* ==============                  ТОВАРЫ                   ================= */
    /* ==============                                           ================= */
    /* ========================================================================== */
    /* ========================================================================== */

    public function getItems($only_published = true, $is_discounts = true)
    {

        $inUser = cmsUser::getInstance();

        $items = array();

        $cfg = $this->getConfig();

        $session_id = session_id();

        $what_cats = mb_strstr($this->where, 'ic.') ? ', ic.ordering as ordering' : '';
        $from_cats = mb_strstr($this->where, 'ic.') ? ', cms_shop_items_cats ic' : '';

        if ($only_published) {
            $this->where('i.published = 1');
        }
        if ($only_published) {
            $this->where('c.published = 1');
        }

        $sql = "SELECT  DISTINCT i.id,
                        i.*,
                        c.title as category,
                        DATE_FORMAT(i.pubdate, '%d.%m.%Y') as pubdate,
                        DATE_FORMAT(i.filedate, '%d.%m.%Y') as filedate,
                        IFNULL(v.title, '') as vendor,
                        IFNULL(v.id, 0) as vendor_id,
                        IFNULL(cm.item_id, 0) as is_in_compare
                        {$what_cats}

                FROM    cms_shop_cats c
                        {$from_cats},
                        cms_shop_items i

                LEFT JOIN cms_shop_vendors v    ON i.vendor_id = v.id
                LEFT JOIN cms_shop_compare cm   ON i.id = cm.item_id AND cm.session_id = '{$session_id}'

                WHERE   1=1
                        {$this->where}

                {$this->group_by}

                {$this->order_by}\n";

        if ($this->limit) {
            $sql .= "LIMIT {$this->limit}";
        }

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        $cfg = $this->getConfig();

        while ($item = $this->inDB->fetch_assoc($result)) {

            $deltas = $is_discounts ? $this->getPriceDiscounts($item['category_id']) : false;

            // если были скидки, применяем дельты
            if ($is_discounts && ($deltas['prc'] || $deltas['abs'])) {
                $item['price'] = $this->calculatePrice($item['price'], $deltas['abs'], $deltas['prc']);
            }

            $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $item['id'] . '.jpg')) ? 'shop' . $item['id'] . '.jpg' : 'shop_default.jpg';
            $item['price'] = number_format($item['price'], $cfg['show_decimals'], '.', '');
            $item['old_price'] = number_format($item['old_price'], $cfg['show_decimals'], '.', '');
            ///////////////////////////////////
            $item['ves'] = number_format($item['ves'], 2, '.', '');
            $item['vol'] = number_format($item['vol'], 2, '.', '');


            //варианты
            $item['vars'] = array();
            $varres = $this->inDB->query("SELECT id, art_no, title, price, qty FROM cms_shop_items_bind WHERE item_id={$item['id']} ORDER BY art_no");
            if ($this->inDB->num_rows($varres)) {
                while ($var = $this->inDB->fetch_assoc($varres)) {

                    if (!$var['price']) {
                        $var['price'] = $item['price'];
                        $var['is_price'] = 0;
                    } else {
                        $var['is_price'] = 1;
                    }

                    // если были скидки, применяем дельты
                    if ($is_discounts && ($deltas['prc'] || $deltas['abs'])) {
                        $var['price'] = $this->calculatePrice($var['price'], $deltas['abs'], $deltas['prc']);
                    }

                    $var['price'] = number_format($var['price'], $cfg['show_decimals'], '.', '');

                    $item['vars'][] = $var;

                }
            }

            //товар в корзине?
            $item['is_in_cart'] = $this->isItemInCart($item['id']);

            //характеристики
            if ($cfg['show_cat_chars']) {
                $item['chars'] = $this->getItemChars($item['id'], $item['category_id']);
            }

            $item['user_voted'] = $this->isUserVoted($item['id'], $inUser->id);


            $today = date('d.m.Y');

            if ($item['pubdate'] > $today) {
                $item['novinka'] = 1;
            } else {
                $item['novinka'] = 0;
            }

            $items[] = $item;

        }

        $this->resetConditions();

        return $items;

    }

    /* ========================================================================== */
    /* ========================================================================== */
    public function getItemFromVenCode($itemVenCode)
    {
        $sql = "SELECT i.id FROM cms_shop_items i WHERE ven_code LIKE '{$itemVenCode}'";
        $result = $this->inDB->query($sql);
        return $this->inDB->fetch_assoc($result);
    }



    /* ========================================================================== */
    /* ========================================================================== */

    public function getItemsCount($only_published = true)
    {

        $items = array();

        $from_cats = mb_strstr($this->where, 'ic.') ? ', cms_shop_items_cats ic' : '';

        if ($only_published) {
            $this->where('i.published = 1');
        }

        $sql = "SELECT  i.id

                FROM    cms_shop_items i,
                        cms_shop_cats c
                        {$from_cats}

                WHERE   1=1
                        {$this->where}

                {$this->group_by}

                \n";

        $result = $this->inDB->query($sql);

        return $result ? $this->inDB->num_rows($result) : 0;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getItemBySeolink($seolink)
    {
        $item_id = $this->inDB->get_field('cms_shop_items', "seolink='$seolink'", 'id');
        if (!$item_id) {
            return false;
        }
        return $this->getItem($item_id);
    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getItem($id, $is_discounts = true)
    {

        $inCore = cmsCore::getInstance();
        $inUser = cmsUser::getInstance();

        $item = array();

        $sql = "SELECT i.*,
                       DATE_FORMAT(i.pubdate, '%d.%m.%Y') as pubdate,
                       DATE_FORMAT(i.filedate, '%d.%m.%Y') as filedate,
                       IFNULL(v.title, '') as vendor,
                       c.is_catalog as hide_price
                FROM cms_shop_items i
                LEFT JOIN cms_shop_vendors v ON i.vendor_id = v.id
                LEFT JOIN cms_shop_cats c ON i.category_id = c.id
                WHERE i.id = $id
                LIMIT 1";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            $item = $this->inDB->fetch_assoc($result);
        }

        if (!$item) {
            return false;
        }

        $cfg = $this->getConfig();

        $deltas = $is_discounts ? $this->getPriceDiscounts($item['category_id']) : false;

        // если были скидки, применяем дельты
        if ($is_discounts && ($deltas['prc'] || $deltas['abs'])) {
            $item['price'] = $this->calculatePrice($item['price'], $deltas['abs'], $deltas['prc']);
        }

        $item['price'] = number_format($item['price'], $cfg['show_decimals'], '.', '');
        $item['old_price'] = number_format($item['old_price'], $cfg['show_decimals'], '.', '');

        $item['ves'] = number_format($item['ves'], 2, '.', '');
        $item['vol'] = number_format($item['vol'], 2, '.', '');

        //изображения
        $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/medium/shop' . $item['id'] . '.jpg')) ? 'shop' . $item['id'] . '.jpg' : 'shop_default.jpg';
        $item['images'] = $this->getItemImages($id);

        $item['filesize_format'] = 0; //($item['filesize']/1024 < 1024 ? round($item['filesize']/1024).' Кб' : round($item['filesize']/1024/1024, 1).' Мб');

        //категория
        $item['category'] = $this->getCategory($item['category_id']);

        //доп. категории
        $item['cats'] = array();

        $catsql = "SELECT cat.title as title, cat.seolink as seolink, ic.category_id as category_id
                             FROM cms_shop_items_cats ic, cms_shop_cats cat
                             WHERE ic.item_id={$id} AND ic.category_id = cat.id";

        $catres = $this->inDB->query($catsql);
        if ($this->inDB->num_rows($catres)) {
            while ($cat = $this->inDB->fetch_assoc($catres)) {
                $item['cats'][] = $cat['category_id'];
                $item['cats_data'][] = $cat;
            }
        }

        //варианты
        $item['vars'] = array();
        $varres = $this->inDB->query("SELECT id, art_no, title, price, qty FROM cms_shop_items_bind WHERE item_id={$id} ORDER BY art_no");
        if ($this->inDB->num_rows($varres)) {
            while ($var = $this->inDB->fetch_assoc($varres)) {

                if (!$var['price']) {
                    $var['price'] = $item['price'];
                    $var['is_price'] = 0;
                } else {
                    $var['is_price'] = 1;
                }

                // если были скидки, применяем дельты
                if ($is_discounts && ($deltas['prc'] || $deltas['abs'])) {
                    $var['price'] = $this->calculatePrice($var['price'], $deltas['abs'], $deltas['prc']);
                }

                $var['price'] = number_format($var['price'], $cfg['show_decimals'], '.', '');

                $item['vars'][] = $var;

            }
        }

        //значения характеристик
        $item['chars'] = $this->getItemChars($item['id'], $item['category_id']);

        //товар в корзине?
        $item['is_in_cart'] = $this->isItemInCart($id);

        $inCore->loadLib('tags');
        $item['tagline'] = cmsTagBar('shop', $item['id']);
        $today = date('d.m.Y');
        if ($item['pubdate'] > $today) {
            $item['novinka'] = 1;
        } else {
            $item['novinka'] = 0;
        }

        $item['user_voted'] = $this->isUserVoted($item['id'], $inUser->id);

        return $item;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getItemChars($item_id, $category_id)
    {

        $chars = array();

        global $_LANG;

        $inCore = cmsCore::getInstance();

        $sql = "SELECT  chars.id as id,
                        chars.title as title,
                        chars.is_compare as is_compare,
                        chars.is_custom as is_custom,
                        chars.fieldtype as fieldtype,
                        chars.fieldgroup as fieldgroup,
                        chars.units as units,
                        val.val as value

                 FROM  cms_shop_chars chars

                 LEFT JOIN cms_shop_chars_bind bind ON bind.cat_id={$category_id} AND bind.char_id = chars.id
                 LEFT JOIN cms_shop_chars_val val ON val.char_id = chars.id AND val.item_id = {$item_id}

                 WHERE  ((bind.cat_id={$category_id} AND bind.char_id = chars.id) OR (chars.bind_all=1))
                        AND chars.published = 1

                ORDER BY bind.ordering ASC";

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($char = $this->inDB->fetch_assoc($result)) {

            switch ($char['fieldtype']) {

                //Текстовое поле
                case 'text':
                    $value = $char['value'];
                    break;

                //Чекбоксы
                case 'cbox':
                    $value = trim($char['value'], '|');
                    $char['items'] = explode('|', $value);
                    break;

                //Гиперссылка
                case 'link':
                    if ($char['value'] == 'http://') {
                        break;
                    }
                    $hits = $this->inDB->get_field('cms_downloads', "fileurl='{$char['value']}'", 'hits');
                    $value = '<a class="shop_link" href="/load/url=' . $char['value'] . '" target="_blank">' . str_replace('http://', '', $char['value']) . '</a>' . ($hits ? '<span class="go_hits">' . $hits . '</span>' : '');
                    break;

                //Электронная почта
                case 'email':
                    $value = '<a href="mailto:' . $char['value'] . '">' . $char['value'] . '</a>';
                    break;

                //Файл
                case 'file':
                    if (!$char['value']) {
                        $value = '';
                        break;
                    }
                    $file = $inCore->yamlToArray($char['value']);
                    $value = '<a class="shop_download"  title="' . $_LANG['SHOP_HINT_DOWNLOAD'] . '" href="/shop/download/' . $item_id . '/' . $char['id'] . '">' . $_LANG['SHOP_DOWNLOAD'] . '</a> (' . $this->formatFileSize($file['size']) . ')';
                    break;

                //Адрес на гугл-карте
                case 'gmap':
                    $url = 'http://maps.google.ru/maps?f=q&source=s_q&hl=ru&geocode=&q=' . urlencode($char['value']);
                    $value = '<a class="shop_map" href="' . $url . '" title="' . $_LANG['SHOP_HINT_MAP'] . '" target="_blank">' . $char['value'] . '</a>';
                    break;

                //Адрес на яндекс-карте
                case 'ymap':
                    $url = 'http://maps.yandex.ru/?text=' . urlencode($char['value']);
                    $value = '<a class="shop_map" href="' . $url . '" title="' . $_LANG['SHOP_HINT_MAP'] . '" target="_blank">' . $char['value'] . '</a>';
                    break;

                //Профиль пользователя
                case 'user':
                    $user = explode('|', $char['value']);
                    $user['login'] = $user[0];
                    $user['nickname'] = $user[1];
                    $value = '<a class="shop_user" href="' . cmsUser::getProfileURL($user['login']) . '" title="' . $_LANG['SHOP_HINT_USER'] . '" target="_blank">' . $user['nickname'] . '</a>';
                    break;


                //По-умолчанию
                default:
                    $value = $char['value'];
                    break;

            }

            $char['value'] = $value;

            $chars[$char['id']] = $char;
        }

        return is_array($chars) ? $chars : false;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function formatFileSize($size)
    {

        global $_LANG;

        if ($size < 1024) {
            return $size . ' ' . $_LANG['SHOP_FILESIZE_B'];
        }
        if (round($size / 1024) < 1024) {
            return round($size / 1024) . ' ' . $_LANG['SHOP_FILESIZE_KB'];
        }

        return round($size / 1024 / 1024) . ' ' . $_LANG['SHOP_FILESIZE_MB'];

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getItemImages($item_id)
    {

        $photo_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/photos/small';
        $pattern = $photo_dir . '/shop' . $item_id . '-*.jpg';

        $files = array();

        if (!glob($pattern)) {
            return false;
        }

        foreach (@glob($pattern) as $filename) {
            $files[] = basename($filename);
        }

        return is_array($files) ? $files : false;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function toggleItems($category_id, $visibility)
    {

        if (!$category_id) {
            return false;
        }

        $this->whereCatIs($category_id);

        $items = $this->getItems(false);

        if (!$items) {
            return false;
        }

        $id_list = '';

        foreach ($items as $item) {
            $id_list .= $item['id'] . ',';
        }

        $id_list = rtrim($id_list, ',');

        $flag = $visibility ? 1 : 0;

        $this->inDB->query("UPDATE cms_shop_items SET published = {$flag} WHERE id IN ({$id_list})");

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteItems($items)
    {

        if (!is_array($items)) {
            return false;
        }

        foreach ($items as $item_id) {
            $this->deleteItem($item_id);
        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteItem($id)
    {

        $imageurl = 'shop' . $id . '.jpg';

        @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/$imageurl", 0777);
        @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/small/$imageurl", 0777);
        @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/medium/$imageurl", 0777);

        @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/photos/' . $imageurl);
        @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/' . $imageurl . '.jpg');
        @unlink($_SERVER['DOCUMENT_ROOT'] . '/images/photos/medium/' . $imageurl . '.jpg');

        $this->inDB->query("DELETE FROM cms_shop_items WHERE id={$id}");
        $this->inDB->query("DELETE FROM cms_shop_items_bind WHERE item_id={$id}");
        $this->inDB->query("DELETE FROM cms_shop_items_cats WHERE item_id={$id}");
        $this->inDB->query("DELETE FROM cms_shop_chars_val WHERE item_id={$id}");
        $this->inDB->query("DELETE FROM cms_shop_chars_val WHERE item_id={$id}");
        $this->inDB->query("DELETE FROM cms_tags WHERE target='shop' AND item_id = {$id}");
        $this->inDB->query("DELETE FROM cms_comments WHERE target = 'shop' AND target_id = {$id}");
        $this->inDB->query("DELETE FROM cms_ratings WHERE target = 'shop' AND item_id = {$id}");

        $this->reorder('cms_shop_items_cats', 'category_id', 'item_id');

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function moveCategory($cat_id, $dir = 'up')
    {

        $inCore = cmsCore::getInstance();

        $sql = "SELECT * FROM cms_shop_cats ORDER BY NSLeft";
        $rs = $this->inDB->query($sql);

        if ($this->inDB->num_rows($rs)) {
            $level = array();
            while ($item = $this->inDB->fetch_assoc($rs)) {
                if (isset($level[$item['NSLevel']])) {
                    $level[$item['NSLevel']] += 1;
                } else {
                    $level[] = 1;
                }
                $this->inDB->query("UPDATE cms_shop_cats SET ordering = " . $level[$item['NSLevel']] . " WHERE id=" . $item['id']);
            }
        }

        $ns = $inCore->nestedSetsInit('cms_shop_cats');

        if ($dir == 'up') {
            $ns->MoveOrdering($cat_id, -1);
        } else {
            $ns->MoveOrdering($cat_id, 1);
        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function moveItem($item_id, $cat_id, $dir, $step = 1)
    {

        $sign = $dir > 0 ? '+' : '-';

        $current = $this->inDB->get_field('cms_shop_items_cats', "item_id={$item_id} AND category_id={$cat_id}", 'ordering');

        if ($dir > 0) {
            //движение вверх
            //у элемента следующего за текущим нужно уменьшить порядковый номер
            $sql = "UPDATE cms_shop_items_cats
                    SET ordering = ordering-1
                    WHERE category_id={$cat_id} AND ordering = ({$current}+1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }
        if ($dir < 0) {
            //движение вниз
            //у элемента предшествующего текущему нужно увеличить порядковый номер
            $sql = "UPDATE cms_shop_items_cats
                    SET ordering = ordering+1
                    WHERE category_id={$cat_id} AND ordering = ({$current}-1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }

        $sql = "UPDATE cms_shop_items_cats
                   SET ordering = ordering {$sign} {$step}
                   WHERE item_id={$item_id} AND category_id={$cat_id}";
        $this->inDB->query($sql);

        return true;

    }

    public function vperedItem($item_id, $cat_id)
    {

        $current_items = array();

        $sql = "SELECT  item_id
                FROM    cms_shop_items_cats
                WHERE   category_id = {$cat_id}";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($row = $this->inDB->fetch_assoc($result)) {
                $current_items[] = $row['item_id'];
            }
        }

        $maxorder = sizeof($current_items);


        $sql = "UPDATE cms_shop_items_cats
                   SET ordering = {$maxorder} + 1 
                   WHERE item_id={$item_id} AND category_id={$cat_id}";
        $this->inDB->query($sql);

        return true;

    }


    /* ========================================================================== */
    /* ========================================================================== */

    public function movePaySys($item_id, $dir, $step = 1)
    {

        $sign = $dir > 0 ? '+' : '-';

        $current = $this->inDB->get_field('cms_shop_psys', "id={$item_id}", 'ordering');

        if ($dir > 0) {
            //движение вверх
            //у элемента следующего за текущим нужно уменьшить порядковый номер
            $sql = "UPDATE cms_shop_psys
                    SET ordering = ordering-1
                    WHERE ordering = ({$current}+1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }
        if ($dir < 0) {
            //движение вниз
            //у элемента предшествующего текущему нужно увеличить порядковый номер
            $sql = "UPDATE cms_shop_psys
                    SET ordering = ordering+1
                    WHERE ordering = ({$current}-1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }

        $sql = "UPDATE cms_shop_psys
                   SET ordering = ordering {$sign} {$step}
                   WHERE id={$item_id}";
        $this->inDB->query($sql);

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function moveItems($items, $from_cat_id, $to_cat_id)
    {

        if (!is_array($items) || !$to_cat_id) {
            return false;
        }

        //получаем массив текущих товаров в целевой категории
        $current_items = array();

        $sql = "SELECT  item_id
                FROM    cms_shop_items_cats
                WHERE   category_id = {$to_cat_id}";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($row = $this->inDB->fetch_assoc($result)) {
                $current_items[] = $row['item_id'];
            }
        }

        //максимальный порядок
        $ordering = sizeof($current_items);

        //перемещаем товары
        foreach ($items as $key => $id) {

            if (in_array($item_id, $current_items)) {
                continue;
            }

            $item = $this->inDB->get_fields('cms_shop_items', "id={$id}", 'title, url');

            $item['id'] = $id;
            $item['category_id'] = $to_cat_id;
            $item['seolink'] = $this->getSeoLink($item);

            $sql = "UPDATE cms_shop_items SET category_id = {$to_cat_id}, seolink='{$item['seolink']}' WHERE id={$id}";
            $this->inDB->query($sql);

            $ordering += 1;
            $this->inDB->query("DELETE FROM cms_shop_items_cats WHERE item_id = {$id} AND category_id = {$from_cat_id}");
            $this->inDB->query("INSERT INTO cms_shop_items_cats (`item_id`, `category_id`, `ordering`) VALUES ('{$id}', '{$to_cat_id}', '{$ordering}')");

        }

        //упорядочиваем
        $this->reorder('cms_shop_items_cats', 'category_id', 'item_id');

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function setItemFlag($id, $flag, $value)
    {
        $this->inDB->query("UPDATE cms_shop_items SET $flag='$value' WHERE id=$id");
        return true;
    }

    public function setItemsFlag($items, $flag, $value)
    {
        foreach ($items as $id) {
            $this->inDB->query("UPDATE cms_shop_items SET $flag='$value' WHERE id=$id");
        }
        return true;
    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getCompareItems()
    {

        $session_id = session_id();
        $items = array();

        $sql = "SELECT item.id as id,
                          item.title as title,
                          item.price as price,
                          item.seolink as seolink,
                          item.category_id as category_id

                   FROM cms_shop_items item,
                        cms_shop_compare cmp

                   WHERE cmp.item_id = item.id
                     AND cmp.session_id = '{$session_id}'

                          ";

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($item = $this->inDB->fetch_assoc($result)) {

            $deltas = $this->getPriceDiscounts($item['category_id']);

            // если были скидки, применяем дельты
            if ($deltas['prc'] || $deltas['abs']) {
                $item['price'] = $this->calculatePrice($item['price'], $deltas['abs'], $deltas['prc']);
            }

            $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $item['id'] . '.jpg')) ? 'shop' . $item['id'] . '.jpg' : 'shop_default.jpg';
            $item['chars'] = $this->getItemChars($item['id'], $item['category_id']);
            $items[] = $item;
        }

        return $items;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function addCompareItem($item_id)
    {

        $session_id = session_id();

        if (!$item_id) {
            return false;
        }

        $already = $this->inDB->rows_count('cms_shop_compare', "item_id={$item_id} AND session_id='{$session_id}'");

        if ($already) {
            return true;
        }

        $sql = "INSERT INTO cms_shop_compare (`session_id`, `item_id`, `pubdate`)
                VALUES ('{$session_id}', '{$item_id}', NOW())";

        $this->inDB->query($sql);

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteCompare($item_id)
    {

        $session_id = session_id();

        if (!$item_id) {
            return false;
        }

        $sql = "DELETE FROM cms_shop_compare WHERE session_id='{$session_id}' AND item_id='{$item_id}'";

        $this->inDB->query($sql);

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */
    /* ==============                                           ================= */
    /* ==============         ХАРАКТЕРИСТИКИ ТОВАРОВ            ================= */
    /* ==============                                           ================= */
    /* ========================================================================== */
    /* ========================================================================== */

    public function copyCatChars($from_cat_id, $to_cat_id)
    {

        $chars = $this->getCatChars($from_cat_id);

        if (!$chars) {
            return false;
        }

        foreach ($chars as $char) {
            $this->bindChar($char['id'], $to_cat_id);
        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getCatChars($cat_id, $all = true)
    {

        $chars = array();

        if (!$cat_id || $all) {

            $all_sql = "SELECT  chars.id as id,
                                chars.published as published,
                                chars.title as title,
                                chars.fieldtype as fieldtype,
                                chars.fieldgroup as fieldgroup,
                                chars.is_compare as is_compare,
                                chars.is_filter as is_filter,
                                chars.is_filter_many as is_filter_many,
                                chars.`values` as `values`,
                                chars.bind_all as bind_all,
                                chars.units as units,
                                chars.ordering as ordering

                        FROM  cms_shop_chars chars

                        WHERE  chars.bind_all = 1

                        ORDER BY chars.ordering ASC";

            $all_result = $this->inDB->query($all_sql);

            if ($this->inDB->num_rows($all_result)) {
                while ($char = $this->inDB->fetch_assoc($all_result)) {
                    $char['values_arr'] = explode("\n", $char['values']);
                    foreach ($char['values_arr'] as $key => $val) {
                        $char['values_arr'][$key] = trim($val);
                    }
                    $chars[$char['id']] = $char;
                }
            }

        }

        if ($cat_id) {

            $sql = "SELECT  chars.id as id,
                            chars.published as published,
                            chars.title as title,
                            chars.fieldtype as fieldtype,
                            chars.fieldgroup as fieldgroup,
                            chars.is_compare as is_compare,
                            chars.is_filter as is_filter,
                            chars.is_filter_many as is_filter_many,
                            chars.`values` as `values`,
                            chars.bind_all as bind_all,
                            chars.units as units,
                            bind.ordering as ordering

                      FROM  cms_shop_chars chars, cms_shop_chars_bind bind

                     WHERE  bind.cat_id={$cat_id} AND
                            bind.char_id = chars.id

                    ORDER BY bind.ordering ASC";

            $result = $this->inDB->query($sql);

            if ($this->inDB->num_rows($result)) {
                while ($char = $this->inDB->fetch_assoc($result)) {
                    $char['values_arr'] = explode("\n", $char['values']);
                    foreach ($char['values_arr'] as $key => $val) {
                        $char['values_arr'][$key] = trim($val);
                    }
                    $chars[$char['id']] = $char;
                }
            }

        }

        return is_array($chars) ? $chars : false;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function moveChar($item_id, $cat_id, $dir, $step = 1)
    {

        $sign = $dir > 0 ? '+' : '-';

        $current = $this->inDB->get_field('cms_shop_chars_bind', "char_id={$item_id} AND cat_id={$cat_id}", 'ordering');

        if ($dir > 0) {
            //движение вверх
            //у элемента следующего за текущим нужно уменьшить порядковый номер
            $sql = "UPDATE cms_shop_chars_bind
                    SET ordering = ordering-1
                    WHERE cat_id={$cat_id} AND ordering = ({$current}+1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }
        if ($dir < 0) {
            //движение вниз
            //у элемента предшествующего текущему нужно увеличить порядковый номер
            $sql = "UPDATE cms_shop_chars_bind
                    SET ordering = ordering+1
                    WHERE cat_id={$cat_id} AND ordering = ({$current}-1)
                    LIMIT 1";
            $this->inDB->query($sql);
        }

        $sql = "UPDATE cms_shop_chars_bind
                   SET ordering = ordering {$sign} {$step}
                   WHERE char_id={$item_id} AND cat_id={$cat_id}";
        $this->inDB->query($sql);

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function setCharFlag($id, $flag, $value)
    {
        $this->inDB->query("UPDATE cms_shop_chars SET $flag='$value' WHERE id=$id");
        return true;
    }

    public function setCharsFlag($items, $flag, $value)
    {
        foreach ($items as $id) {
            $this->inDB->query("UPDATE cms_shop_chars SET $flag='$value' WHERE id=$id");
        }
        return true;
    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function saveItemVars($item)
    {

        $this->inDB->query("DELETE FROM cms_shop_items_bind WHERE item_id = '{$item['id']}'");
        if (is_array($item['vars_art_no']) && $item['vars_art_no'][0]) {
            foreach ($item['vars_art_no'] as $var_num => $art_no) {
                $title = $item['vars_title'][$var_num];
                $qty = $item['vars_qty'][$var_num];
                $price = str_replace(',', '.', round($item['vars_price'][$var_num], 2));
                $this->inDB->query("INSERT INTO cms_shop_items_bind (`item_id`, `art_no`, `title`, `price`, `qty`) VALUES ('{$item['id']}', '{$art_no}', '{$title}', '{$price}', '{$qty}')");
            }
        }

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function saveItemCategories($item)
    {

        //получаем текущие значения порядка (ordering)
        $current_ord = array();
        $sql = "SELECT category_id, ordering FROM cms_shop_items_cats WHERE item_id={$item['id']}";
        $result = $this->inDB->query($sql);
        if ($this->inDB->num_rows($result)) {
            while ($row = $this->inDB->fetch_assoc($result)) {
                $current_ord[$row['category_id']] = $row['ordering'];
            }
        }

        $this->inDB->query("DELETE FROM cms_shop_items_cats WHERE item_id = '{$item['id']}'");

        if (is_array($item['cats'])) {
            foreach ($item['cats'] as $cat_id) {
                $ordering = isset($current_ord[$cat_id]) ? //если товар уже был в этой категории
                    $current_ord[$cat_id] : //то берем его текущее положение
                    $this->inDB->get_field('cms_shop_items_cats', "category_id={$cat_id}", 'MAX(ordering)') + 1; //иначе он занимает последнее место
                $this->inDB->query("INSERT INTO cms_shop_items_cats (`item_id`, `category_id`, `ordering`) VALUES ('{$item['id']}', '{$cat_id}', '{$ordering}')");
            }
        }

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function saveItemChars($item)
    {

        $inCore = cmsCore::getInstance();

        $chars = $this->getItemChars($item['id'], $item['category_id']);

        //Сначала обрабатываем текстовые характеристики

        if (is_array($chars)) {
            foreach ($chars as $char_id => $char) {
                if ($char['fieldtype'] == 'file') {
                    continue;
                }
                $val = isset($item['chars'][$char_id]) ? $item['chars'][$char_id] : '';
                if (is_array($val)) {
                    $val = '|' . implode('|', $val) . '|';
                }
                $insert_sql = "INSERT INTO cms_shop_chars_val (`item_id`, `char_id`, `val`) VALUES ('{$item['id']}', '{$char_id}', '{$val}')";
                $update_sql = "UPDATE cms_shop_chars_val SET val = '{$val}' WHERE item_id = '{$item['id']}' AND char_id = '{$char_id}'";
                if ($this->inDB->rows_count('cms_shop_chars_val', "item_id={$item['id']} AND char_id={$char_id}")) {
                    $sql = $update_sql;
                } else {
                    $sql = $insert_sql;
                }
                $this->inDB->query($sql);
            }
        }

        //Теперь загружаем характеристики типа "файл"

        foreach ($_FILES as $key => $data_array) {
            if (mb_strstr($key, 'char_file')) {
                $error = $data_array['error'];
                if ($error == UPLOAD_ERR_OK) {

                    $char_id = str_replace('char_file', '', $key);

                    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/upload/userfiles/';
                    $tmp_name = $data_array['tmp_name'];
                    $realfile = basename($data_array['name']);
                    $filename = 'shop-char-' . $item['id'] . '-' . $char_id . '.file';

                    $uploadfile = $uploaddir . $filename;

                    if (@move_uploaded_file($tmp_name, $uploadfile)) {

                        $val = array('name' => $realfile, 'size' => $data_array['size'], 'type' => $data_array['type']);
                        $val = $inCore->arrayToYaml($val);

                        $insert_sql = "INSERT INTO cms_shop_chars_val (`item_id`, `char_id`, `val`) VALUES ('{$item['id']}', '{$char_id}', '{$val}')";
                        $update_sql = "UPDATE cms_shop_chars_val SET val = '{$val}' WHERE item_id = '{$item['id']}' AND char_id = '{$char_id}'";
                        if ($this->inDB->rows_count('cms_shop_chars_val', "item_id={$item['id']} AND char_id={$char_id}")) {
                            $sql = $update_sql;
                        } else {
                            $sql = $insert_sql;
                        }
                        $this->inDB->query($sql);

                    }

                }
            }
        }

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function dropItemImages($files)
    {

        $dir = $_SERVER['DOCUMENT_ROOT'] . '/images/photos/';

        foreach ($files as $num => $file) {
            @chmod($dir . 'small/' . $file, 0777);
            @unlink($dir . 'small/' . $file);
            @chmod($dir . 'medium/' . $file, 0777);
            @unlink($dir . 'medium/' . $file);
        }

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function uploadItemFiles($item_id, $auto_thumb, $is_digital)
    {

        $item = $this->getItem($item_id);

        if (!$item) {
            return;
        }

        $cfg = $this->getConfig();

        $inCore = cmsCore::getInstance();
        $inCore->includeGraphics();

        if ($is_digital) {
            //файл цифрового товара
            if (isset($_FILES["itemfile"]["name"]) && @$_FILES["itemfile"]["name"] != '') {

                $tmp_name = $_FILES["itemfile"]["tmp_name"];
                $path_parts = pathinfo($_FILES['itemfile']['name']);
                $file_orig = basename($_FILES['itemfile']['name']);
                $file = 'shop-' . mb_substr(md5(time() . $item_id), rand(0, 3), 12) . '.file';
                $target_file = PATH . '/upload/userfiles/' . $file;

                $size = $_FILES['itemfile']['size'];

                if (@move_uploaded_file($tmp_name, $target_file)) {

                    if ($item['filename']) {
                        $current_filename = $item['filename'];
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/userfiles/' . $current_filename)) {
                            @chmod(PATH . "/upload/userfiles/{$current_filename}", 0777);
                            @unlink(PATH . "/upload/userfiles/{$current_filename}");
                        }
                    }
                    $this->inDB->query("UPDATE cms_shop_items SET filename='{$file}', filename_orig='{$file_orig}', filesize='{$size}', filedate=NOW() WHERE id={$item_id}");

                }

            }
        } else {
            if ($item['filename']) {
                $current_filename = $item['filename'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/userfiles/' . $current_filename)) {
                    @chmod(PATH . "/upload/userfiles/{$current_filename}", 0777);
                    @unlink(PATH . "/upload/userfiles/{$current_filename}");
                }
                $this->inDB->query("UPDATE cms_shop_items SET is_digital=0, filename='', filename_orig='', filesize=0, filedate=NOW() WHERE id={$item_id}");
            }
        }

        //Изображение
        if (isset($_FILES["imgfile"]["name"]) && @$_FILES["imgfile"]["name"] != '') {
            $tmp_name = $_FILES["imgfile"]["tmp_name"];
            $file = 'shop' . $item_id . '.jpg';
            if (@move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . "/images/photos/$file")) {
                if ($auto_thumb) {
                    @img_resize($_SERVER['DOCUMENT_ROOT'] . "/images/photos/$file", $_SERVER['DOCUMENT_ROOT'] . "/images/photos/small/$file", $cfg['thumb_w'], $cfg['thumb_h'], $cfg['thumb_sqr']);
                    @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/small/$file", 0755);
                }
                @img_resize($_SERVER['DOCUMENT_ROOT'] . "/images/photos/$file", $_SERVER['DOCUMENT_ROOT'] . "/images/photos/medium/$file", $cfg['img_w'], $cfg['img_h'], $cfg['img_sqr'], $cfg['watermark']);
                @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/medium/$file", 0755);
                @unlink($_SERVER['DOCUMENT_ROOT'] . "/images/photos/{$file}");
            }
        }

        //Маленькое изображение (если не создано автоматом)
        if (isset($_FILES["imgfile_small"]["name"]) && @$_FILES["imgfile_small"]["name"] != '' && !$auto_thumb) {
            $small_tmp_name = $_FILES["imgfile_small"]["tmp_name"];
            $file = 'shop' . $item_id . '.jpg';
            if (@move_uploaded_file($small_tmp_name, $_SERVER['DOCUMENT_ROOT'] . "/images/photos/small/$file")) {
                @chmod($_SERVER['DOCUMENT_ROOT'] . "/images/photos/small/$file", 0755);
            }
        }

        //остальные изображения
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/images/photos/';
        $loaded_files = array();
        $img_count = $item['img_count'];

        $list_files = array();

        foreach ($_FILES['upfile'] as $key => $value) {
            foreach ($value as $k => $v) {
                $list_files['upfile' . $k][$key] = $v;
            }
        }

        foreach ($list_files as $key => $data_array) {
            if ($key != 'imgfile' && $key != 'imgfile_small' && $key != 'itemfile' && !mb_strstr($key, 'char_file')) {
                $error = $data_array['error'];
                if ($error == UPLOAD_ERR_OK) {

                    $img_count++;

                    $tmp_name = $data_array['tmp_name'];
                    $filename = 'shop' . $item['id'] . '-' . $img_count . '.jpg';

                    $uploadphoto = $uploaddir . $filename;
                    $uploadthumb = $uploaddir . 'small/' . $filename;
                    $uploadthumb2 = $uploaddir . 'medium/' . $filename;

                    if (@move_uploaded_file($tmp_name, $uploadphoto)) {
                        @img_resize($uploadphoto, $uploadthumb, $cfg['thumb_w'], $cfg['thumb_h'], $cfg['thumb_sqr']);
                        @img_resize($uploadphoto, $uploadthumb2, 1024, 768, false, $cfg['watermark']);
                        @unlink($uploadphoto);
                        if ($cfg['watermark']) {
                            @img_add_watermark($uploadthumb2);
                        }
                    } else {
                        $img_count--;
                    }

                }
            }
        }

        if ($img_count != $item['img_count']) {
            $this->inDB->query("UPDATE cms_shop_items SET img_count={$img_count} WHERE id={$item_id}");
        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function importItems($items, $category_id, $cfg)
    {

        $importResult = array('imported' => array(), 'updated' => array(), 'failed' => array());

        foreach ($items as $num => $item) {

            $item['art_no'] = ($item['art_no'] ? $item['art_no'] : '');

            if ($item['art_no'] && $cfg['update_items']) {
                $old = $this->inDB->get_fields('cms_shop_items', "art_no='{$item['art_no']}'", '*');
                if ($old) {
                    $item['id'] = $old['id'];
                }
            }

            if (isset($old)) {
                if (is_array($old)) {
                    $item = array_merge($old, $item);
                }
            }

            if (!$item['category_id']) {
                $item['category_id'] = $category_id;
            }

            if ($item['category']) {
                $item['category_id'] = $this->inDB->get_field('cms_shop_cats', "LOWER(title) = '" . mb_strtolower($item['category']) . "'", 'id');
            }

            $title = ($item['title'] ? $item['title'] : 'Товар #' . $num);

            if (!$item['category_id']) {
                $importResult['failed'][] = array('title' => $item['title']);
                continue;
            }

            if (isset($item['cats_titles'])) {
                foreach ($item['cats_titles'] as $cat_title) {
                    $cat_id = $this->inDB->get_field('cms_shop_cats', "LOWER(title) = '" . mb_strtolower($cat_title) . "'", 'id');
                    if ($cat_id) {
                        $item['cats'][] = $cat_id;
                    }
                }
            }

            if (!isset($item['cats'])) {
                $item['cats'] = array();
            }

            if ($item['vendor']) {
                $item['vendor_id'] = $this->inDB->get_field('cms_shop_vendors', "LOWER(title) = '" . mb_strtolower($item['vendor']) . "'", 'id');
            }

            $item['vendor_id'] = ($item['vendor_id'] ? $item['vendor_id'] : 0);

            $item['tpl'] = 'com_inshop_item.tpl';

            $item['shortdesc'] = ($item['shortdesc'] ? $item['shortdesc'] : '');
            $item['description'] = ($item['description'] ? $item['description'] : '');
            $item['metakeys'] = ($item['metakeys'] ? $item['metakeys'] : '');
            $item['metadesc'] = ($item['metadesc'] ? $item['metadesc'] : '');

            $item['is_comments'] = ($item['is_comments'] ? $item['is_comments'] : 0);
            $item['tags'] = ($item['tags'] ? $item['tags'] : '');

            $item['price'] = ($item['price'] ? $item['price'] : '');
            $item['old_price'] = ($item['old_price'] ? $item['old_price'] : '');

            $item['price'] = number_format(str_replace(',', '.', $item['price']), $cfg['show_decimals'], '.', '');
            $item['old_price'] = number_format(str_replace(',', '.', $item['old_price']), $cfg['show_decimals'], '.', '');
            ///////////
            $item['ves'] = ($item['ves'] ? $item['ves'] : '');
            $item['vol'] = ($item['vol'] ? $item['vol'] : '');

            $item['ves'] = number_format(str_replace(',', '.', $item['ves']), 2, '.', '');
            $item['vol'] = number_format(str_replace(',', '.', $item['vol']), 2, '.', '');


            $item['pubdate'] = date('Y-m-d H:i');

            $item['is_hit'] = ($item['is_hit'] ? $item['is_hit'] : 0);

            $item['is_spec'] = ($item['is_spec'] ? $item['is_spec'] : 0);

            $item['is_front'] = ($item['is_front'] ? $item['is_front'] : 0);
            $item['is_digital'] = ($item['is_digital'] ? $item['is_digital'] : 0);

            $item['qty'] = ($item['qty'] ? $item['qty'] : 0);

            $item['auto_thumb'] = 0;

            $item['published'] = ($cfg['hide_items'] ? 0 : 1);

            if (!$item['id']) {
                $item['title'] = $title;

                $item['id'] = $this->addItem($item);
                if ($item['id']) {
                    $importResult['imported'][] = array('id' => $item['id'], 'title' => $item['title']);
                } else {
                    $importResult['failed'][] = array('title' => $item['title']);
                }
            } else {
                $this->updateItem($item['id'], $item);
                $importResult['updated'][] = array('id' => $item['id'], 'title' => $item['title']);
            }


        }

        return ($importResult);

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function addItem($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_ITEM', $item);

        if (!in_array($item['category_id'], $item['cats'])) {
            $item['cats'][] = $item['category_id'];
        }

        $item['price'] = number_format($item['price'], 2, '.', '');
        $item['img_count'] = 0;

        if ($item['url']) {
            $item['url'] = cmsCore::strToURL($item['url']);
        }

        //Добавляем товар
        $sql = "INSERT INTO cms_shop_items (`category_id`, `vendor_id`, `art_no`, `title`, `shortdesc`, `description`,
                                            `metakeys`, `metadesc`, `ves`, `vol`, `price`, `old_price`, `published`, `pubdate`,
                                            `is_hit`, `is_front`, `is_digital`, `seolink`, `qty`, `img_count`,
                                            `filename`, `filesize`, `filedate`, `hits`, `tpl`, `url`, `kaspikz`, `is_spec`, `ven_code`)
				VALUES ('{$item['category_id']}', '{$item['vendor_id']}', '{$item['art_no']}', '{$item['title']}', '{$item['shortdesc']}', '{$item['description']}',
                        '{$item['metakeys']}', '{$item['metadesc']}', '{$item['ves']}', '{$item['vol']}', '{$item['price']}', '{$item['old_price']}', '{$item['published']}', '{$item['pubdate']}',
                        '{$item['is_hit']}', '{$item['is_front']}', '{$item['is_digital']}', '', '{$item['qty']}', '{$item['img_count']}',
                        '{$item['filename']}', '{$item['rels']}', NOW(), 0, '{$item['tpl']}', '{$item['url']}', '{$item['kaspikz']}', '{$item['is_spec']}', '{$item['ven_code']}')";

        $this->inDB->query($sql);

        $item['id'] = $this->inDB->get_last_id('cms_shop_items');

        //закачиваем файл цифрового товара и фотографии
        $this->uploadItemFiles($item['id'], $item['auto_thumb'], $item['is_digital']);

        //Генерим SEO-урл (slug)
        $item['seolink'] = $this->getSeoLink($item);
        $this->inDB->query("UPDATE cms_shop_items SET seolink='{$item['seolink']}' WHERE id = {$item['id']}");

        //вставляем теги
        cmsInsertTags($item['tags'], 'shop', $item['id']);

        //сохраняем варианты
        $this->saveItemVars($item);

        //сохраняем категории
        $this->saveItemCategories($item);

        //сохраняем характеристики
        $this->saveItemChars($item);

        return $item['id'];

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function addItemSin($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_ITEM', $item);

        if (!in_array($item['category_id'], $item['cats'])) {
            $item['cats'][] = $item['category_id'];
        }

        $item['price'] = number_format($item['price'], 2, '.', '');
        $item['img_count'] = 0;

        if ($item['url']) {
            $item['url'] = cmsCore::strToURL($item['url']);
        }

        //Добавляем товар
        $sql = "INSERT INTO cms_shop_items (`category_id`, `art_no`, `title`, `shortdesc`, `description`,
                                            `metakeys`, `metadesc`, `ves`, `vol`, `price`, `old_price`, `published`, `pubdate`,
                                            `is_hit`, `is_front`, `is_digital`, `seolink`, `qty`, `img_count`,
                                            `filename`, `filedate`, `hits`, `tpl`, `url`, `kaspikz`, `is_spec`, `ven_code`)
				VALUES ('{$item['category_id']}', '{$item['art_no']}', '{$item['title']}', '{$item['shortdesc']}', '{$item['description']}',
                        '{$item['metakeys']}', '{$item['metadesc']}', '{$item['ves']}', '{$item['vol']}', '{$item['price']}', '{$item['old_price']}', '{$item['published']}', '{$item['pubdate']}',
                        '{$item['is_hit']}', '{$item['is_front']}', '{$item['is_digital']}', '', '{$item['qty']}', '{$item['img_count']}',
                        '{$item['filename']}', NOW(), 0, '{$item['tpl']}', '{$item['url']}', '{$item['kaspikz']}', '{$item['is_spec']}', '{$item['ven_code']}')";

        $this->inDB->query($sql);

        $item['id'] = $this->inDB->get_last_id('cms_shop_items');

        //закачиваем файл цифрового товара и фотографии
        $this->uploadItemFiles($item['id'], $item['auto_thumb'], $item['is_digital']);

        //Генерим SEO-урл (slug)
        $item['seolink'] = $this->getSeoLink($item);
        $this->inDB->query("UPDATE cms_shop_items SET seolink='{$item['seolink']}' WHERE id = {$item['id']}");

        //вставляем теги
        cmsInsertTags($item['tags'], 'shop', $item['id']);

        //сохраняем варианты
        $this->saveItemVars($item);

        //сохраняем категории
        //$this->saveItemCategories($item);

        //сохраняем характеристики
        //$this->saveItemChars($item);

        return $item['id'];

    }


    /* ========================================================================== */
    /* ========================================================================== */

    public function updateItem($id, $item)
    {

        $item = cmsCore::callEvent('UPDATE_SHOP_ITEM', $item);

        $item['price'] = number_format($item['price'], 2, '.', '');

        $item['id'] = $id;

        //Генерим SEO-урл (slug)
        if ($item['url']) {
            $item['url'] = cmsCore::strToURL($item['url']);
        }
        $item['seolink'] = $this->getSeoLink($item);

        if (!in_array($item['category_id'], $item['cats'])) {
            $item['cats'][] = $item['category_id'];
        }

        //закачиваем файл цифрового товара и фотографии
        $this->uploadItemFiles($id, $item['auto_thumb'], $item['is_digital']);

        //удаляем ненужные фотографии
        if (is_array($item['img_delete'])) {
            $this->dropItemImages($item['img_delete']);
        }

        //обновляем запись
        $sql = "UPDATE cms_shop_items
                SET category_id='{$item['category_id']}',
                    vendor_id='{$item['vendor_id']}',
                    art_no='{$item['art_no']}',
                    title='{$item['title']}',
                    shortdesc='{$item['shortdesc']}',
                    description='{$item['description']}',
                    metakeys='{$item['metakeys']}',
                    metadesc='{$item['metadesc']}',
                    ves='{$item['ves']}',
                    vol='{$item['vol']}',					
                    price='{$item['price']}',
                    old_price='{$item['old_price']}',
                    published='{$item['published']}',
                    pubdate='{$item['pubdate']}',
                    is_hit='{$item['is_hit']}',
                    is_front='{$item['is_front']}',
                    is_digital='{$item['is_digital']}',
                    seolink='{$item['seolink']}',
                    qty='{$item['qty']}',
					filesize='{$item['rels']}',
                    tpl='{$item['tpl']}',
                    url='{$item['url']}',
					kaspikz='{$item['kaspikz']}',
					is_spec='{$item['is_spec']}',
					ven_code='{$item['ven_code']}'
                WHERE id = $id
                LIMIT 1";

        $this->inDB->query($sql);

        cmsInsertTags($item['tags'], 'shop', $id);

        //сохраняем варианты
        $this->saveItemVars($item);

        //сохраняем категории
        $this->saveItemCategories($item);

        //сохраняем характеристики
        $this->saveItemChars($item);

        return true;

    }
    
    



    /* ========================================================================== */
    /* ========================================================================== */
    // для регулярной синхры, без названия
    public function updateItemSin($id, $item)
    {

        $item = cmsCore::callEvent('UPDATE_SHOP_ITEM', $item);

        $item['price'] = number_format($item['price'], 2, '.', '');

        $item['id'] = $id;

        //Генерим SEO-урл (slug)
        if ($item['url']) {
            $item['url'] = cmsCore::strToURL($item['url']);
        }
        $item['seolink'] = $this->getSeoLink($item);

        if (!in_array($item['category_id'], $item['cats'])) {
            $item['cats'][] = $item['category_id'];
        }

        //закачиваем файл цифрового товара и фотографии
        //$this->uploadItemFiles($id, $item['auto_thumb'], $item['is_digital']);

        //удаляем ненужные фотографии
        //if (is_array($item['img_delete'])){
        //    $this->dropItemImages($item['img_delete']);
        //}

        //обновляем запись
        $sql = "UPDATE cms_shop_items
                SET category_id='{$item['category_id']}',
                    art_no='{$item['art_no']}',
                    seolink='{$item['seolink']}',
                    qty='{$item['qty']}',
                    tpl='{$item['tpl']}',
                    url='{$item['url']}'
                WHERE id = $id
                LIMIT 1";

        $this->inDB->query($sql);

        //cmsInsertTags($item['tags'], 'shop', $id);

        //сохраняем варианты
        $this->saveItemVars($item);

        //сохраняем категории
        //$this->saveItemCategories($item);

        //сохраняем характеристики
        //$this->saveItemChars($item);

        return true;

    }

    // для выгрузки нолвых товаров с названием
    public function updateItemSinn($id, $item)
    {

        $item = cmsCore::callEvent('UPDATE_SHOP_ITEM', $item);

        $item['price'] = number_format($item['price'], 2, '.', '');

        $item['id'] = $id;

        //Генерим SEO-урл (slug)
        if ($item['url']) {
            $item['url'] = cmsCore::strToURL($item['url']);
        }
        $item['seolink'] = $this->getSeoLink($item);

        if (!in_array($item['category_id'], $item['cats'])) {
            $item['cats'][] = $item['category_id'];
        }

        //закачиваем файл цифрового товара и фотографии
        $this->uploadItemFiles($id, $item['auto_thumb'], $item['is_digital']);

        //удаляем ненужные фотографии
        if (is_array($item['img_delete'])) {
            $this->dropItemImages($item['img_delete']);
        }

        //обновляем запись
        $sql = "UPDATE cms_shop_items
                SET category_id='{$item['category_id']}',
                    art_no='{$item['art_no']}',
                    title='{$item['title']}',
                    seolink='{$item['seolink']}',
                    qty='{$item['qty']}',
                    tpl='{$item['tpl']}',
                    url='{$item['url']}'
                WHERE id = $id
                LIMIT 1";

        $this->inDB->query($sql);

        cmsInsertTags($item['tags'], 'shop', $id);

        //сохраняем варианты
        $this->saveItemVars($item);

        //сохраняем категории
        //$this->saveItemCategories($item);

        //сохраняем характеристики
        //$this->saveItemChars($item);

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function updatePrices($cat_id, $value, $sign, $is_percent = 1, $is_recursive = 0, $is_round = 1)
    {

        if (!$is_percent) {
            $value = number_format($value, 2, '.', '');
        }

        $inc = $is_percent ? "({$value} * price)/100" : $value;
        $inc = $is_round ? "ROUND({$inc}, 0)" : $inc;
        $sign = $sign > 0 ? '+' : '-';

        if ($cat_id) {
            if ($is_recursive) {
                $this->whereRecursiveCatIs($cat_id);
            } else {
                $this->whereCatIs($cat_id);
            }
        }

        $this->groupBy('i.id');
        $items = $this->getItems();

        if (!$items) {
            return false;
        }

        foreach ($items as $item) {

            $sql = "UPDATE cms_shop_items
                       SET price = price {$sign} {$inc}
                       WHERE id = {$item['id']}";
            $this->inDB->query($sql);

            $sql = "UPDATE cms_shop_items_bind
                       SET price = price {$sign} {$inc}
                       WHERE item_id = {$item['id']}";
            $this->inDB->query($sql);

        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getSeoLink($item)
    {

        $seolink = '';

        $category = $this->inDB->get_fields('cms_shop_cats', "id={$item['category_id']}", 'NSLeft, NSRight');

        $left_key = $category['NSLeft'];
        $right_key = $category['NSRight'];

        $path_list = $this->getCategoryPath($left_key, $right_key);

        if ($path_list) {
            foreach ($path_list as $pcat) {
                if ($pcat['id'] != 1) {
                    $seolink .= cmsCore::strToURL(($pcat['url'] ? $pcat['url'] : $pcat['title'])) . '/';
                }
            }
        }

        $seolink .= cmsCore::strToURL(($item['url'] ? $item['url'] : trim($item['title'])));

        if ($item['id']) {
            $where = ' AND id<>' . $item['id'];
        } else {
            $where = '';
        }

        $is_exists = $this->inDB->rows_count('cms_shop_items', "seolink='{$seolink}'" . $where, 1);

        if ($is_exists) {
            $seolink .= '-' . $item['id'];
        }

        return $seolink;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteChar($id)
    {

        cmsCore::callEvent('DELETE_SHOP_CHAR', $id);

        $this->inDB->query("DELETE FROM cms_shop_chars WHERE id = $id LIMIT 1");
        $this->inDB->query('DELETE FROM cms_shop_chars_bind WHERE char_id=' . $id);
        $this->inDB->query('DELETE FROM cms_shop_chars_val WHERE char_id=' . $id);

        $this->reorder('cms_shop_chars_bind', 'cat_id', 'char_id');

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteCharGroup($group)
    {

        cmsCore::callEvent('DELETE_SHOP_CHAR_GROUP', $group);

        $chars = $this->getChars(false, $group);

        if (!$chars) {
            return false;
        }

        foreach ($chars as $char) {
            $this->deleteChar($char['id']);
        }

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function renameCharGroup($old_name, $new_name)
    {

        cmsCore::callEvent('RENAME_SHOP_CHAR_GROUP', $old_name);

        $this->inDB->query("UPDATE cms_shop_chars SET fieldgroup='{$new_name}' WHERE fieldgroup='{$old_name}'");
        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function updateChar($id, $item)
    {

        $item = cmsCore::callEvent('UPDATE_SHOP_CHAR', $item);

        $item['units'] = $item['units'] ? "'{$item['units']}'" : 'NULL';

        $sql = "UPDATE cms_shop_chars
                SET title = '{$item['title']}',
                    published = '{$item['published']}',
                    fieldtype = '{$item['fieldtype']}',
                    fieldgroup = '{$item['fieldgroup']}',
                    is_compare = '{$item['is_compare']}',
                    is_filter = '{$item['is_filter']}',
                    `values` = '{$item['values']}',
                    bind_all = '{$item['bind_all']}',
                    is_filter_many = '{$item['is_filter_many']}',
                    is_custom = '{$item['is_custom']}',
                    units = {$item['units']}
                WHERE id = $id
                LIMIT 1";
        $this->inDB->query($sql);

        //получаем текущие значения порядка (ordering)
        $current_ord = array();
        $sql = "SELECT cat_id, ordering FROM cms_shop_chars_bind WHERE char_id={$id}";
        $result = $this->inDB->query($sql);
        if ($this->inDB->num_rows($result)) {
            while ($row = $this->inDB->fetch_assoc($result)) {
                print_r($row);
                $current_ord[$row['cat_id']] = $row['ordering'];
            }
        }

        $this->inDB->query('DELETE FROM cms_shop_chars_bind WHERE char_id=' . $id);

        echo '<pre>';
        print_r($current_ord);
        echo '</pre>';

        if (is_array($item['cats']) && !$item['bind_all']) {
            foreach ($item['cats'] as $cat_id) {
                $ordering = isset($current_ord[$cat_id]) ? //если товар уже был в этой категории
                    $current_ord[$cat_id] : //то берем его текущее положение
                    $this->inDB->get_field('cms_shop_chars_bind', "cat_id={$cat_id}", 'MAX(ordering)') + 1; //иначе он занимает последнее место
                $this->inDB->query("INSERT INTO cms_shop_chars_bind (char_id, cat_id, ordering) VALUES ({$id}, {$cat_id}, {$ordering})");
            }
        }

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function addChar($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_CHAR', $item);

        $item['units'] = $item['units'] ? "'{$item['units']}'" : 'NULL';

        $sql = "INSERT INTO cms_shop_chars (published, title, fieldtype, fieldgroup, is_compare, is_filter, `values`, bind_all, is_filter_many, is_custom, units)
				VALUES ('{$item['published']}', '{$item['title']}', '{$item['fieldtype']}', '{$item['fieldgroup']}',
                        '{$item['is_compare']}', '{$item['is_filter']}', '{$item['values']}', '{$item['bind_all']}',
                        '{$item['is_filter_many']}', '{$item['is_custom']}', {$item['units']})";

        $this->inDB->query($sql);

        $char_id = $this->inDB->get_last_id('cms_shop_chars');

        if (is_array($item['cats']) && !$item['bind_all']) {

            foreach ($item['cats'] as $cat_id) {
                $ordering = $this->inDB->get_field('cms_shop_chars_bind', "cat_id={$cat_id}", 'MAX(ordering)') + 1;
                $this->inDB->query("INSERT INTO cms_shop_chars_bind (char_id, cat_id, ordering) VALUES ({$char_id}, {$cat_id}, {$ordering})");
            }

        }

        return $char_id;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function bindCharGroup($char_group_id, $cat_id)
    {

        $chars = $this->getChars(false, $char_group_id);

        if (!$chars) {
            return false;
        }

        foreach ($chars as $char) {
            $this->bindChar($char['id'], $cat_id);
        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function bindChar($char_id, $cat_id)
    {

        $exists = $this->inDB->rows_count('cms_shop_chars_bind', "cat_id={$cat_id} AND char_id={$char_id}");

        if ($exists) {
            return false;
        }

        $ordering = $this->inDB->get_field('cms_shop_chars_bind', "cat_id={$cat_id}", 'MAX(ordering)') + 1;
        $this->inDB->query("INSERT INTO cms_shop_chars_bind (char_id, cat_id, ordering) VALUES ({$char_id}, {$cat_id}, {$ordering})");

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function unbindChar($char_id, $cat_id)
    {

        if ($cat_id) {

            $this->inDB->query("DELETE FROM cms_shop_chars_bind WHERE cat_id={$cat_id} AND char_id={$char_id}");
            $this->reorder('cms_shop_chars_bind', 'cat_id', 'char_id');

        } else {

            $this->setCharFlag($char_id, 'bind_all', 0);

        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function unbindChars($cat_id)
    {

        if ($cat_id) {
            $this->inDB->query("DELETE FROM cms_shop_chars_bind WHERE cat_id={$cat_id}");
        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function saveCharValues($char_id, $vals)
    {

        if (!$char_id || !is_array($vals)) {
            return false;
        }

        foreach ($vals as $item_id => $value) {
            $this->inDB->query("UPDATE cms_shop_chars_val SET val='{$value}' WHERE char_id={$char_id} AND item_id={$item_id}");
        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getChars($only_published = true, $group = '', $only_compare = false)
    {

        $chars = array();
        $pub_where = $only_published ? 'published=1' : '1=1';
        $grp_where = $group ? " AND fieldgroup='{$group}'" : '';
        $cmp_where = $only_compare ? " AND is_compare=1" : '';

        $sql = "SELECT *
                 FROM cms_shop_chars
                 WHERE {$pub_where} {$grp_where}
                 ORDER BY fieldgroup ASC, title
                 ";

        $res = $this->inDB->query($sql) or die(mysqli_error());

        if ($this->inDB->num_rows($res)) {
            while ($char = $this->inDB->fetch_assoc($res)) {
                $chars[$char['id']] = $char;
            }
        }

        return $chars;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCharGroups()
    {

        $groups = array();

        $sql = "SELECT fieldgroup as title
                 FROM cms_shop_chars
                 WHERE fieldgroup <> ''
                 GROUP BY fieldgroup";

        $res = $this->inDB->query($sql);

        if ($this->inDB->num_rows($res)) {
            while ($group = $this->inDB->fetch_assoc($res)) {
                $groups[] = $group['title'];
            }
        }

        return $groups;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCharItems($char_id)
    {

        $items = array();

        $sql = "SELECT i.id as id,
                        i.title as title,
                        cat.title as category,
                        v.val as val
                 FROM cms_shop_items i,
                      cms_shop_cats cat,
                      cms_shop_chars_val v
                 WHERE v.char_id = {$char_id} AND v.item_id = i.id AND i.category_id = cat.id";

        $res = $this->inDB->query($sql) or die(mysqli_error());

        if ($this->inDB->num_rows($res)) {
            while ($item = $this->inDB->fetch_assoc($res)) {
                $items[] = $item;
            }
        }

        return $items;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCharValuesCount($char_id)
    {

        return $this->inDB->rows_count('cms_shop_chars_val', "char_id={$char_id}");

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function reorder($table, $cat_field, $item_field)
    {

        $sql = "SELECT {$cat_field} FROM {$table} GROUP BY {$cat_field}";
        $res = $this->inDB->query($sql);

        while ($r = $this->inDB->fetch_assoc($res)) {

            $ord = 1;

            $sql2 = "SELECT {$item_field}
                     FROM {$table}
                     WHERE {$cat_field} = {$r[$cat_field]}
                     ORDER BY ordering";

            $res2 = $this->inDB->query($sql2);

            while ($r2 = $this->inDB->fetch_assoc($res2)) {
                $this->inDB->query("UPDATE {$table} SET ordering = {$ord} WHERE {$item_field}={$r2[$item_field]} AND {$cat_field}={$r[$cat_field]}");
                $ord++;
            }

        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteVendor($id)
    {
        cmsCore::callEvent('DELETE_SHOP_VENDOR', $id);
        $this->inDB->query("DELETE FROM cms_shop_vendors WHERE id = $id LIMIT 1");
        $this->inDB->query('UPDATE cms_shop_items SET vendor_id=0 WHERE vendor_id=' . $id);
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function updateVendor($id, $item)
    {
        $item = cmsCore::callEvent('UPDATE_SHOP_VENDOR', $item);
        $sql = "UPDATE cms_shop_vendors
                SET title = '{$item['title']}',
					descr = '{$item['descr']}',
                    published = '{$item['published']}'
                WHERE id = $id
                LIMIT 1";
        $this->inDB->query($sql);
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addVendor($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_VENDOR', $item);

        $sql = "INSERT INTO cms_shop_vendors (title, descr, published)
				VALUES ('{$item['title']}', '{$item['descr']}', '{$item['published']}')";

        $this->inDB->query($sql);

        $vendor_id = $this->inDB->get_last_id('cms_shop_vendors');

        return $vendor_id;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteDelivery($id)
    {
        cmsCore::callEvent('DELETE_SHOP_DELIVERY', $id);
        $this->inDB->query("DELETE FROM cms_shop_delivery WHERE id = $id LIMIT 1");
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function updateDelivery($id, $item)
    {
        $item = cmsCore::callEvent('UPDATE_SHOP_DELIVERY', $item);
        $sql = "UPDATE cms_shop_delivery
                SET title = '{$item['title']}',
                    description = '{$item['description']}',
                    published = '{$item['published']}',
                    minsumm = '{$item['minsumm']}',
                    freesumm = '{$item['freesumm']}',
                    price = '{$item['price']}',
                    nofree = '{$item['nofree']}'
                WHERE id = $id
                LIMIT 1";
        $this->inDB->query($sql);
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addDelivery($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_DELIVERY', $item);

        $sql = "INSERT INTO cms_shop_delivery (title, description, published, minsumm, freesumm, price, nofree)
				VALUES ('{$item['title']}', '{$item['description']}', '{$item['published']}', '{$item['minsumm']}', '{$item['freesumm']}', '{$item['price']}', '{$item['nofree']}')";

        $this->inDB->query($sql);

        $delivery_id = $this->inDB->get_last_id('cms_shop_delivery');

        return $delivery_id;

    }

///* ==================================================================================================== */
///* ==================================================================================================== */

    public function deleteCategory($id)
    {

        $inCore = cmsCore::getInstance();
        cmsCore::callEvent('DELETE_SHOP_CAT', $id);

        $cat = $this->getCategory($id);

        $sql = "SELECT  i.id as id, i.title as title
				FROM    cms_shop_items i
				JOIN cms_shop_cats cat ON cat.id = i.category_id AND
                                          cat.NSLeft >= {$cat['NSLeft']} AND
                                          cat.NSRight <= {$cat['NSRight']}
				";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($item = $this->inDB->fetch_assoc($result)) {
                $this->deleteItem($item['id']);
            }
        }

        $ns = $inCore->nestedSetsInit('cms_shop_cats');
        $ns->DeleteNode($id);

        $this->inDB->query('DELETE FROM cms_shop_chars_bind WHERE cat_id=' . $id);
        $this->inDB->query('DELETE FROM cms_shop_items_cats WHERE category_id=' . $id);

        return true;
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function updateCategory($id, $cat)
    {

        $inCore = cmsCore::getInstance();

        $cat = cmsCore::callEvent('UPDATE_SHOP_CAT', $cat);

        if ($cat['old_parent_id'] != $cat['parent_id']) {
            $ns = $inCore->nestedSetsInit('cms_shop_cats');
            $ns->MoveNode($id, $cat['parent_id']);
        }

        $cat['id'] = $id;

        if (!$inCore->request('del_icon', 'int', 0)) {
            $cat['config'] = $inCore->yamlToArray($this->inDB->get_field('cms_shop_cats', "id={$id}", 'config'));
            $cat = $this->uploadCategoryIcon($cat);
        } else {
            $cat['config']['icon'] = 'shop_category.png';
        }

        $cat['config'] = ($cat['config'] ? $inCore->arrayToYaml($cat['config']) : '');

        if ($cat['url']) {
            $cat['url'] = cmsCore::strToURL($cat['url']);
        }
        $cat['seolink'] = $this->getCategorySeoLink($cat);

        $sql = "UPDATE cms_shop_cats
                SET parent_id       = '{$cat['parent_id']}',
                    title           = '{$cat['title']}',
                    description     = '{$cat['description']}',
                    seolink         = '{$cat['seolink']}',
                    published       = '{$cat['published']}',
                    config          = '{$cat['config']}',
                    tpl             = '{$cat['tpl']}',
                    url             = '{$cat['url']}',
                    is_catalog      = '{$cat['is_catalog']}',
					meta_desc      = '{$cat['meta_desc']}',
					meta_keys      = '{$cat['meta_keys']}',
					pagetitle      = '{$cat['pagetitle']}',
					is_xml      = '{$cat['is_xml']}'
                WHERE id = {$id}
                LIMIT 1";

        $this->inDB->query($sql);


        //Обновляем пути всех вложенных категорий

        $keys = $this->inDB->get_fields('cms_shop_cats', "id={$cat['id']}", 'NSLeft, NSRight');
        $left_key = $keys['NSLeft'] + 1;
        $right_key = $keys['NSRight'] + 1;
        $sql = "SELECT * FROM cms_shop_cats WHERE NSLeft >= $left_key AND NSRight <= $right_key AND parent_id > 0";
        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($subcat = $this->inDB->fetch_assoc($result)) {
                $subcat_seolink = $this->getCategorySeoLink($subcat);
                $this->inDB->query("UPDATE cms_shop_cats SET seolink='{$subcat_seolink}' WHERE id={$subcat['id']}");
            }
        }

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCategories($only_published = true, $parent_id = 0)
    {

        $cats = array();
        $pub_where = $only_published ? 'AND published=1' : '';

        if (!$parent_id) {
            $parent_where = 'parent_id > 0';
        }

        if ($parent_id) {
            $parent = $this->inDB->get_fields('cms_shop_cats', "id={$parent_id}", 'NSLeft, NSRight');
            $parent_where = "NSLeft > {$parent['NSLeft']} AND NSRight < {$parent['NSRight']}";
        }

        $sql = "SELECT *
                 FROM cms_shop_cats
                 WHERE {$parent_where} {$pub_where}
                 ORDER BY NSLeft";

        $res = $this->inDB->query($sql);

        if ($this->inDB->num_rows($res)) {
            while ($cat = $this->inDB->fetch_assoc($res)) {
                $cats[] = $cat;
            }
        }

        return $cats;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getVendors($only_published = true)
    {

        $vendors = array();
        $pub_where = $only_published ? 'v.published=1' : '1=1';

        $sql = "SELECT v.*,
                        IFNULL(COUNT(i.id), 0) as items_count
                 FROM cms_shop_vendors v
                 LEFT JOIN cms_shop_items i ON i.vendor_id = v.id AND i.published = 1
                 WHERE $pub_where
                 GROUP BY v.id
                 ORDER BY v.title
                 ";

        $res = $this->inDB->query($sql) or die(mysqli_error());

        if ($this->inDB->num_rows($res)) {
            while ($vendor = $this->inDB->fetch_assoc($res)) {
                $vendors[$vendor['id']] = $vendor;
            }
        }

        return $vendors;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getVendor($id, $published = 1)
    {
        return $this->inDB->get_fields('cms_shop_vendors', "id={$id} AND published={$published}", '*');
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCategory($id)
    {
        return $this->inDB->get_fields('cms_shop_cats', "id={$id}", '*');
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCategoryByLink($seolink)
    {
        return $this->inDB->get_fields('cms_shop_cats', "seolink='{$seolink}'", '*');
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getRootCategory()
    {
        $root_id = $this->inDB->get_field('cms_shop_cats', "parent_id=0", 'id');
        return $this->getCategory($root_id);
    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function uploadCategoryIcon($cat)
    {

        $inCore = cmsCore::getInstance();

        if (isset($_FILES["icon"]["name"]) && @$_FILES["icon"]["name"] != '') {

            $tmp_name = $_FILES["icon"]["tmp_name"];
            $path_parts = pathinfo($_FILES['icon']['name']);
            $file = 'shop_category' . $cat['id'] . '.' . $path_parts['extension'];
            $target_file = PATH . '/images/photos/small/' . $file;

            if (@move_uploaded_file($tmp_name, $target_file)) {
                $cat['config']['icon'] = $file;
            } else {
                $cat['config']['icon'] = 'shop_category.png';
            }

        }

        return $cat;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addCategory($cat)
    {

        $inCore = cmsCore::getInstance();
        $cat = cmsCore::callEvent('ADD_SHOP_CAT', $cat);

        $ns = $inCore->nestedSetsInit('cms_shop_cats');
        $cat['id'] = $ns->AddNode($cat['parent_id']);

        $cat = $this->uploadCategoryIcon($cat);

        $cat['config'] = ($cat['config'] ? $inCore->arrayToYaml($cat['config']) : '');

        if ($cat['url']) {
            $cat['url'] = cmsCore::strToURL($cat['url']);
        }
        $cat['seolink'] = $this->getCategorySeoLink($cat);

        $sql = "UPDATE cms_shop_cats
                SET parent_id       = '{$cat['parent_id']}',
                    title           = '{$cat['title']}',
                    description     = '{$cat['description']}',
                    seolink         = '{$cat['seolink']}',
                    published       = '{$cat['published']}',
                    config          = '{$cat['config']}',
                    tpl             = '{$cat['tpl']}',
                    url             = '{$cat['url']}',
                    is_catalog      = '{$cat['is_catalog']}',
					meta_desc      = '{$cat['meta_desc']}',
					meta_keys      = '{$cat['meta_keys']}',
					pagetitle      = '{$cat['pagetitle']}',
					is_xml         = '{$cat['is_xml']}'
                WHERE id = {$cat['id']}
                LIMIT 1";
        $this->inDB->query($sql);

        return $cat['id'];

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCategorySeoLink($category)
    {

        $seolink = '';

        //Строим путь к категории
        $keys = $this->inDB->get_fields('cms_shop_cats', "id={$category['id']}", 'NSLeft, NSRight');

        $left_key = $keys['NSLeft'] + 1;
        $right_key = $keys['NSRight'] + 1;

        $path_list = $this->getCategoryPath($left_key, $right_key);

        if ($path_list) {
            foreach ($path_list as $pcat) {
                if ($pcat['id'] != 1) {
                    $seolink .= cmsCore::strToURL(($pcat['url'] ? $pcat['url'] : $pcat['title'])) . '/';
                }
            }
        }

        $seolink .= cmsCore::strToURL(($category['url'] ? $category['url'] : trim($category['title'])));

        //Обновляем пути всех товаров этой категории

        $sql = "SELECT  i.id as id, i.title as title, i.url as url, i.category_id as category_id
				FROM    cms_shop_items i
				JOIN cms_shop_cats cat ON cat.id        =  i.category_id AND
                                          cat.NSLeft    >= {$keys['NSLeft']} AND
                                          cat.NSRight   <= {$keys['NSRight']}
				";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($item = $this->inDB->fetch_assoc($result)) {
                $item_seolink = $seolink . '/' . ($item['url'] ? $item['url'] : cmsCore::strToURL(trim($item['title'])));
                $this->inDB->query("UPDATE cms_shop_items SET seolink='{$item_seolink}' WHERE id={$item['id']}");
            }
        }

        return $seolink;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCategoryPath($left_key, $right_key)
    {

        $path = array();

        $sql = "SELECT id, title, NSLevel, seolink, url
                FROM cms_shop_cats
                WHERE NSLeft <= $left_key AND NSRight >= $right_key AND parent_id > 0
                ORDER BY NSLeft";

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($cat = $this->inDB->fetch_assoc($result)) {
            $path[] = $cat;
        }

        return $path;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getSubCats($parent_id, $recurse = true, $limit = 0)
    {

        $inCore = cmsCore::getInstance();

        $cfg = $this->getConfig();

        $subcats = array();

        $sql = "SELECT cat.*, IFNULL(COUNT(con.id), 0) as content_count
                FROM cms_shop_cats cat
                LEFT JOIN cms_shop_items con ON con.category_id = cat.id AND con.published = 1
                WHERE (cat.parent_id=$parent_id) AND cat.published = 1
                GROUP BY cat.id\n
                ORDER BY {$cfg['subcats_order']}";

        if ($limit) {
            $sql .= "LIMIT $limit";
        }

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($subcat = $this->inDB->fetch_assoc($result)) {

            $count_sql = "SELECT con.id
                          FROM cms_shop_items con, cms_shop_cats cat
                          WHERE con.category_id = cat.id AND (cat.NSLeft >= {$subcat['NSLeft']} AND cat.NSRight <= {$subcat['NSRight']}) AND con.published = 1";

            $count_result = $this->inDB->query($count_sql);

            $subcat['content_count'] = $this->inDB->num_rows($count_result);

            $subcat['config'] = $inCore->yamlToArray($subcat['config']);
            if (!$subcat['config']['icon']) {
                $subcat['config']['icon'] = 'shop_category.png';
            }

            if ($recurse) {
                $subcat['subcats'] = $this->getSubCats($subcat['id'], false);
            }

            $subcats[] = $subcat;

        }

        $subcats = cmsCore::callEvent('GET_SHOP_SUBCATS', $subcats);

        return $subcats;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addToCart($item_id, $var_art_no = '', $qty = 1, $chars = false)
    {

        $session_id = session_id();
        $var_art_no = $var_art_no ? $var_art_no : '';

        $chars_hash = is_array($chars) ? "'" . md5(serialize($chars)) . "'" : 'NULL';

        $exists_id = $this->inDB->get_field('cms_shop_cart', "session_id='{$session_id}' AND item_id='{$item_id}' AND var_art_no='{$var_art_no}' AND chars_hash = $chars_hash", 'id');

        if (!$exists_id) {

            $chars_info = array();

            if ($chars) {

                foreach ($chars as $id => $value) {
                    $chars_ids[] = $id;
                }
                $chars_ids = implode(',', $chars_ids);

                $sql = "SELECT id, title FROM cms_shop_chars WHERE id IN ({$chars_ids})";
                $result = $this->inDB->query($sql);

                if ($this->inDB->num_rows($result)) {
                    while ($c = $this->inDB->fetch_assoc($result)) {
                        $chars_info[$c['id']] = $c['title'] . ': ' . $chars[$c['id']];
                    }
                    $chars_info = $this->inDB->escape_string(implode(', ', $chars_info));
                }

            }

            $chars_info = $chars_info ? "'{$chars_info}'" : 'NULL';

            $sql = "INSERT INTO cms_shop_cart (`session_id`, `item_id`, `var_art_no`, `qty`, `pubdate`, `chars`, `chars_hash`)
                    VALUES ('{$session_id}', '{$item_id}', '{$var_art_no}', '{$qty}', NOW(), {$chars_info}, {$chars_hash})";

        } else {

            $qty = intval($qty);

            $sql = "UPDATE cms_shop_cart SET qty = qty + {$qty} WHERE id = {$exists_id} LIMIT 1";

        }

        $this->inDB->query($sql);

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function saveCart($qty)
    {

        if (!is_array($qty)) {
            return false;
        }

        foreach ($qty as $cart_id => $num) {
            $this->inDB->query("UPDATE cms_shop_cart SET qty = {$num} WHERE id={$cart_id}");
        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function clearCart($session_id)
    {

        $this->inDB->query("DELETE FROM cms_shop_cart WHERE session_id='{$session_id}'");
        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function clearAllCarts()
    {

        $this->inDB->query("DELETE FROM cms_shop_cart");
        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function clearAllOrders()
    {

        $inUser = cmsUser::getInstance();

        if (!$inUser->is_admin) {
            return false;
        }

        $this->inDB->query("DELETE FROM cms_shop_orders");
        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function clearCompare()
    {

        $this->inDB->query("DELETE FROM cms_shop_compare");
        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function isItemInCart($item_id, $var_art_no = '')
    {

        $session_id = session_id();

        $where = "session_id='{$session_id}' AND item_id='{$item_id}'";

        if ($var_art_no) {
            $where .= " AND var_art_no='{$var_art_no}'";
        }

        $exists_id = $this->inDB->get_field('cms_shop_cart', $where, 'id');

        return $exists_id;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteFromCart($cart_item_id)
    {

        $this->inDB->query("DELETE FROM cms_shop_cart WHERE id = '{$cart_item_id}' LIMIT 1");

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getCartItems($cfg)
    {

        $session_id = session_id();
        $items = array();

        $base_sql = "SELECT   items.title as title,
                                items.price as price,
                                items.old_price as old_price,
								items.opt as opt, 
                                items.art_no as art_no,
                                items.seolink as seolink,
                                items.qty as qty,
                                cart.qty as cart_qty,
                                cart.item_id as item_id,
                                cart.id as cart_id,
                                cart.chars as chars,
                                items.is_digital as is_digital,
                                items.filename as filename_item,
                                items.filename_orig as filename_orig,
                                items.category_id as category_id

                        FROM    cms_shop_cart cart, cms_shop_items items

                        WHERE   cart.session_id = '{$session_id}' AND
                                (cart.var_art_no = '' OR cart.var_art_no = '0') AND
                                cart.item_id = items.id";

        $vars_sql = "SELECT   vars.title as var_title,
                                items.title as title,
                                vars.price as price,
                                items.price as parent_price,
                                items.old_price as old_price,
                                vars.art_no as art_no,
                                items.seolink as seolink,
                                vars.qty as qty,
                                cart.qty as cart_qty,
                                cart.item_id as item_id,
                                cart.id as cart_id,
                                cart.chars as chars,
                                items.is_digital as is_digital,
                                items.filename as filename_item,
                                items.filename_orig as filename_orig,
                                items.category_id as category_id

                        FROM    cms_shop_cart cart, cms_shop_items items, cms_shop_items_bind vars

                        WHERE   cart.session_id = '{$session_id}' AND
                                cart.var_art_no = vars.art_no AND
                                vars.item_id = items.id AND
                                cart.item_id = items.id";

        $base_result = $this->inDB->query($base_sql);
        $vars_result = $this->inDB->query($vars_sql);

        if (!$this->inDB->num_rows($base_result) && !$this->inDB->num_rows($vars_result)) {
            return false;
        }

        if ($this->inDB->num_rows($base_result)) {
            while ($item = $this->inDB->fetch_assoc($base_result)) {

                $deltas = $this->getPriceDiscounts($item['category_id']);

                // если были скидки, применяем дельты
                if ($deltas['prc'] || $deltas['abs']) {
                    $item['price'] = $this->calculatePrice($item['price'], $deltas['abs'], $deltas['prc']);
                }

                $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $item['item_id'] . '.jpg')) ? 'shop' . $item['item_id'] . '.jpg' : 'shop_default.jpg';
                $items[] = $item;
            }
        }

        if ($this->inDB->num_rows($vars_result)) {
            while ($item = $this->inDB->fetch_assoc($vars_result)) {
                if (!$item['price']) {
                    $item['price'] = $item['parent_price'];
                }

                $deltas = $this->getPriceDiscounts($item['category_id']);

                // если были скидки, применяем дельты
                if ($deltas['prc'] || $deltas['abs']) {
                    $item['price'] = $this->calculatePrice($item['price'], $deltas['abs'], $deltas['prc']);
                }

                $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $item['item_id'] . '.jpg')) ? 'shop' . $item['item_id'] . '.jpg' : 'shop_default.jpg';
                $items[] = $item;
            }
        }

        foreach ($items as $key => $item) {
            $items[$key]['price'] = round($item['price'], 2);
            $items[$key]['totalprice'] = round($item['price'] * $item['cart_qty'], 2);
        }

        return $items;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getFrontItems($root_cat_id = 0)
    {

        if ($root_cat_id) {
            $rootcat = $this->inDB->get_fields('cms_shop_cats', 'id=' . $root_cat_id, 'NSLeft, NSRight');
            $catsql = "i.category_id = c.id AND c.NSLeft >= {$rootcat['NSLeft']} AND c.NSRight <= {$rootcat['NSRight']}";
        }

        $this->where('i.is_front = 1');
        if ($root_cat_id) {
            $this->where($catsql);
        }
        $this->groupBy('i.id');

        return $this->getItems();

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getDeliveryTypes($totalsumm)
    {

        global $_LANG;

        $types_list = array();

        $sql = "SELECT  id,
                        title,
                        description,
                        published,
                        minsumm,
                        freesumm,
                        price,
                        nofree

                FROM cms_shop_delivery
                WHERE published=1 AND minsumm <= {$totalsumm}
                ORDER BY price ASC";

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($type = $this->inDB->fetch_assoc($result)) {
            if (!$type['nofree']) {
                if ($type['freesumm'] <= $totalsumm) {
                    $type['price'] = 0;
                    $type['condition'] = str_replace('%freesumm%', $type['freesumm'], $_LANG['SHOP_FREE_COND']);
                }
            }
            $type['price'] = number_format($type['price'], 0, '.', '');
            $types_list[$type['id']] = $type;
        }

        return $types_list;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function savePaymentSystemConfig($item_id, $config)
    {

        if (!$item_id) {
            return false;
        }

        $inCore = cmsCore::getInstance();

        foreach ($config as $id => $val) {
            if (!is_array($val)) {
                $config[$id] = htmlspecialchars($val);
            }
        }

        $config = $this->inDB->escape_string($inCore->arrayToYaml($config));

        $sql = "UPDATE cms_shop_psys
                SET config='{$config}'
                WHERE id={$item_id}
                LIMIT 1";

        $this->inDB->query($sql);

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function installPaymentSystems()
    {

        $inCore = cmsCore::getInstance();

        $folders = $this->getPaymentSystemsFolders();

        $already = $this->getPaymentSystems(false);

        $installed = array();

        foreach ($folders as $num => $sys_id) {
            if (!isset($already[$sys_id])) {

                unset($pscfg);
                unset($psinfo);

                include_once($_SERVER['DOCUMENT_ROOT'] . '/components/shop/payments/' . $sys_id . '/info.php');

                if ($psinfo) {

                    $config = $pscfg ? $inCore->arrayToYaml($pscfg) : '';

                    $row = $this->inDB->get_fields('cms_shop_psys', 'id>0', 'ordering', 'ordering DESC');
                    $psinfo['ordering'] = $row['ordering'] + 1;

                    $sql = "INSERT INTO cms_shop_psys (link, title, url, logo, config, published, ordering)
                            VALUES ('{$sys_id}', '{$psinfo['title']}', '{$psinfo['url']}', '{$psinfo['logo']}', '{$config}', 1, {$psinfo['ordering']})";

                    $this->inDB->query($sql);

                    $installed[] = $psinfo['title'];

                }

            }
        }

        return $installed ? $installed : false;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getPaymentSystem($id)
    {

        $inCore = cmsCore::getInstance();

        if (is_int($id)) {
            $where = "id = {$id}";
        } else {
            $where = "link = '{$id}'";
        }

        $sql = "SELECT id, link, title, url, logo, config, published
                FROM cms_shop_psys
                WHERE {$where}";

        $res = $this->inDB->query($sql);

        if ($this->inDB->num_rows($res)) {
            while ($system = $this->inDB->fetch_assoc($res)) {
                $system['config'] = $inCore->yamlToArray($system['config']);
//                echo '<pre>'; print_r($system['config']); die();
                return $system;
            }
        }

        return false;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getPaymentSystems($only_published = true)
    {

        $inCore = cmsCore::getInstance();

        $systems = array();

        $pub_where = $only_published ? 'published=1' : 'id>0';

        $sql = "SELECT id, link, title, url, logo, config, published, ordering
                FROM cms_shop_psys
                WHERE {$pub_where}
                ORDER BY ordering ASC";

        $res = $this->inDB->query($sql);

        if ($this->inDB->num_rows($res)) {
            while ($system = $this->inDB->fetch_assoc($res)) {
                $system['config'] = $inCore->yamlToArray($system['config']);
                $systems[$system['link']] = $system;
            }
        }

        return $systems;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getPaymentSystemsFolders()
    {

        $root = $_SERVER['DOCUMENT_ROOT'] . '/components/shop/payments/';
        $pattern = $root . '*';

        $dirs = array();

        if (!glob($pattern)) {
            return false;
        }

        foreach (glob($pattern) as $dir) {
            if (is_dir($dir)) {
                if (file_exists($dir . '/info.php')) {
                    $dirs[] = basename($dir);
                }
            }
        }

        return is_array($dirs) ? $dirs : false;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function calculateOrderSumm($items, $d_type, $giftcode)
    {

        $inCore = cmsCore::getInstance();

        // считаем общую стоимость товаров
        $totalsumm = 0;
        foreach ($items as $item) {
            $totalsumm += ($item['price'] * $item['cart_qty']);
        }

        // TODO: Обрабатываем надбавки/скидки на сумму заказа
        $totalsumm = $this->getOrderSummDiscounted($totalsumm);

        // получаем способы доставки
        $delivery_types = $this->getDeliveryTypes($totalsumm);

        // прибавляем к сумме заказа стоимость выбранного типа доставки
        $d_price = $delivery_types[$d_type]['price'];
        $totalsumm += $d_price;

        return $totalsumm;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addOrder($order)
    {

        $order['items'] = $this->inDB->escape_string($order['items']);

        $order = cmsCore::callEvent('ADD_SHOP_ORDER', $order);

        $sql = "INSERT INTO cms_shop_orders (secret_key, date_created, date_payment, date_closed,
                                             customer_name, customer_org, customer_phone, customer_email,
                                             customer_address, customer_comment, customer_inn, items, d_type, d_price,
                                             giftcode, status, summ, user_id)
				VALUES ('{$order['secret_key']}', NOW(), NULL, NULL,
                        '{$order['customer_name']}', '{$order['customer_org']}', '{$order['customer_phone']}', '{$order['customer_email']}',
                        '{$order['customer_address']}', '{$order['customer_comment']}', '{$order['customer_inn']}', '{$order['items']}', '{$order['d_type']}', '{$order['d_price']}',
                        '{$order['giftcode']}', '{$order['status']}', '{$order['summ']}', '{$order['user_id']}')";

        $this->inDB->query($sql);

        $order_id = $this->inDB->get_last_id('cms_shop_orders');

        $this->trackQuantity($order_id);

        return $order_id;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function saveOrderComment($order_id, $comment)
    {

        if (!$order_id) {
            return false;
        }

        $this->inDB->query("UPDATE cms_shop_orders SET comment = '{$comment}' WHERE id='{$order_id}'");

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getOrders()
    {

        $inCore = cmsCore::getInstance();

        $orders = array();

        $sql = "SELECT o.*,
                        DATE_FORMAT(o.date_created, '%d.%m.%Y') as date_created,
                        DATE_FORMAT(o.date_created, '%h:%i') as time_created,
                        DATE_FORMAT(o.date_payment, '%d.%m.%Y') as date_payment,
                        DATE_FORMAT(o.date_payment, '%h:%i') as time_payment,
                        DATE_FORMAT(o.date_closed, '%d.%m.%Y') as date_closed,
                        DATE_FORMAT(o.date_closed, '%h:%i') as time_closed,
                        IFNULL(u.login, '') as user_login,
                        IFNULL(u.nickname, '') as user_nickname
                 FROM cms_shop_orders o
                 LEFT JOIN cms_users u ON u.id = o.user_id
                 WHERE o.status > 0
                       {$this->where}

                 {$this->order_by}
                 ";

        if ($this->limit) {
            $sql .= "LIMIT {$this->limit}";
        }

        $res = $this->inDB->query($sql) or die(mysqli_error());

        if ($this->inDB->num_rows($res)) {
            while ($order = $this->inDB->fetch_assoc($res)) {
                $order['items'] = $inCore->yamlToArray($order['items']);
                $orders[$order['id']] = $order;
            }
        }

        $this->resetConditions();

        return $orders;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getOrdersCount()
    {

        $orders = array();

        $sql = "SELECT o.*
                 FROM cms_shop_orders o
                 WHERE status > 0
                       {$this->where}

                 {$this->order_by}
                 ";

        $res = $this->inDB->query($sql) or die(mysqli_error());

        return $this->inDB->num_rows($res);

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getOrder($id, $secret_key = '')
    {

        $inCore = cmsCore::getInstance();

        $sql = "SELECT o.*,
                        DATE_FORMAT(o.date_created, '%d.%m.%Y') as date_created,
                        DATE_FORMAT(o.date_created, '%H:%i') as time_created,
                        DATE_FORMAT(o.date_payment, '%d.%m.%Y') as date_payment,
                        DATE_FORMAT(o.date_payment, '%H:%i') as time_payment,
                        DATE_FORMAT(o.date_closed, '%d.%m.%Y') as date_closed,
                        DATE_FORMAT(o.date_closed, '%H:%i') as time_closed,
                        d.title as d_name,
                        IFNULL(u.login, '') as user_login,
                        IFNULL(u.nickname, '') as user_nickname
                 FROM cms_shop_orders o
                 LEFT JOIN cms_shop_delivery d ON d.id = o.d_type
                 LEFT JOIN cms_users u ON u.id = o.user_id
                 WHERE o.id = {$id}
                 LIMIT 1";

        $res = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($res)) {
            return false;
        }

        $order = $this->inDB->fetch_assoc($res);

        $order['items'] = $inCore::yamlToArray($order['items']);

        return $order;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteOrder($id)
    {

        $this->trackQuantity($id, true);
        $this->inDB->query("DELETE FROM cms_shop_orders WHERE id={$id} LIMIT 1");
        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function addOrderItem($order_id, $art_no, $qty)
    {

        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();

        $is_base = $inDB->rows_count('cms_shop_items', "LOWER(art_no)=LOWER('$art_no')", 1);
        $is_vars = $inDB->rows_count('cms_shop_items_bind', "LOWER(art_no)=LOWER('$art_no')", 1);

        if ($is_base) {
            $sql = "SELECT i.id as item_id,
                           i.title as title,
                           i.price as price,
                           i.art_no as art_no,
                           i.qty as qty
                    FROM cms_shop_items i
                    WHERE LOWER(i.art_no)=LOWER('$art_no')
                    LIMIT 1";
        }

        if ($is_vars) {
            $sql = "SELECT i.title as title,
                           v.title as var_title,
                           v.price as price,
                           i.price as base_price,
                           v.art_no as art_no,
                           v.qty as qty,
                           v.item_id as item_id
                    FROM cms_shop_items i, cms_shop_items_bind v
                    WHERE LOWER(v.art_no)=LOWER('$art_no') AND
                          v.item_id = i.id
                    LIMIT 1";
        }

        $result = $inDB->query($sql);

        if (!$inDB->num_rows($result)) {
            return false;
        }

        $item = $inDB->fetch_assoc($result);

        if (!$item['price'] && $is_vars) {
            $item['price'] = $item['base_price'];
        }

        $item['totalprice'] = $item['price'] * $qty;
        $item['cart_qty'] = $qty;

        $order = $this->getOrder($order_id);

        $order['items'][] = $item;

        $new_summ = $this->calculateOrderSumm($order['items'], $order['d_type'], $order['giftcode']);
        $new_items = $inDB->escape_string($inCore->arrayToYaml($order['items']));

        $delivery_types = $this->getDeliveryTypes($new_summ);
        $new_d_price = $delivery_types[$order['d_type']]['price'];

        $sql = "UPDATE cms_shop_orders
                SET summ = '{$new_summ}',
                    d_price = '{$new_d_price}',
                    items = '{$new_items}'
                WHERE id = {$order_id}";

        $inDB->query($sql) or die(mysqli_error());

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteOrderItem($order_id, $item_id)
    {


        if (!$order_id || !$item_id) {
            return false;
        }

        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();

        $order = $this->getOrder($order_id);

        $delete_item_key = false;

        foreach ($order['items'] as $key => $item) {
            if ($item['item_id'] == $item_id) {
                $delete_item_key = $key;
                break;
            }
        }

        if ($delete_item_key === false) {
            return false;
        }

        unset($order['items'][$delete_item_key]);

        $new_summ = $this->calculateOrderSumm($order['items'], $order['d_type'], $order['giftcode']);
        $new_items = $inDB->escape_string($inCore->arrayToYaml($order['items']));

        $delivery_types = $this->getDeliveryTypes($new_summ);
        $new_d_price = $delivery_types[$order['d_type']]['price'];

        $sql = "UPDATE cms_shop_orders
                SET summ = '{$new_summ}',
                    d_price = '{$new_d_price}',
                    items = '{$new_items}'
                WHERE id = {$order_id}";

        $inDB->query($sql) or die(mysqli_error());

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function deleteExpiredOrders($session_id)
    {

        $secret_key = md5($session_id);

        $this->inDB->query("DELETE FROM cms_shop_orders WHERE secret_key='$secret_key' AND status=0 LIMIT 1");

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function setOrderStatus($order_id, $secret_key, $status)
    {

        if ($status == 2) {
            $now_date = 'date_payment';
        }
        if ($status == 3) {
            $now_date = 'date_closed';
        }

        if ($now_date) {
            $date_mod = ", {$now_date} = NOW()";
        }

        $status_sql = "UPDATE cms_shop_orders
                       SET status='{$status}' {$date_mod}
                       WHERE id={$order_id}
                       LIMIT 1";

        $this->inDB->query($status_sql);

        if ($status == 2) {
            $this->sendDigitalLinks($order_id);
        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function trackQuantity($order_id, $is_undo = false)
    {

        $cfg = $this->getConfig();

        if (!$cfg['track_qty']) {
            return false;
        }

        $order = $this->getOrder($order_id);

        if ($order['status'] == 2) {
            return false;
        }

        foreach ($order['items'] as $item) {

            if ($item['cart_qty'] > $item['qty'] && !$is_undo) {
                $item['cart_qty'] = $item['qty'];
            }

            $sign = $is_undo ? '+' : '-';

            $sql = "UPDATE cms_shop_items
                       SET qty = qty {$sign} {$item['cart_qty']}
                    WHERE id = '{$item['item_id']}'
                    LIMIT 1";

            $this->inDB->query($sql);

            $sql = "UPDATE cms_shop_items_bind
                       SET qty = qty {$sign} {$item['cart_qty']}
                    WHERE item_id = '{$item['item_id']}' AND art_no = '{$item['art_no']}'
                    LIMIT 1";

            $this->inDB->query($sql);

        }

        return true;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function sendDigitalLinks($order_id)
    {

        $inCore = cmsCore::getInstance();
        $inConf = cmsConfig::getInstance();

        $order = $this->getOrder($order_id);

        $links = '';

        foreach ($order['items'] as $item) {
            if ($item['is_digital'] && $item['filename_item'] && $item['filename_orig']) {

                $link_key = md5($order_id . '-' . $item['filename_orig']);

                $sql = "INSERT INTO cms_shop_loads (link_key, filename, filename_orig, is_loaded, order_id, item_id)
                        VALUES ('{$link_key}', '{$item['filename_item']}', '{$item['filename_orig']}', 0, '{$order['id']}', '{$item['item_id']}')";

                $this->inDB->query($sql);

                $links .= "\t{$item['title']}: " . HOST . "/shop/get/{$link_key}\n\n";

            }
        }

        if (!$links) {
            return false;
        }

        $cfg = $this->getConfig();

        $letter_path = PATH . '/includes/letters/inshop-digital.txt';
        $letter = file_get_contents($letter_path);

        // Заменяем теги в шаблоне на текст
        $letter = str_replace('{sitename}', $inConf->sitename, $letter);
        $letter = str_replace('{customer_name}', $order['customer_name'], $letter);
        $letter = str_replace('{links}', $links, $letter);
        $letter = str_replace('{link_ttl}', $cfg['link_ttl'], $letter);
        $letter = str_replace('{date}', $order['time_payment'] . ' ' . $order['date_payment'], $letter);

        if ($order['customer_email']) {
            $inCore->mailText($order['customer_email'], $_LANG['SHOP_DIGITAL_DELIVERY'] . ' - ' . $inConf->sitename, $letter);
        }

        return true;

    }

    public function getDigitalDownload($link_key)
    {

        $sql = "SELECT * FROM cms_shop_loads WHERE link_key = '{$link_key}'";
        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        $item = $this->inDB->fetch_assoc($result);

        return $item;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function parseFilterString($filter_str)
    {

        $filter = array();

        $pars = explode(',', $filter_str);

        foreach ($pars as $para) {
            $fields = explode('=', $para);
            $key = trim($fields[0]);
            $val = trim($fields[1]);
            if ($key && $val) {

                if (!isset($filter[$key])) {
                    $filter[$key] = $val;
                    continue;
                }

                if (isset($filter[$key])) {
                    if (!is_array($filter[$key])) {
                        $first_val = $filter[$key];
                        $filter[$key] = array();
                        $filter[$key][] = $first_val;
                        $filter[$key][] = $val;
                    } else {
                        $filter[$key][] = $val;
                    }
                }

            }
        }

        return $filter;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function makeFilterString($filter)
    {

        $filter_str = '';

        //склеиваем массив в строку
        foreach ($filter as $key => $val) {
            if ($val && $key) {
                if (!is_array($val)) {
                    $filter_str .= trim($key) . '=' . trim($val) . ',';
                }
                if (is_array($val)) {
                    foreach ($val as $subval) {
                        $filter_str .= trim($key) . '=' . trim($subval) . ',';
                    }
                }
            }
        }

        //обрезаем последнюю запятую
        $filter_str = rtrim($filter_str, ',');

        return $filter_str;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function sendOrder($order, $result, $cfg)
    {

        if (!$cfg['notify_send'] && !$cfg['notify_send_customer']) {
            return false;
        }
        if (!$cfg['notify_email'] && !$order['customer_email']) {
            return false;
        }

        $inCore = cmsCore::getInstance();
        $inConf = cmsConfig::getInstance();

        $status[1] = 'Принят в обработку';
        $status[2] = 'Оплачен, ждет доставки';
        $status[3] = 'Закрыт';

        global $_LANG;

        // Готовим список товаров в заказе
        $items = '';
        foreach ($order['items'] as $item) {
            $items .= "{$item['art_no']}\t{$item['title']}";
            if ($item['var_title']) {
                $items .= " ({$item['var_title']})";
            }
            if ($item['chars']) {
                $items .= " ({$item['chars']})";
            }
            $items .= "\n\t{$item['cart_qty']} {$_LANG['SHOP_PIECES']} x {$item['price']} = ";
            $items .= "{$item['totalprice']}\n";
            $items .= "\n";
        }

        $order['items'] = $items;
        $order['status'] = $status[$order['status']];

        // Загружаем шаблон письма
        $letter_path = PATH . '/includes/letters/inshop-order.txt';
        $letter = file_get_contents($letter_path);

        // Заменяем теги в шаблоне на текст
        $letter = str_replace('{sitename}', $inConf->sitename, $letter);
        foreach ($order as $field => $val) {
            $letter = str_replace('{' . $field . '}', $val, $letter);
        }
        $letter = str_replace('{giftcode}', $order['giftcode'], $letter);
        // Отправляем продавцу, если разрешено и указан адрес почты
        if ($cfg['notify_email'] && $cfg['notify_send']) {

            $emails = array();

            if (!mb_strstr($cfg['notify_email'], ',')) {
                // указан один адрес продавца
                $emails[] = $cfg['notify_email'];
            } else {
                // указано несколько адресов через запятую
                $emails = explode(',', $cfg['notify_email']);
            }

            foreach ($emails as $email) {
                $email = trim($email);
                $inCore->mailText($email, $_LANG['SHOP_NEW_ORDER'] . ' #' . $order['id'], $letter);
            }

        }

        // Отправляем покупателю, если разрешено и указан адрес почты
        if ($order['customer_email'] && $cfg['notify_send_customer']) {
            $inCore->mailText($order['customer_email'], $_LANG['SHOP_ORDER_ACCEPTED'] . ' - ' . $inConf->sitename, $letter);
        }

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function saveCustomerData($user_id, $data)
    {

        $inCore = cmsCore::getInstance();

        $data_yaml = $inCore->arrayToYaml($data);

        $already = $this->inDB->get_field('cms_shop_customers_data', "user_id='{$user_id}'", 'user_id');

        if ($already) {
            $sql = "UPDATE cms_shop_customers_data SET data = '{$data_yaml}' WHERE user_id = {$user_id}";
        } else {
            $sql = "INSERT INTO cms_shop_customers_data (user_id,data) VALUES ({$user_id}, '{$data_yaml}')";
        }

        $this->inDB->query($sql);

        return;

    }

    public function getCustomerData($user_id)
    {

        $inCore = cmsCore::getInstance();

        $data = $this->inDB->get_field('cms_shop_customers_data', "user_id='{$user_id}'", 'data');

        return ($data ? $inCore->yamlToArray($data) : array());

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getRelatedItems($item_id)
    {

        $inCore = cmsCore::getInstance();
        $inCore->loadLib('tags');

        $cfg = $this->getConfig();

        $tags = cmsTagLine('shop', $item_id, false);

        if (!$tags) {
            return false;
        }

        $tags = explode(',', $tags);

        foreach ($tags as $id => $tag) {
            $tag = trim($tag);
            $tags_where = "t.tag = '{$tag}'";
            if ($id < sizeof($tags) - 1) {
                $tags_where .= ' OR ';
            }
        }

        $sql = "SELECT i.id, i.title, i.seolink
                FROM cms_shop_items i, cms_tags t
                WHERE ({$tags_where})
                      AND t.item_id = i.id AND t.target = 'shop'
                      AND i.published = 1
                      AND i.id <> '{$item_id}'
                GROUP BY i.id
                ORDER BY RAND()
                LIMIT {$cfg['related_count']}";

        $result = $this->inDB->query($sql);

        $items = array();

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        while ($item = $this->inDB->fetch_assoc($result)) {
            $item['filename'] = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/photos/small/shop' . $item['id'] . '.jpg')) ? 'shop' . $item['id'] . '.jpg' : 'shop_default.jpg';
            $items[] = $item;
        }

        return $items;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function getItemNav($item_id, $cat_id)
    {

        $ordering = $this->inDB->get_field('cms_shop_items_cats', "item_id={$item_id} AND category_id={$cat_id}", 'ordering');

        $sql = "SELECT i.id as id, i.seolink as seolink, ic.ordering as ordering, i.title as title
                FROM cms_shop_items i, cms_shop_items_cats ic
                WHERE ic.item_id = i.id AND i.published = 1
                  AND ic.category_id = {$cat_id}
                  AND (ic.ordering < {$ordering} OR ic.ordering > {$ordering})
                LIMIT 2";

        $result = $this->inDB->query($sql);

        if (!$this->inDB->num_rows($result)) {
            return false;
        }

        $items = array();
        $nav = array();

        while ($item = $this->inDB->fetch_assoc($result)) {
            if ($item['ordering'] == $ordering - 1) {
                $nav['prev'] = $item;
            } else {
                $nav['next'] = $item;
            }
        }

        return $nav;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getCatVendors($cat_id)
    {

        $vendors = array();

        $sql = "SELECT  v.*

                FROM  cms_shop_vendors v

                JOIN cms_shop_items i ON v.id = i.vendor_id
                JOIN cms_shop_items_cats c ON i.id = c.item_id AND c.category_id = '{$cat_id}'

                WHERE v.published = 1

                GROUP BY v.id

                ORDER BY v.title";

        $result = $this->inDB->query($sql);

        if ($this->inDB->num_rows($result)) {
            while ($vendor = $this->inDB->fetch_assoc($result)) {
                $vendors[$vendor['id']] = $vendor;
            }
        }

        return $vendors ? $vendors : false;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function deleteDiscount($id)
    {
        cmsCore::callEvent('DELETE_SHOP_DISCOUNT', $id);
        $this->inDB->query("DELETE FROM cms_shop_discounts WHERE id = $id LIMIT 1");
    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function updateDiscount($id, $item)
    {

        $item = cmsCore::callEvent('UPDATE_SHOP_DISCOUNT', $item);

        $item['cats'] = $item['cats'] ? serialize($item['cats']) : '';
        $item['groups'] = $item['groups'] ? serialize($item['groups']) : '';

        $sql = "UPDATE cms_shop_discounts
                SET title = '{$item['title']}',
                    groups = '{$item['groups']}',
                    cats = '{$item['cats']}',
                    amount = '{$item['amount']}',
                    is_percent = '{$item['is_percent']}',
                    is_forever = '{$item['is_forever']}',
                    date_until = '{$item['date_until']}',
                    sign = '{$item['sign']}'
                WHERE id = $id
                LIMIT 1";

        $this->inDB->query($sql);

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function addDiscount($item)
    {

        $item = cmsCore::callEvent('ADD_SHOP_DISCOUNT', $item);

        $item['cats'] = $item['cats'] ? serialize($item['cats']) : '';
        $item['groups'] = $item['groups'] ? serialize($item['groups']) : '';

        $sql = "INSERT INTO cms_shop_discounts (title, sign, groups, cats, amount, is_percent, is_forever, date_until, published)
				VALUES ('{$item['title']}', '{$item['sign']}', '{$item['groups']}',
                '{$item['cats']}', '{$item['amount']}', '{$item['is_percent']}', '{$item['is_forever']}',
                '{$item['date_until']}', 1)";

        $this->inDB->query($sql);

        $discount_id = $this->inDB->get_last_id('cms_shop_discounts');

        return $discount_id;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getDiscount($id)
    {

        $discount = $this->inDB->get_fields('cms_shop_discounts', "id={$id}", '*');

        $discount['cats'] = $discount['cats'] ? unserialize($discount['cats']) : '';
        $discount['groups'] = $discount['groups'] ? unserialize($discount['groups']) : '';

        return $discount;

    }

    public function getDiscounts($only_published = true)
    {

        $discounts = false;

        $pub_where = $only_published ? 'published=1 AND ( NOW()<=date_until OR is_forever )' : '1=1';

        $sql = "SELECT *
                 FROM cms_shop_discounts
                 WHERE $pub_where
                 ";

        $res = $this->inDB->query($sql) or die(mysqli_error());

        if ($this->inDB->num_rows($res)) {
            $discounts = array();
            while ($discount = $this->inDB->fetch_assoc($res)) {
                $discount['cats'] = $discount['cats'] ? unserialize($discount['cats']) : '';
                $discount['groups'] = $discount['groups'] ? unserialize($discount['groups']) : '';
                $discounts[$discount['id']] = $discount;
            }
        }

        return $discounts;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function getOrderDiscountSize($totalsumm)
    {

        $cfg = $this->getConfig();

        $discount_size = 0;

        if (is_array($cfg['discount'])) {
            if (sizeof($cfg['discount'])) {
                krsort($cfg['discount']);
                foreach ($cfg['discount'] as $dis_amount => $dis_price) {
                    if ($totalsumm >= $dis_amount) {
                        $discount_size = $dis_price;
                        break;
                    }
                }
            }
        }

        return $discount_size;

    }

    public function getOrderSummDiscounted($totalsumm, $discount_size = false)
    {

        if ($discount_size === false) {
            $discount_size = $this->getOrderDiscountSize($totalsumm);
        }

        $totalsumm -= $totalsumm * ($discount_size / 100);

        return $totalsumm;

    }

    public function getPriceDiscounts($category_id)
    {

        $inUser = cmsUser::getInstance();
        $discounts = $this->getDiscounts();

        $prc_price_delta = 0;
        $abs_price_delta = 0;

        if (is_array($discounts)) {

            // отбираем подходящие скидки и считаем процентную и абсолютную
            // дельту для изменения цен
            foreach ($discounts as $d_id => $d) {
                if (!is_array($d['groups']) || in_array($inUser->group_id, $d['groups'])) {
                    if (!is_array($d['cats']) || in_array($category_id, $d['cats'])) {
                        if ($d['is_percent']) {
                            $prc_price_delta = $prc_price_delta + ($d['sign'] * $d['amount']);
                        } else {
                            $abs_price_delta = $abs_price_delta + ($d['sign'] * $d['amount']);
                        }
                    }
                }
            }

        }

        return array('prc' => $prc_price_delta, 'abs' => $abs_price_delta);

    }

    public function calculatePrice($price, $abs_delta, $prc_delta)
    {

        $price += $abs_delta;

        $price += ($price * ($prc_delta / 100));

        return $price;

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function isUserVoted($item_id, $user_id)
    {

        return (bool)$this->inDB->rows_count('cms_shop_ratings', "item_id={$item_id} AND user_id={$user_id}", 1);

    }

    /* ==================================================================================================== */
    /* ==================================================================================================== */

    public function rateItem($item_id, $user_id, $points)
    {

        $inUser = cmsUser::getInstance();

        if (!$item_id) {
            return false;
        }
        if (!$inUser->id || ($user_id != $inUser->id)) {
            return false;
        }
        if ($this->isUserVoted($item_id, $user_id)) {
            return false;
        }

        $sql = "INSERT INTO cms_shop_ratings (`item_id`, `user_id`, `points`)
                VALUES('{$item_id}', '{$user_id}', '{$points}')";

        $this->inDB->query($sql);

        $sql = "SELECT COUNT(user_id) as rating_votes,
                       AVG(points) as rating
                FROM cms_shop_ratings
                WHERE item_id = {$item_id}
                GROUP BY item_id";

        $rate_res = $this->inDB->query($sql);
        $data = $this->inDB->fetch_assoc($rate_res);

        $data['rating'] = round($data['rating'], 2);

        $this->inDB->query("UPDATE cms_shop_items SET rating = '{$data['rating']}', rating_votes = '{$data['rating_votes']}' WHERE id={$item_id} LIMIT 1");

        return true;

    }

    /* ========================================================================== */
    /* ========================================================================== */

    public function setOrderPaymentSystem($order_id, $psys_title)
    {

        $sql = "UPDATE cms_shop_orders SET psys_title = '{$psys_title}' WHERE id = '{$order_id}'";
        $this->inDB->query($sql);

    }

    /* =================ДЛЯ СИНХРЫ -5%========================================================= */
    /* ========================================================================== */

    public function updRozn($prod1cid)
    {

        $sql = "SELECT * FROM cms_shop_items WHERE external_id = '$prod1cid'";

        $res = mysqli_query($sql);
        while ($item = mysqli_fetch_array($res)) {
            $rozn = round($item['price'] * 95 / 100);
        }

        $sql1 = "UPDATE cms_shop_items SET price = '$rozn' WHERE external_id = '$prod1cid'";

        mysqli_query($sql1);

    }


    /* =================ДЛЯ CОПУТВУЮЩИХ=========================================== */
    /* ================ from id items =========================================== */

    public function selectSimilars($shortdesc)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $massiv = [];
        $arr = [];
        $arr = explode(",", $shortdesc);
        foreach ($arr as $val) {
            if ($val != '') {
                $id = $val;
                $sql = "SELECT *  
			FROM cms_shop_items 
			WHERE id='{$id}'";
                $result = $inDB->query($sql);
                if ($inDB->num_rows($result)) {
                    while ($item = $inDB->fetch_assoc($result)) {
                        $massiv[] = $item;

                    }
                }
            }

        }

        return $massiv;
    }


    public function getSdTovar($sd_tovar)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $html = '<div class="h4">Популярное в рубрике</div>';
        $html .= '<div class="row">';
        $arr = array();
        $arr = explode(",", $sd_tovar);
        foreach ($arr as $val) {
            if ($val != '') {
                $art_no = $val;
                $sql = "SELECT *  
			FROM cms_shop_items 
			WHERE art_no='{$art_no}'";
                $result = $inDB->query($sql);
                if ($inDB->num_rows($result)) {
                    while ($item = $inDB->fetch_assoc($result)) {
//					if ($item['old_price']>0){ $disco = ceil((100-($item['price']*100/$item['old_price']))); $hit .= '<div class="ribbon-lt"><span>Скидка '.$disco.'%</span></div>'; } else { $hit = ''; }
                        if ($item['old_price'] > 0) {
                            $disco = ceil((100 - ($item['price'] * 100 / $item['old_price'])));
                            $hit .= ''; //'<div class="ribbon-lt"><span>Скидка</span></div>';
                        } else {
                            $hit = '';
                        }

                        $html .= '<div class="d-flex flex-row justify-content-start align-item-center mx-4 my-3 border" style="border-radius: 10px;">';
//                        $html .= '<div class="thumbnail">';
                        $html .= '<div class="" >';
                        $html .= '<a href="/shop/' . $item['seolink'] . '.html" class="d-block" style="margin-left: 7px; margin-top: 7px; margin-bottom: 7px; margin-right: 15px;"><img class="img-fluid" style="max-width: 112px;" alt="' . $item['title'] . '" src="/images/photos/small/shop' . $item['id'] . '.jpg"  />' . $hit . '</a>';
                        $html .= '</div>';
                        $html .= '  <div class="pr-4">';
                        $html .= '    <div class="h5"><a href="/shop/' . $item['seolink'] . '.html" class="tr-2" style="text-overflow: ellipsis;">' . $item['title'] . '</a></div>';
                        $html .= '    Цена: ' . $item['price'] . ' тенге';
                        $html .= '  </div>';
//                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
            }

        }
        $html .= '</div>';
        return $html;
    }

    public function getSdRubric($sd_rubric)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $html = '<div class="h4">Рубрики</div><ul>';
        $arr = array();
        $arr = explode(",", $sd_rubric);
        foreach ($arr as $val) {
            if ($val != '') {
                $id = $val;
                $sql = "SELECT *  
			FROM cms_shop_cats 
			WHERE id='{$id}'";
                $result = $inDB->query($sql);
                if ($inDB->num_rows($result)) {
                    while ($item = $inDB->fetch_assoc($result)) {
                        $html .= '<li><a href="/shop/' . $item['seolink'] . '">&bull; ' . $item['title'] . '</a></li>';

                    }
                }
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getSdBrand($sd_brand)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $html = '<div class="h4">Бренды</div><ul class="brands-list">';
        $arr = array();
        $arr = explode(",", $sd_brand);
        foreach ($arr as $val) {
            if ($val != '') {
                $id = $val;
                $sql = "SELECT *  
			FROM cms_shop_vendors 
			WHERE id='{$id}'";
                $result = $inDB->query($sql);
                if ($inDB->num_rows($result)) {
                    while ($item = $inDB->fetch_assoc($result)) {
                        $html .= '<li><a href="/shop/vendors/' . $item['id'] . '">&bull; ' . $item['title'] . '</a></li>';

                    }
                }
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getSdVit($goods)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $massiv = array();
        $arr = array();
        $arr = explode(",", $goods);
        foreach ($arr as $val) {
            if ($val != '') {
                $itemId = $val;
                $sql = "SELECT *   
			FROM cms_shop_items
			WHERE id ='{$itemId}'";
                $result = $inDB->query($sql);
                if ($inDB->num_rows($result)) {
                    $today = date('d.m.Y');
                    while ($item = $inDB->fetch_assoc($result)) {

                        if ($item['pubdate'] > $today) {
                            $item['novinka'] = 1;
                        } else {
                            $item['novinka'] = 0;
                        }
                        $massiv[] = $item;
                    }
                }
            }

        }

        return $massiv;
    }

    public function getCatalogItems($cfg)
    {

        $arrayCategory = explode(',', $cfg['categories']);
        $listItems = [];
        $itemsId = [];
        $allInArray = [];

        array_push($itemsId, explode(',', $cfg['itemsList1']));
        array_push($itemsId, explode(',', $cfg['itemsList2']));
        array_push($itemsId, explode(',', $cfg['itemsList3']));
        array_push($itemsId, explode(',', $cfg['itemsList4']));
        array_push($itemsId, explode(',', $cfg['itemsList5']));
        array_push($itemsId, explode(',', $cfg['itemsList6']));



        for ($i=0, $j=0; $i < count($arrayCategory), $j < count($itemsId); $i++, $j++) {
            $allInArray[$arrayCategory[$i]] = $itemsId[$j];
        }


        foreach ($allInArray as $categoryId => $items) {
            $arrayItems = [];
            $queryGetTitleCategory = "SELECT title FROM cms_shop_cats c WHERE c.id = '{$categoryId}'";
            $result = $this->inDB->query($queryGetTitleCategory);

            if($this->inDB->num_rows($result)) {
                $titleCategory = $this->inDB->fetchObject($result);
            }

            foreach ($items as $key => $item) {

                $queryGetItems = "SELECT *
                                  FROM cms_shop_items i 
                                  WHERE i.id = '{$item}'
                                 ";
                $result2 = $this->inDB->query($queryGetItems);
                if ($this->inDB->num_rows($result2)) {
                    $arrayItems[] = $this->inDB->fetchObject($result2);
                } else {
                    $arrayItems[] = [];
                }

            }
            $listItems[$titleCategory->title] = $arrayItems;
        }

        return $listItems;
    }


// функция выгруза прайса для каспи
    public function getKaspi()
    {

        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();


        $xml = new DomDocument('1.0', 'utf-8');
        $kaspi_catalog = $xml->appendChild($xml->createElement('kaspi_catalog'));
        $kaspi_catalog->setAttribute('date', 'string');
        $kaspi_catalog->setAttribute('xmlns', 'kaspiShopping');
        $kaspi_catalog->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $kaspi_catalog->setAttribute('xsi:schemaLocation', 'kaspiShopping http://kaspi.kz/kaspishopping.xsd');
        $company = $kaspi_catalog->appendChild($xml->createElement('company', 'SanMarket'));
        $merchantid = $kaspi_catalog->appendChild($xml->createElement('merchantid', 'SanMarket'));
        $offers = $kaspi_catalog->appendChild($xml->createElement('offers'));


        /* $sql = "SELECT
            i.*,
            IFNULL(v.title, '') as vendor,
            IFNULL(v.id, 0) as vendor_id,
            c.id, c.is_xml
            FROM cms_shop_items i LEFT JOIN cms_shop_vendors v ON i.vendor_id = v.id LEFT JOIN cms_shop_cats c ON i.category_id = c.id
            WHERE i.published=1 AND i.qty>0 AND i.price>1 AND c.is_xml=1";
        */

        $sql = "SELECT 
			i.*, 
			IFNULL(v.title, '') as vendor,
            IFNULL(v.id, 0) as vendor_id, 
			c.*
			FROM cms_shop_items i LEFT JOIN cms_shop_vendors v ON i.vendor_id = v.id LEFT JOIN cms_shop_items_cats c ON c.item_id = i.id
			WHERE c.category_id = 11038";
        $result = $inDB->query($sql);
        if ($inDB->num_rows($result)) {
            while ($item = $inDB->fetch_assoc($result)) {

                $offer = $offers->appendChild($xml->createElement('offer'));
                $offer->setAttribute('sku', $item['art_no']);
                $models = $offer->appendChild($xml->createElement('model', $item['title']));
                $brand = $offer->appendChild($xml->createElement('brand', $item['vendor']));
                $availabilities = $offer->appendChild($xml->createElement('availabilities'));
                $availability = $availabilities->appendChild($xml->createElement('availability'));
                $availability->setAttribute('available', 'yes');
                $availability->setAttribute('storeId', 'PP1');
//$availability->setAttribute('preOrder', '7');
                $availability1 = $availabilities->appendChild($xml->createElement('availability'));
                $availability1->setAttribute('available', 'yes');
                $availability1->setAttribute('storeId', 'PP2');
//$availability1->setAttribute('preOrder', '7');
                $availability2 = $availabilities->appendChild($xml->createElement('availability'));
                $availability2->setAttribute('available', 'yes');
                $availability2->setAttribute('storeId', 'PP3');
//$availability2->setAttribute('preOrder', '7');
                $availability2 = $availabilities->appendChild($xml->createElement('availability'));
                $availability2->setAttribute('available', 'yes');
                $availability2->setAttribute('storeId', 'PP4');

                $availability2 = $availabilities->appendChild($xml->createElement('availability'));
                $availability2->setAttribute('available', 'yes');
                $availability2->setAttribute('storeId', 'PP5');

                $availability2 = $availabilities->appendChild($xml->createElement('availability'));
                $availability2->setAttribute('available', 'yes');
                $availability2->setAttribute('storeId', 'PP6');

                $availability2 = $availabilities->appendChild($xml->createElement('availability'));
                $availability2->setAttribute('available', 'yes');
                $availability2->setAttribute('storeId', 'PP7');

                $price = $offer->appendChild($xml->createElement('price', floatval($item['price'])));

            }
        }


        $xml->formatOutput = true;
        $xml->save('../price.xml');


        return true;
    }


// функция выгруза прайса для google merchanT
    public function getMerchant()
    {

        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();


        $xml = new DomDocument('1.0', 'utf-8');
        $merch = $xml->appendChild($xml->createElement('rss'));
        $merch->setAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        $merch->setAttribute('version', '2.0');
        $channel = $merch->appendChild($xml->createElement('channel'));
        $title = $channel->appendChild($xml->createElement('title', 'Интернет-магазин SanMarket.kz'));
        $link = $channel->appendChild($xml->createElement('link', 'https://sanmarket.kz'));
        $description = $channel->appendChild($xml->createElement('description', 'Хотите купить сантехнику? Большой магазин сантехники SanMarket.kz. Низкие цены! Все для ванной. Широкий ассортимент. Покупай онлайн и недорого! Доставка → Алматы, Нур-Султан (Астана), Караганда, Шымкент, Костанай, по Казахстану.'));

        $sql = "SELECT 
			i.*, 
			IFNULL(v.title, '') as vendor,
            IFNULL(v.id, 0) as vendor_id, 
			c.*, ct.id as catid, ct.title as cattitle 
			FROM cms_shop_items i LEFT JOIN cms_shop_vendors v ON i.vendor_id = v.id LEFT JOIN cms_shop_items_cats c ON c.item_id = i.id LEFT JOIN cms_shop_cats ct ON i.category_id = ct.id 
			WHERE i.published = 1 AND c.category_id != 1049 AND c.category_id != 11006 AND c.category_id != 1040 AND c.category_id != 1042 AND c.category_id != 10955 AND c.category_id != 10509 AND c.category_id != 10963 AND c.category_id != 1036 AND c.category_id != 1032 AND c.category_id != 10952  AND c.category_id != 10953 AND c.category_id != 10972 AND c.category_id != 11023 AND c.category_id != 11024 AND c.category_id != 11025 AND c.category_id != 1051 AND c.category_id != 1054 AND c.category_id != 1055 AND c.category_id != 1058 AND c.category_id != 1053 AND c.category_id != 1046 AND c.category_id != 10991 AND c.category_id != 911 AND c.category_id != 10979 AND c.category_id != 10993 ORDER BY i.id DESC";
        $result = $inDB->query($sql);
        if ($inDB->num_rows($result)) {
            while ($tovar = $inDB->fetch_assoc($result)) {

                $item = $channel->appendChild($xml->createElement('item'));
                $gid = $item->appendChild($xml->createElement('g:id', $tovar['id']));
                $gtitle = $item->appendChild($xml->createElement('g:title', $tovar['title']));
                $gdescription = $item->appendChild($xml->createElement('g:description', '<![CDATA[' . mb_strimwidth(trim(htmlspecialchars(strip_tags($tovar['description']))), 0, 2000) . ']]>'));
                $glink = $item->appendChild($xml->createElement('g:link', 'https://sanmarket.kz/shop/' . $tovar['seolink'] . '.html'));
                $gimage_link = $item->appendChild($xml->createElement('g:image_link', 'https://sanmarket.kz/images/photos/small/shop' . $tovar['id'] . '.jpg'));
                $gcondition = $item->appendChild($xml->createElement('g:condition', 'new'));
                //if ($tovar['qty'] > 0) {
                //	$gavailability = $item->appendChild($xml->createElement('g:availability','in stock'));
                //} else {
                $gavailability = $item->appendChild($xml->createElement('g:availability', 'preorder'));
                //}
                if ($tovar['old_price'] > 0) {
                    $gprice = $item->appendChild($xml->createElement('g:price', $tovar['old_price'] . ' KZT'));
                    $gsale_price = $item->appendChild($xml->createElement('g:sale_price', $tovar['price'] . ' KZT'));
                } else {
                    $gprice = $item->appendChild($xml->createElement('g:price', $tovar['price'] . ' KZT'));
                }

                $ggtin = $item->appendChild($xml->createElement('g:gtin'));
                $ggtin->setAttribute('identifier_exists', 'no');

                if ($tovar['vendor_id'] > 0) {
                    $gbrand = $item->appendChild($xml->createElement('g:brand', $tovar['vendor']));
                } else {
                    $gbrand = $item->appendChild($xml->createElement('g:brand', 'SanMarket.kz'));
                }

                $gmpn = $item->appendChild($xml->createElement('g:mpn'));
                $gmpn->setAttribute('identifier_exists', 'no');

                $gproduct_type = $item->appendChild($xml->createElement('g:product_type', $tovar['cattitle']));
            }
        }


        $xml->formatOutput = true;
        $xml->save('../merchant.xml');


        return true;
    }

    public function selectRelatives($cat_id, $item_id)
    {
        $massiv = array();
        $sql = "SELECT * FROM cms_shop_items WHERE category_id='{$cat_id}' AND id!='{$item_id}' AND published='1' ORDER BY id LIMIT 12";
        $result = $this->inDB->query($sql);
        if (!$this->inDB->num_rows($result)) {
            return false;
        }
        while ($item = $this->inDB->fetch_assoc($result)) {
            $massiv[] = $item;
        }
        return $massiv;
    }


    public function getBanner($pos)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $banner = '';

        $fields = $this->inDB->get_fields('cms_banners', "position='banner{$pos}' AND published = 1", '*');
        if ($fields) {
            $banner = '<a href="' . $fields['link'] . '" title="' . $fields['title'] . '" style="display:block;margin-bottom:5px;"><img src="/images/banners/' . $fields['fileurl'] . '" class="img-resp hidden-xs" alt="' . $fields['title'] . '" /><img src="/images/banners/' . $fields['fileurl'] . '" class="img-resp hidden-lg hidden-md hidden-sm" alt="' . $fields['title'] . '" /></a>';
        }
        return $banner;
    }

    public function getBanner1($pos)
    {
        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();
        $fields = $this->inDB->get_fields('cms_banners', "position='banner{$pos}' AND published = 1", '*');
        $banner = '';
        if ($fields) {
            $banner = '	<div class="col-sm-4 col-xs-12">
		<div class="thumb">
			<a href="' . $fields['link'] . '" class="imgthumb" title="' . $fields['title'] . '"><img src="/images/banners/' . $fields['fileurl'] . '" class="img-resp" alt="' . $fields['title'] . '" /></a>
			<div class="capt">
				<a href="' . $fields['link'] . '" title="' . $fields['title'] . '" data-truncate="2" id="ninada">' . $fields['title'] . '</a>
			</div>
			<div class="pricer">
				<div>Акция!</div>
			</div>
			<div class="text-center"><a href="' . $fields['link'] . '" class="btn btn-main add-basket">Подробнее</a></div>
		</div></div>';
        }
        return $banner;
    }

    public function getParamsItem($idItem)
    {
        $itemParts = [];
        if ($idItem) {
            $sql = "SElECT * FROM cms_item_params WHERE item_id = $idItem";
            $result = $this->inDB->query($sql);
        }

        if ($this->inDB->num_rows($result)) {
            $itemParts = $this->inDB->fetch_all($result);
            return $itemParts;
        }

        return $itemParts;

    }


    public function addParamsItem($idItem, $params)
    {

        if ($params) {
            foreach ($params as $key => $param) {

                $sql = "INSERT INTO cms_item_params( item_id, title_part, width, height, depth, weight)
                        VALUES ('$idItem', '{$param['title']}', '{$param['width']}', '{$param['height']}', '{$param['depth']}', '{$param['weight']}')";
                $this->inDB->query($sql);

            }
            return 0;
        }
        
        return 1;

    }


    public function updateParamsItem($id, $paramsItem)
    {
        foreach ($paramsItem as $key => $item) {


        }
        
        return false;

    }

    public function generateRowPartsItem($partsItem) : string
    {
        $result = '';
        if (boolval($partsItem)) {
            foreach ($partsItem as $index => $item) {

                $result .= "<tr class=\"\">
                                    <td>
                                        <input name=\"partId\" type=\"hidden\" value=\"{$item->id} \">
                                        <input name=\"titlePart[]\" type=\"text\" value=\"{$item->title_part}\"/>
                                    </td>
                                    <td>
                                        <input name=\"widthItem[]\" type=\"text\" value=\"{$item->width}\"/>
                                    </td>
                                    <td>
                                        <input name=\"heightItem[]\" type=\"text\" value=\"{$item->height}\"/>
                                    </td>
                                    <td>
                                        <input name=\"depthItem[]\" type=\"text\" value=\"{$item->depth}\"/>
                                    </td>
                                    <td>
                                        <input name=\"weightItem[]\" type=\"text\" value=\"{$item->weight}\"/>
                                    </td>
                                    <td>
                                        <img id=\"buttonRemovePart\" class=\"img-fluid\" src=\"images/actions/delete.gif\" alt=\"remove\">
                                    </td>
                                </tr>";

            }
        } else {

            $result = "<tr class=\"\">
                                    <td>
                                        <input name=\"partId\" type=\"hidden\" value=\"\">
                                        <input name=\"titlePart[]\" type=\"text\" value=\"\"/>
                                    </td>
                                    <td>
                                        <input name=\"widthItem[]\" type=\"text\" value=\"\"/>
                                    </td>
                                    <td>
                                        <input name=\"heightItem[]\" type=\"text\" value=\"\"/>
                                    </td>
                                    <td>
                                        <input name=\"depthItem[]\" type=\"text\" value=\"\"/>
                                    </td>
                                    <td>
                                        <input name=\"weightItem[]\" type=\"text\" value=\"\"/>
                                    </td>
                                    <td>
                                        <img id=\"buttonRemovePart\" class=\"img-fluid\" src=\"images/actions/delete.gif\" alt=\"remove\">
                                    </td>
                                </tr>";

        }

        return $result;

    }


}
