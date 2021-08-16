<?php
/******************************************************************************/
//                                                                            //
//                           InstantCMS v1.10.6                               //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2015                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); }

function newContent($table, $where=''){
	$inDB   = cmsDatabase::getInstance();
    if ($where) { $where = ' AND '.$where; }
    $new = $inDB->get_field($table, "DATE_FORMAT(pubdate, '%d-%m-%Y') = DATE_FORMAT(NOW(), '%d-%m-%Y'){$where}", 'COUNT(id)');
    return $new;
}

function applet_main(){

    $inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$do = $inCore::request('do', 'str');
	$column = $inCore::request('column', 'str');
	$direction = $inCore::request('direction', 'str');
	$dateWith = $inCore::request('with_date', 'str');
	$dateFromTo = $inCore::request('from_to_date', 'str');


	global $_LANG;

	$GLOBALS['cp_page_title'] = $_LANG['PATH_HOME'];

?>
<?php if ($do == 'control_productivity') {
    $sql = 'SELECT ctrl.id, u.nickname, i.title, ctrl.actions, ctrl.created_at
            FROM users_control_productivity ctrl
            JOIN cms_users u ON ctrl.user_id = u.id
            JOIN cms_shop_items i ON ctrl.item_id = i.id
            ';
    if ($column && $direction) {
        $inDB->orderBy($column, $direction);
    }
    
    if ($dateWith && $dateFromTo) {
        $with = date('Y-m-d', strtotime($dateWith));
        $fromTo = date('Y-m-d', strtotime($dateFromTo));
        $where = "WHERE DATE(created_at) BETWEEN \"$with\"  AND \"$fromTo\"";
        $sql .= $where;
        $result = $inDB->query($sql);
        if ($inDB->num_rows($result)) {
            while($row = $inDB->fetch_assoc($result)) {
                $arrayData[] = $row;
            }
        }

        $inCore::jsonOutput($arrayData);
        
    }

    $result = $inDB->query($sql);

    if ($inDB->num_rows($result)) {
        while($row = $inDB->fetch_assoc($result)) {
            $arrayData[] = $row;
        }
    }
?>
    <button id="btn-filter-table-control" class="btn btn-success float-right mb-2">Фильтр</button>
    <table class="table table-hover table_control" col="5">
        <thead>
            <tr>
                <th scope="col"><a href="?do=control_productivity&column=id&direction=desc">id</a></th>
                <th scope="col"><a href="?do=control_productivity&column=user_id&direction=desc">Пользователь</a></th>
                <th scope="col">Товар</th>
                <th scope="col">Действие</th>
                <th scope="col">Период</th>
            </tr>
        </thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="align-middle" valign="middle">
                <input name="action" type="text">
            </td>
            <td rowspan="2">
                <div>
                    <span>c:&nbsp;&nbsp;&nbsp;</span>
                    <input name="with-date" type="date">
                </div>
                <div class="mt-2">
                    <span>по:&nbsp;</span>
                    <input name="from-to-date" type="date">
                </div>
            </td>
        </tr>
        <tbody id="control-table--tbody">
        <?php foreach ($arrayData as $index => $item) {
            printf("<tr class='table-tr-date'><th scope=\"row\">%d</th><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $item['id'], $item['nickname'], $item['title'], $item['actions'], date('d.m.Y H:i:s', strtotime($item['created_at'])));
        } ?>
        </tbody>

    </table>


<?php } else { ?>
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="275" valign="top" style="padding-left:0px;">
        <div class="small_box">
        <div class="small_title"><?php echo $_LANG['AD_SITE_CONTENT']; ?></div>
        <div style="padding:8px">
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
            <?php if($inCore->isComponentEnable('content')) {
                    $new['content'] = (int)newContent('cms_content'); ?>
            <tr>
              <td><a href="index.php?view=tree"><?php echo $_LANG['AD_ARTICLES']; ?></a> <?php if($new['content']) { ?><span class="new_content">+<?php echo $new['content']?></span><?php } ?></td>
              <td width="20" align="center"><a href="index.php?view=cats&amp;do=add"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_SECTION']; ?>" width="16" height="16" border="0" /></a></td>
              <td width="20" align="center"><a href="index.php?view=content&amp;do=add"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_CREATE_ARTICLE']; ?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('photos')) {
                $new['photos'] = (int)newContent('cms_photo_files'); ?>
            <tr>
                <td><a href="index.php?view=components&amp;do=config&amp;link=photos"><?php echo $_LANG['AD_PHOTOGALLERY']; ?></a> <?php if($new['photos']) { ?><span class="new_content">+<?php echo $new['photos']?></span><?php } ?></td>
                <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=photos&amp;opt=add_album"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_ALBUM']; ?>" width="16" height="16" border="0" /></a></td>
                <td align="center"></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('video')) {
                $new['video'] = (int)newContent('cms_video_movie'); ?>
            <tr>
                <td><a href="index.php?view=components&amp;do=config&amp;link=video"><?php echo $_LANG['AD_VIDEOGALLERY']; ?></a> <?php if($new['video']) { ?><span class="new_content">+<?php echo $new['video']?></span><?php } ?></td>
                <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=video&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_CATEGORY']; ?>" width="16" height="16" border="0" /></a></td>
                <td align="center"></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('audio')) { ?>
            <tr>
                <td><a href="index.php?view=components&amp;do=config&amp;link=audio"><?php echo $_LANG['AD_IAUDIO']; ?></a></td>
                <td align="center"></td>
                <td align="center"></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('maps')) {
                $new['maps'] = (int)newContent('cms_map_items'); ?>
            <tr>
                <td><a href="index.php?view=components&amp;do=config&amp;link=maps"><?php echo $_LANG['AD_GEO_CATALOG']; ?></a> <?php if($new['maps']) { ?><span class="new_content">+<?php echo $new['maps']?></span><?php } ?></td>
                <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=maps&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_CATEGORY']; ?>" width="16" height="16" border="0" /></a></td>
                <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=maps&amp;opt=add_item"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_ADD_OBJECT']; ?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('faq')) {
                $new['faq'] = (int)newContent('cms_faq_quests'); ?>
            <tr>
              <td><a href="index.php?view=components&amp;do=config&amp;link=faq"><?php echo $_LANG['AD_A&Q']; ?></a> <?php if($new['faq']) { ?><span class="new_content">+<?php echo $new['faq']?></span><?php } ?></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=faq&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_CATEGORY']; ?>" width="16" height="16" border="0" /></a></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=faq&amp;opt=add_item"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_CREATE_QUESTION']; ?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('board')) {
                $new['board'] = (int)newContent('cms_board_items'); ?>
            <tr>
              <td><a href="index.php?view=components&amp;do=config&amp;link=board"><?php echo $_LANG['AD_BOARD']; ?></a> <?php if($new['board']) { ?><span class="new_content">+<?php echo $new['board']?></span><?php } ?></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=board&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_RUBRIC']; ?>" width="16" height="16" border="0" /></a></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=board&amp;opt=add_item"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_CREATE_ADVERT']; ?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('catalog')) {
                $new['catalog'] = (int)newContent('cms_uc_items'); ?>
            <tr>
              <td><a href="index.php?view=components&amp;do=config&amp;link=catalog"><?php echo $_LANG['AD_CATALOG']; ?></a> <?php if($new['catalog']) { ?><span class="new_content">+<?php echo $new['catalog']?></span><?php } ?></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=catalog&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_RUBRIC'];?>" width="16" height="16" border="0" /></a></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=catalog&amp;opt=add_item"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_CREATE_ITEM'];?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
            <?php if($inCore->isComponentEnable('forum')) {
                $new['forum'] = (int)newContent('cms_forum_posts'); ?>
            <tr>
              <td><a href="index.php?view=components&amp;do=config&amp;link=forum&amp;opt=list_forums"><?php echo $_LANG['AD_FORUMS']; ?></a> <?php if($new['forum']) { ?><span class="new_content">+<?php echo $new['forum']?></span><?php } ?></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=forum&amp;opt=add_cat"><img src="/admin/images/mainpage/folder_add.png" alt="<?php echo $_LANG['AD_CREATE_CATEGORY']; ?>" width="16" height="16" border="0" /></a></td>
              <td align="center"><a href="index.php?view=components&amp;do=config&amp;link=forum&amp;opt=add_forum"><img src="/admin/images/mainpage/page_add.png" alt="<?php echo $_LANG['AD_CREATE_FORUM']; ?>" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php } ?>
        </table>
        </div>
        </div>
        <div class="small_box">
            <div class="small_title"><?php echo $_LANG['AD_USERS']; ?></div>
            <div style="padding:8px">
              <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                  <td width="16"><img src="images/icons/hmenu/users.png" width="16" height="16" /></td>
                  <td><a href="index.php?view=users"><?php echo $_LANG['AD_FROM_USERS']; ?></a> &mdash; <?php echo $inDB->rows_count('cms_users', 'is_deleted=0'); ?></td>
                </tr>
                <tr>
                  <td><img src="images/icons/hmenu/users.png" width="16" height="16" /></td>
                  <td><?php echo $_LANG['AD_NEW_USERS_TODAY']; ?> &mdash; <?php echo (int)$inDB->get_field('cms_users', "DATE_FORMAT(regdate, '%d-%m-%Y') = DATE_FORMAT(NOW(), '%d-%m-%Y') AND is_deleted = 0", 'COUNT(id)'); ?></td>
                </tr>
                <tr>
                  <td><img src="images/icons/hmenu/users.png" width="16" height="16" /></td>
                  <td><?php echo $_LANG['AD_NEW_USERS_THEES_WEEK']; ?> &mdash; <?php echo (int)$inDB->get_field('cms_users', "regdate >= DATE_SUB(NOW(), INTERVAL 7 DAY)", 'COUNT(id)'); ?></td>
                </tr>
                <tr>
                  <td><img src="images/icons/hmenu/users.png" width="16" height="16" /></td>
                  <td><?php echo $_LANG['AD_NEW_USERS_THEES_MONTH']; ?> &mdash; <?php echo (int)$inDB->get_field('cms_users', "regdate >= DATE_SUB(NOW(), INTERVAL 1 MONTH)", 'COUNT(id)'); ?></td>
                </tr>
              </table>
            </div>
        </div>
        <div class="small_box">
            <div class="small_title"><strong><?php echo $_LANG['AD_USERS_ONLINE']; ?></strong></div>
            <div style="font-size:10px;margin:8px;">
              <?php echo cpWhoOnline();?>
            </div>
        </div>
        </td>
          <td width="" valign="top" style="">
            <?php if($do == 'utmplacemarks') { ?>

            <div class="small_box">
                      <div class="small_title"><strong><?php echo "Utm метки" ?></strong></div>
                      <div id="">
                          <div id="">
                              <?php
                              $page = $inCore->request('page', 'int', 1);
                              $perpage = 12;
                              $sql = 'SELECT * FROM utm_placemarks';

                              $result = $inDB->query($sql);

                              $countRows = $inDB->num_rows($result);
                              $pages = ceil($countRows / $perpage);
                              $pages_url = '/admin/index.php?do=utmplacemarks&page=%page%';
                              $pagebar = cmsPage::getPagebar($countRows, $page, $perpage, $pages_url);
    //                          echo cmsPage::getPagebar($total, $page, $perpage, $base_uri.'&hide_cats='.$hide_cats.'&title='.$title_part.'&art_no='.$art_no_part.'&orderby='.$orderby.'&orderto='.$orderto.'&vendor_id='.$vendor_id.'&cat_id='.$category_id.'&page=%page%');

                              if ($countRows) {
                                  $inDB->limit(12);
                                  $inDB->orderBy('id', 'DESC');
                                  $offset = ($page - 1) * $perpage;
                                  $limit = "$offset, $perpage";
                                  $utmPlacemarks = $inDB->get_table('utm_placemarks', '', '*', 'DESC', $limit);



                                  echo "<table class='table table-bordered'><tr><th>id</th><th>utm_source</th><th>utm_medium</th><th>utm_campaign</th><th>utm_term</th><th>utm_content</th><th>Дата</th><th>utm_nooverride</th><th>utm_referrer</th></tr>";

                                  foreach ($utmPlacemarks as $utmPlacemark) {
                                      echo "<tr><td>{$utmPlacemark['id']}</td><td title='указывает на источник трафика'>{$utmPlacemark['utm_source']}</td><td title='определяет тип трафика. Например, при размещении объявлений по модели оплаты за клик в этом параметре обычно прописывают значение «cpc»'>{$utmPlacemark['utm_medium']}</td><td title='этот параметр нужен, чтобы указать к какой рекламной кампании относится ссылка'>{$utmPlacemark['utm_campaign']}</td><td title='эта метка нужна для определения ключевого слова, по которому показывалось ваше рекламное объявление'>{$utmPlacemark['utm_term']}</td>
    <td title='помогает различать объявления, если другие параметры идентичны'>{$utmPlacemark['utm_content']}</td><td>{$utmPlacemark['created_at']}</td><td title='с помощью этой метки можно определить, где произошло первое касание с клиентом при отслеживании ассоциированных конверсий'>{$utmPlacemark['utm_nooverrid']}</td><td title='помогает корректно отслеживать и учитывать переходы при наличии Javascript-редиректа. Эта метка понятна только для Яндекс.Метрики'>{$utmPlacemark['utm_referrer']}</td></tr>";

                                  }
                                  echo "</table>";
                              }
                              ?>
                          </div>
                      </div>
                  </div>
          <?php } else { ?>

            <div class="small_box">
                <div class="small_title"><strong><?php echo $_LANG['AD_LATEST_EVENTS']; ?></strong></div>
                <div id="actions_box">
                    <div id="actions">
                        <?php

                            $inActions = cmsActions::getInstance();

                            $inActions->showTargets(true);
                            $inDB->limitPage(1, 30);
                            $actions = $inActions->getActionsLog();

                            $tpl_file   = 'admin/actions.php';
                            $tpl_dir    = file_exists(TEMPLATE_DIR.$tpl_file) ? TEMPLATE_DIR : DEFAULT_TEMPLATE_DIR;

                            include($tpl_dir.$tpl_file);

                        ?>
                    </div>
                </div>
            </div>

            <?php } ?>
          </td>

        <td width="325" valign="top" style=""><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="100" valign="top">
            <?php
                $new_quests 	= $inDB->rows_count('cms_faq_quests', 'published=0');
                $new_content 	= $inDB->rows_count('cms_content', 'published=0 AND is_arhive = 0');
                $new_catalog 	= $inDB->rows_count('cms_uc_items', 'on_moderate=1');
            ?>
            <?php if ($new_quests || $new_content || $new_catalog){ ?>
                <div class="small_box">
                    <div class="small_title">
                        <span class="attention">
                            <strong><?php echo $_LANG['AD_FROM_MODERATION']; ?></strong>
                        </span>
                    </div>
                    <div style="padding:10px">
                        <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                          <?php if ($new_content){ ?>
                          <tr>
                            <td width="16"><img src="images/updates/content.gif" width="16" height="16" /></td>
                            <td><a href="index.php?view=tree&orderby=pubdate&orderto=desc&only_hidden=1"><?php echo $_LANG['AD_ARTICLES']; ?></a> (<?php echo $new_content; ?>)</td>
                          </tr>
                          <?php } ?>
                          <?php if ($new_quests){ ?>
                          <tr>
                            <td width="16"><img src="images/updates/quests.gif" width="16" height="16" /></td>
                            <td><a href="index.php?view=components&amp;do=config&amp;link=faq&amp;opt=list_items"><?php echo $_LANG['AD_QUESTIONS']; ?></a> (<?php echo $new_quests; ?>)</td>
                          </tr>
                          <?php } ?>
                          <?php if ($new_catalog){ ?>
                          <tr>
                            <td width="16"><img src="images/updates/content.gif" width="16" height="16" /></td>
                            <td><a href="index.php?view=components&amp;do=config&amp;link=catalog&amp;opt=list_items&amp;on_moderate=1"><?php echo $_LANG['AD_CATALOG_ITEMS']; ?></a> (<?php echo $new_catalog; ?>)</td>
                          </tr>
                          <?php } ?>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <?php if ($inCore->isComponentInstalled('rssfeed')){ ?>
            <div class="small_box">
                <div class="small_title"><?php echo $_LANG['AD_RSS']; ?></div>
                <div style="padding:10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                  <tr>
                    <td width="16"><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/comments/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_COMENT']; ?> </a></td>
                    <td width="16"><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/blogs/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_BLOGS']; ?></a></td>
                  </tr>
                  <tr>
                  <tr>
                    <td width="16"><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/forum/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_FORUM']; ?></a></td>
                    <td width="16"><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/catalog/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_CATALOG']; ?></a></td>
                  </tr>
                  <tr>
                    <td><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/content/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_CONTENT']; ?></a> </td>
                    <td><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/board/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_ADVERTS']; ?></a> </td>
                  </tr>
                  <tr>
                    <?php if($inCore->isComponentEnable('video')) { ?>
                        <td><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                        <td><a href="/rss/video/all/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_VIDEO']; ?></a> </td>
                    <?php } else { ?>
                        <td></td>
                        <td></td>
                    <?php } ?>
                    <?php if($inCore->isComponentEnable('audio')) { ?>
                    <td><img src="/images/markers/rssfeed.png" width="16" height="16" /></td>
                    <td><a href="/rss/audio/artists/feed.rss" id="rss_link"><?php echo $_LANG['AD_RSS_AUDIO']; ?></a> </td>
                    <?php } else { ?>
                        <td></td>
                        <td></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><img src="/admin/images/icons/config.png" width="16" height="16" /></td>
                    <td><a href="index.php?view=components&amp;do=config&amp;id=<?php echo $inDB->get_field('cms_components', "link='rssfeed'", 'id'); ?>" id="rss_link"><?php echo $_LANG['AD_RSS_TUNING']; ?></a></td>
                  </tr>
                </table>
                </div>
            </div>
            <?php } ?>

            <div class="small_box">
              <div class="small_title"><?php echo $_LANG['AD_ICMS_RAVE']; ?></div>
                <ul>
                  <li><a href="http://www.instantcms.ru/"><strong><?php echo $_LANG['AD_ICMS_OFFICIAL']; ?></strong></a></li>
                  <li><a href="http://www.instantcms.ru/wiki"><?php echo $_LANG['AD_ICMS_DOCUMENTATION']; ?></a></li>
                  <li><a href="http://www.instantcms.ru/forum"><?php echo $_LANG['AD_ICMS_FORUM']; ?></a></li>
                </ul>
            </div>
            <div class="small_box">
                <div class="small_title"><?php echo $_LANG['AD_PREMIUM']; ?></div>
                <div class="advert_iaudio"><a href="http://www.instantvideo.ru/software/iaudio.html"><strong>iAudio</strong></a> &mdash; <?php echo $_LANG['AD_AUDIO_GALERY']; ?></div>
                <div class="advert_billing"><a href="http://www.instantcms.ru/billing/about.html"><strong><?php echo $_LANG['AD_BILLING']; ?></strong></a> &mdash; <?php echo $_LANG['AD_GAIN']; ?></div>
                <div class="advert_inmaps"><a href="http://www.instantmaps.ru/"><strong>InstantMaps</strong></a> &mdash; <?php echo $_LANG['AD_OBJECT_TO_MAP']; ?></div>
                <div class="advert_inshop"><a href="http://www.instantcms.ru/blogs/InstantSoft/professionalnyi-magazin-dlja-InstantCMS.html"><strong>InstantShop</strong></a> &mdash; <?php echo $_LANG['AD_SHOP']; ?></div>
                <div class="advert_invideo"><a href="http://www.instantvideo.ru/software/instantvideo.html"><strong>InstantVideo</strong></a> &mdash; <?php echo $_LANG['AD_VIDEO_GALERY']; ?></div>
            </div>
              </td>
          </tr>
        </table></td>
      </tr>
    </table>
<?php } ?>
  <div class="row justify-content-center">
    <div>
      <?= $pagebar; ?>
    </div>
  </div>
<?php
	return true;
}
?>