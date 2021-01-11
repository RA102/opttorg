<?php
    global $inCore;
    global $inDB;
    global $inUser;
    global $_LANG;
    global $cat_id;
    global $cat;
    global $allowed_cats;
    global $item;
    global $item_id;
    global $city;
    global $country;
    global $do;
    global $location;

    $inDB = cmsDatabase::getInstance();

    $model = new cms_model_maps();

    $cfg = $model->getConfig();

    $location = $model->detectUserLocation();

    if ($cfg['can_edit_cats']){
        $allowed_cats = $model->getAllowedCats();
    }

    $inCore->loadLib('tags');

?>
<style>
#edit-map-item table td {padding:3px;vertical-align:top;}
#edit-map-item table table td {padding:3px;vertical-align:middle;}
.addr_block {padding:5px;background:#f9f9f9;margin-top:10px;margin-bottom:10px;margin-right:10px;}
</style>
<div id="edit-map-item">
<h1 class="con_heading"><?php echo ($do=='add_item' ? $_LANG['MAPS_ADD_OBJECT'] : $_LANG['MAPS_EDIT_OBJECT']); ?></h1>

<form action="/maps/<?php if ($do=='add_item') { echo 'submit_item'.$cat_id; } else { echo 'update_item'.$cat_id.'-'.$item_id; } ?>" method="post" enctype="multipart/form-data" name="addform" id="addform">
                <link type='text/css' href='/components/maps/city_select/nyromodal.css' rel='stylesheet' media='screen' />
                <script src='/components/maps/city_select/nyromodal.js' type='text/javascript'></script>
                <script src='/components/maps/city_select/select.js' type='text/javascript'></script>
				<div style="">	
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="addr_coord" rel="<?php echo $addr_id; ?>">
                    <tr>
                        <td>
                            <div style="margin-bottom:5px">
                                <strong>Название объекта</strong>
                            </div>
                            <div style="padding:5px;background:#f9f9f9;margin-top:10px;margin-bottom:10px;margin-right:10px;">
                                <input name="title" type="text" id="title" style="width:97%" value="<?php echo htmlspecialchars($item['title']);?>" />
                            </div>
                        </td>
                        <?php if ($cfg['can_edit_cats']){ ?>
                        <td width="50%">
                            <div style="margin-bottom:13px"> 
                                <strong>Категории каталога</strong>
                            </div>

                            <div id="additional_cats_list" style="padding:9px 6px;background:#f9f9f9;margin-top:10px;margin-bottom:10px;margin-right:10px;">
                                <span class="item_main_cat">
                                    <?php echo $cat['title']; ?>
                                </span>
                                <?php if ($allowed_cats){ ?>
                                    <span style="padding-left:15px">
                                        <a class="ajaxlink" href="javascript:selectCats()">Ещё</a>
                                    </span>
                                <?php } ?>
                            </div>

                            <div id="additional_cats" style="display:none">

                                    <div style="padding:10px">

                                    <h3 style="margin:0px">Дополнительные категории</h3>

                                    <ul id="inmaps_tree">

                                    <?php $last_level = 1; foreach($allowed_cats as $c){  ?>

                                        <?php if ($c['NSLevel'] < $last_level) { ?>
                                            <?php $tail = $last_level - $c['NSLevel']; ?>
                                            <?php for($t=0; $t<$tail; $t++){ ?>
                                                </ul></li>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($c['NSRight'] - $c['NSLeft'] == 1) { ?>
                                            <li>
                                                <label>
                                                    <?php if ($c['id'] != $cat_id) { ?>
                                                        <input type="checkbox" name="cats[]" value="<?php echo $c['id']; ?>" <?php if (in_array($c['id'], $item['cats'])) { ?>checked="checked"<?php } ?> />
                                                    <?php } ?>
                                                    <span class="folder"><?php echo $c['title']; ?></span>
                                                </label>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <label>
                                                    <?php if ($c['id'] != $cat_id) { ?><input type="checkbox" name="cats[]" value="<?php echo $c['id']; ?>" /><?php } ?> <span class="folder"><?php echo $c['title']; ?></span>
                                                </label>
                                                <ul>
                                        <?php } ?>

                                        <?php $last_level = $c['NSLevel']; ?>

                                    <?php } ?>
                                    </ul></div>

                                    <div style="margin:10px">
                                        <input type="button" value="Выбрать" onclick="closeCatsSelect()" />
                                    </div>

                            </div>

                            <script type="text/javascript">buildCatsList();</script>

                        </td>
                        <?php } ?>
                    </tr>
                </table>
				</div>
				<div style="">
                <div style="margin-top:10px"><strong>Адреса и координаты объекта</strong></div>

                    <?php if ($do=='add_item') { $markers =  array('1'=>array()); } ?>
                    <?php if ($do=='edit_item') { $markers =  $item['markers']; } ?>

                    <div id="addresses">

                    <?php foreach($markers as $addr_id=>$addr){ ?>

                    <?php if ($do=='add_item'){ $addr['addr_country'] = $cfg['country']; } ?>
                    <?php if ($do=='add_item' && $cfg['mode'] == 'city'){ $addr['addr_city'] = $cfg['city']; } ?>

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="addr_coord" rel="<?php echo $addr_id; ?>">
                        <tr>
                            <!-- ADDRESS -->
                            <td valign="top" width="50%">

                                <div class="addr_block">

                                    <input type="hidden" class="addr_id" name="addr_id[]" value="<?php echo $addr_id; ?>" />

                                    <?php if ($cfg['mode'] == 'city' || $cfg['mode'] == 'country') { ?>
                                        <input type="hidden" class="addr_country" name="addr_country[]" value="<?php echo $addr['addr_country']; ?>" />
                                    <?php } ?>

                                    <table cellspacing="0" cellpadding="5" border="0" width="100%">
                                        <?php if ($cfg['mode'] == 'world'){ ?>
                                        <tr>
                                            <td width="40%">Страна:</td>
                                            <td>
                                                <input type="text" class="addr_country" name="addr_country[]" value="<?php echo $addr['addr_country']; ?>" />
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td width="40%">Город:</td>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td><input type="text" class="addr_city" name="addr_city[]" value="<?php echo $addr['addr_city']; ?>" /></td>
                                                        <td>
                                                            <a href="javascript:" onclick="selectCityEdit('<?php echo $cfg['city_sel']; ?>', this)" rel="<?php echo $addr_id; ?>" class="addr_city_sel" title="Выбрать город..." style="padding-left:4px">
                                                                <img src="/components/maps/images/browse.png" border="0" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="addr_prefix" name="addr_prefix[]">
                                                    <?php foreach($cfg['prefixes'] as $full=>$short){ ?>
                                                        <option value="<?php echo $short; ?>" <?php if($addr['addr_prefix']==$short) { ?>selected="selected"<?php } ?>><?php echo $full; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="addr_street" name="addr_street[]" type="text" id="street" style="width:99%" value="<?php echo htmlspecialchars($addr['addr_street']);?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Дом, офис</td>
                                            <td>
                                                <input class="addr_house" name="addr_house[]" type="text" id="house" style="width:40px !important;display:inline !important;" title="дом" value="<?php echo htmlspecialchars($addr['addr_house']);?>"/>
                                                -
                                                <input class="addr_room" name="addr_room[]" type="text" id="room" style="width:40px !important;display:inline !important;" title="офис/комната" value="<?php echo htmlspecialchars($addr['addr_room']);?>"/>

                                                <?php if ($do=='edit_item' && sizeof($markers)>1){ ?>
                                                    <label title="Удалить этот адрес после сохранения" style="color:#666" class="addr_del">
                                                        <input type="checkbox" name="addr_del[]" value="<?php echo $addr_id; ?>" />
                                                        Удалить
                                                    </label>
                                                <?php } ?>

                                                <a href="javascript:cancelAddr()" title="Удалить этот адрес" class="addr_del_link" style="display:none;margin-left:10px">Отмена</a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Телефон:</td>
                                            <td>
                                                <input type="text" class="addr_phone" name="addr_phone[]" value="<?php echo $addr['addr_phone']; ?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                            <!-- COORDINATES -->
                            <td valign="top" width="50%">

                                <div class="addr_block">

                                    <table cellspacing="0" cellpadding="5" border="0" width="100%">
                                        <tr>
                                            <td width="70">Долгота:</td>
                                            <td><input type="text" class="addr_lng" name="addr_lng[]" value="<?php echo $addr['lng']; ?>" style="width:99%"/></td>
                                        </tr>
                                        <tr>
                                            <td>Широта:</td>
                                            <td><input type="text" class="addr_lat" name="addr_lat[]" value="<?php echo $addr['lat']; ?>" style="width:99%"/></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <a href="javascript:detectCoords(<?php echo $addr_id; ?>)" class="addr_find_coord">
                                                    Найти по адресу
                                                </a>
                                                <a href="javascript:" onclick="setMarkerOnMap(<?php echo $addr_id; ?>, '<?php echo $cfg['selmap_lng']; ?>', '<?php echo $cfg['selmap_lat']; ?>')" class="select_marker_pos">
                                                    Указать на карте...
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </td>
                        </tr>
                    </table>

                    <?php } ?>

                    </div>
				</div>
                    <?php if ($cfg['multiple_addr'] || $inUser->is_admin){ ?>

                    <p id="add_addr_link">
                        <a href="javascript:addAddress()" class="btn btn-default">Добавить адрес...</a>
                    </p>

                    <?php } ?>

                    <div id="marker_place_window" style="display:none">

                        <div class="addr_toolbar" style="margin:10px 0">
    <div class="input-group">
      <input type="text" class="addr_field" value="<?php echo $city; ?>" placeholder="Центр карты..." />
      <span class="input-group-btn">
        <input type="button" value="Показать" onclick="centerMarkerMap($('.addr_field').val())" />
      </span>
    </div>						
                        </div>

                        <div id="marker_map" style="width:600px;height:400px;border:solid 1px #000"></div>

                        <p style="text-align:center;padding:10px 0;">
                            Перетащите маркер в нужное место карты и нажмите кнопку
                            <input type="button" name="save_pos" value="Сохранить" onClick="closeMarkerMap()" />
                        </p>

                    </div>

                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td valign="top" width="50%">

                            <!-- CHARS -->
                            <div style="margin-top:10px"><strong>Характеристики объекта</strong></div>
                            <div id="item_chars" style="padding:5px;background:#f9f9f9;margin-top:10px;margin-bottom:10px;margin-right:10px;">

                                <?php
                                //характеристики
                                if ($item['id']){
                                    $item['chars'] = array();
                                    $chrres       = $inDB->query("SELECT char_id, val FROM cms_map_chars_val WHERE item_id={$item_id}");
                                    if (mysqli_num_rows($chrres)){
                                        while($char = mysqli_fetch_assoc($chrres)){
                                            $item['chars'][$char['char_id']] = $char['val'];
                                        }
                                    }
                                }

                                $chars = $model->getCatChars($cat_id);

                                if($chars){
                                    //ob_start();
                                    ?>
                                    <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <?php
                                    foreach($chars as $id=>$char){
                                        ?>
                                        <tr>
                                            <td width="40%"><?php echo $char['title']; ?></td>
                                            <td align="right" width="60%">

                                                <?php if ($char['fieldtype']=='file'){ //Файл ?>

                                                    <?php if ($item['chars'][$char['id']]){ $filedata = $inCore->yamlToArray($item['chars'][$char['id']]); } ?>

                                                    <div id="cfile<?php echo $char['id']; ?>" style="display:<?php if ($filedata){ ?>none<?php } else { ?>block<?php } ?>">
                                                        <input type="file" name="char_file<?php echo $char['id']; ?>" />
                                                    </div>

                                                    <?php if ($filedata) { ?>
                                                        <div style="float:left">
                                                            <a href="#"><?php echo $filedata['name']; ?></a> <?php echo round($filedata['size']/1024); ?> Кб
                                                            <input type="button" style="margin-left:10px" value="Заменить" onclick="$(this).parent('div').hide();$('#cfile<?php echo $char['id']; ?>').show()">
                                                        </div>
                                                    <?php } ?>

                                                    <?php continue; ?>

                                                <?php } ?>

                                                <?php if ($char['fieldtype']=='user'){ //Профиль пользователя ?>

                                                    <?php

                                                        if (!$users_list){
                                                            $sql    = "SELECT login,nickname FROM cms_users WHERE is_deleted=0";
                                                            $result = $inDB->query($sql);

                                                            if ($inDB->num_rows($result)){
                                                                while($user = $inDB->fetch_assoc($result)){
                                                                    $users_list[] = array(
                                                                                            'nickname'=>$user['nickname'],
                                                                                            'hash'=>$user['login'] . '|' . $user['nickname']
                                                                                         );
                                                                }
                                                            }
                                                        }

                                                    ?>

                                                    <select name="chars[<?php echo $char['id']; ?>]" style="width:100%">
                                                        <?php foreach($users_list as $user){ ?>
                                                            <option value="<?php echo trim($user['hash']); ?>" <?php if(trim($user['hash'])==trim($default)){ echo 'selected="selected"'; } ?>>
                                                                <?php echo trim($user['nickname']); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                    <?php continue; ?>

                                                <?php } ?>

                                                <?php if ($char['fieldtype']=='cbox'){ //Чекбоксы ?>

                                                    <?php
                                                        $values = explode("\n", $char['values']);
                                                        if (isset($item['chars'][$char['id']])){
                                                            $checked = trim($item['chars'][$char['id']], '|');
                                                            $checked = explode('|', $checked);
                                                        }
                                                    ?>

                                                    <div style="text-align:left">
                                                    <?php foreach($values as $value){ ?>
                                                        <label>
                                                            <input type="checkbox" name="chars[<?php echo $char['id']; ?>][]" value="<?php echo trim($value); ?>" <?php if(in_array(trim($value), $checked)){ echo 'checked="checked"'; } ?> />
                                                            <?php echo $value; ?>
                                                        </label><br/>
                                                    <?php } ?>
                                                    </div>

                                                    <?php continue; ?>

                                                <?php } ?>

                                                <?php //Текстовое поле
                                                    if (!$char['values']){
                                                        if (!isset($item['chars'][$char['id']])){
                                                            if ($char['fieldtype']=='link'){ $default = 'http://'; } else { $default = ''; }
                                                        } else {
                                                            $default = $item['chars'][$char['id']];
                                                        }
                                                        ?>
                                                        <input type="text" name="chars[<?php echo $char['id']; ?>]" style="width:99%" value="<?php echo $default; ?>"/>
                                                <?php } ?>

                                                <?php //Список выбора
                                                    if ($char['values']){
                                                        $values = explode("\n", $char['values']);
                                                        if (isset($item['chars'][$char['id']])){
                                                            $default = $item['chars'][$char['id']];
                                                        }
                                                        ?>
                                                        <select name="chars[<?php echo $char['id']; ?>]" style="width:100%">
                                                            <?php foreach($values as $value){ ?>
                                                                <option value="<?php echo trim($value); ?>" <?php if(trim($value)==trim($default)){ echo 'selected="selected"'; } ?>><?php echo trim($value); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                <?php } ?>

                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </table>
                                    <?php

                                } else { echo 'Нет характеристик назначенных для этой категории'; }

                                //echo str_replace("\t", '', ob_get_clean());
                                ?>
                            </div>
                        </td>
                        <!-- CONTACTS -->
                        <td valign="top" width="50%">

                            <div style="margin-top:10px"><strong>Контакты объекта</strong></div>

                            <div id="item_chars" style="padding:5px;background:#f9f9f9;margin-top:10px;margin-bottom:10px;margin-right:10px;">
                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="120">Телефон:</td>
                                        <td><input type="text" name="contacts[phone]" value="<?php echo $item['contacts']['phone']; ?>" style="width:99%" /></td>
                                    </tr>
                                    <tr>
                                        <td>Факс:</td>
                                        <td><input type="text" name="contacts[fax]" value="<?php echo $item['contacts']['fax']; ?>" style="width:99%" /></td>
                                    </tr>
                                    <tr>
                                        <td>Веб-сайт:</td>
                                        <td><input type="text" name="contacts[url]" value="<?php echo str_replace('/go/url=', '', $item['contacts']['url']); ?>" style="width:99%" /></td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail:</td>
                                        <td><input type="text" name="contacts[email]" value="<?php echo $item['contacts']['email']; ?>" style="width:99%" /></td>
                                    </tr>
                                    <tr>
                                        <td>ICQ:</td>
                                        <td><input type="text" name="contacts[icq]" value="<?php echo $item['contacts']['icq']; ?>" style="width:99%" /></td>
                                    </tr>
                                    <tr>
                                        <td>Skype:</td>
                                        <td><input type="text" name="contacts[skype]" value="<?php echo $item['contacts']['skype']; ?>" style="width:99%" /></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

                <div style="margin-top:12px"><strong>Краткое описание</strong></div>
                <div><?php $inCore->insertEditor('shortdesc', $item['shortdesc'], '200', '99%'); ?></div>

                <div style="margin-top:12px"><strong>Подробное описание</strong></div>
                <div><?php $inCore->insertEditor('description', $item['description'], '400', '99%'); ?></div>

                <div style="margin-top:12px"><strong>Теги объекта</strong></div>
                <div><input name="tags" type="text" id="tags" style="width:99%" value="<?php if (isset($item['id'])) { echo cmsTagLine('maps', $item['id'], false); } ?>" /><br /></div>

                <?php
                    if ($do=='edit_item'){
                        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/photos/small/map'.$item['id'].'.jpg')){
                            ?>
                                <div style="margin-top:3px;margin-bottom:3px;padding:10px;border:solid 1px gray;text-align:center">
                                    <img src="/images/photos/small/map<?php echo $item['id']; ?>.jpg" border="0" />
                                    <div>
                                        <label><input type="checkbox" name="img_delete[]" class="input" value="map<?php echo $item['id']; ?>.jpg" /> Удалить</label>
                                    </div>
                                </div>
                            <?php
                        }
                        if ($item['images']){
                            ?>
                            <div style="margin-top:3px;margin-bottom:3px;padding:10px;border:solid 1px gray;overflow:hidden">
                                <div style="clear:both" class="hinttext">Отмеченные изображения будут удалены</div>
                                <?php
                                foreach($item['images'] as $num=>$filename){
                                    ?>
                                        <div style="width:67px;height:80px;float:left;text-align:center">
                                            <img src="/images/photos/small/<?php echo $filename; ?>" width="64" height="64" border="0" />
                                            <div style="width:45px;background:url(/admin/components/maps/images/del_small.gif) no-repeat right center;">
                                                <input type="checkbox" name="img_delete[]" class="input" value="<?php echo $filename; ?>" />
                                            </div>
                                        </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                ?>

                <div style="margin-top:15px"><strong>Изображение</strong></div>
                <div style="margin-bottom:4px">
                    <input type="file" name="imgfile" style="width:100%" />
                </div>
                <table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:4px">
                    <tr>
                        <td><input type="checkbox" id="auto_thumb" name="auto_thumb" value="1" checked /></td>
                        <td> <label for="auto_thumb">Создать маленькое автоматически</label></td>
                    </tr>
                </table>

                <div style="margin-top:15px"><strong>Маленькое изображение</strong></div>
                <div style="margin-bottom:10px">
                    <input type="file" name="imgfile_small" style="width:100%" />
                </div>

                <div style="margin-top:15px">
                    <strong>Дополнительные изображения</strong><br/>
                    <span class="hinttext">Можно выбрать несколько файлов</span>
                </div>
                <div style="margin-bottom:20px">
                    <input type="file" class="multi" name="upfile[]" id="upfile"/>
                </div>

                <?php if ($cfg['events_add_any']==2){ ?>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0">
                        <tr>
                            <td width="24" valign="top">
                                <input type="checkbox" name="is_public_events" id="is_public_events" value="1" <?php if ($item['is_public_events']) { echo 'checked="checked"'; } ?>/>
                            </td>
                            <td valign="top"><label for="is_public_events">Разрешить другим пользователям добавлять события для этого объекта</label></td>
                        </tr>
                    </table>
                <?php } ?>

    <p>
        <input name="add_mod" type="submit" id="add_mod" value="Сохранить объект" />
        <input name="back2" type="button" id="back2" value="Отмена" onclick="window.location.href='/maps/<?php echo $cat['seolink']; ?>';"/>
        <?php
            if ($do=='edit_item'){
                echo '<input name="item_id" type="hidden" value="'.$item['id'].'" />';
            }
        ?>
    </p>
</form>
</div>