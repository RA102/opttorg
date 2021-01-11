<?php
if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); }
/******************************************************************************/
//                              Карта Сайта v2.1                              //
//          Разработка Компонентов, Плагинов и Модулей для Instant CMS:       //
//                      instantcms-development@ds-soft.ru                     //
/******************************************************************************/

cmsCore::loadModel('sitemap');
$model = new cms_model_sitemap();
$components = $model->getSMComponents();
$id = cmsCore::request("id", "int", 0);
cpAddPathway("Карта Сайта v2.1", "?view=components&do=config&id=".$id);
echo "<h3>Карта Сайта v2.1</h3>";
$opt = cmsCore::request("opt", "str", "config");

$messages = cmsCore::getsessionmessages();
if ($messages){
    echo "\t<div class=\"sess_messages\">\n\t\t";
    foreach ( $messages as $message ){
        echo $message;
    }
    echo "\t</div> \n\t";
}

if($opt == "saveconfig"){
    $cfg = array();
    foreach($components as $component){
        $cfg[$component['link']]['published'] = cmsCore::request($component['link']."_map", "int", 0);
        $cfg[$component['link']]['time'] = cmsCore::request($component['link']."_time", "int", 0);
        $cfg[$component['link']]['full_time'] = cmsCore::request($component['link']."_full_time", "int", 1) ? cmsCore::request($component['link']."_full_time", "int", 1) : 1;
        $xml_file = PATH . '/components/sitemap/sm_components/' . $component['link'] . ".xml";
        if (file_exists($xml_file)){
            $backend = simplexml_load_file($xml_file);
            foreach($backend->params->param as $param){
                $name = (string)$param['name'];
                $type = (string)$param['type'];
                $default = iconv('utf-8', 'cp1251', (string)$param['default']);
                if ($type == 'flag' && $default === 'on') { $default = 1; }
                if ($type == 'flag' && $default === 'off') { $default = 0; }
                switch($param['type']){
                    case 'number': $value = cmsCore::request($component['link']."_".$name, 'int', $default); break;
                    case 'string': $value = cmsCore::request($component['link']."_".$name, 'str', $default); break;
                    case 'flag': $value = cmsCore::request($component['link']."_".$name, 'int', $default); break;
                    case 'list': $value = cmsCore::request($component['link']."_".$name, 'str', $default); break;
                    case 'list_db': $value = (is_array($_POST[$component['link']."_".$name]) ? cmsCore::request($component['link']."_".$name, 'array', $default) : cmsCore::request($component['link']."_".$name, 'str', $default)); break;
                }
                $cfg[$component['link']]['config'][$name] = $value;
            }
        }
    }
    $cfg['host'] = HOST;
    $inCore->saveComponentConfig("sitemap", $cfg);
    cmsCore::addsessionmessage("Настройки успешно сохранены.", "success");
    cmsCore::redirect("?view=components&do=config&id=".$id."&opt=config");
}

if ($opt == "config"){
    $cfg = $inCore->loadComponentConfig("sitemap");
    cmsCore::includeFile("components/sitemap/classes/formgen.class.php");
    $formGen = new cmsFormGen($xml_file, $cfg); ?>
<form action="index.php?view=components&do=config&id=<?php echo (int)$_REQUEST['id'];?>" method="post" name="optform" target="_self" id="form1">
    <table width="600px" border="0" cellpadding="10" cellspacing="0" class="proptable">
        <?php foreach($components as $component){
            $xml_file = PATH . '/components/sitemap/sm_components/' . $component['link'] . ".xml";
            $formGen->setConfig($xml_file, $cfg[$component['link']]['config'], $component['link']);
        ?>
        <tr <?php if ($component['published']==0){ ?>style="display:none;"<?php } ?>>
            <td>
                <table width="700px" border="0" cellpadding="10" cellspacing="0" class="proptable">
                    <tr valign="top">
                        <td rowspan="2" align="left"><strong>Генерирование карты для "<?php echo $component['title']; ?>":</strong></td>
                        <td width="300px" align="right">
                            Разрешено<input name="<?php echo $component['link']; ?>_map" type="radio" value="1" <?php if ($cfg[$component['link']]['published'] and $component['published']==1) {echo 'checked';}?> onclick="$('#<?php echo $component['link'];?>_config').show();">
                            Запрещено<input name="<?php echo $component['link']; ?>_map" type="radio" value="0"<?php if (!$cfg[$component['link']]['published'] or !$component['published']) {echo 'checked';}?> onclick="$('#<?php echo $component['link'];?>_config').hide();">
                        </td>
                        <td width="20px" align="right">
                            <input name="<?php echo $component['link']; ?>_time" type="text" maxlength="3" value="<?php echo $cfg[$component['link']]['time']; ?>" style="width:25px;" title="Период генерации последнего файла карты (в часах)">
                        </td>
                        <td width="20px" align="right">
                            <input name="<?php echo $component['link']; ?>_full_time" type="text" maxlength="3" value="<?php echo $cfg[$component['link']]['full_time']; ?>" style="width:25px;" title="Период полной перегенерации карт (в днях)">
                        </td>
                    </tr>
                    <?php if (file_exists($xml_file)){ ?>
                        <tr id="<?php echo $component['link'];?>_config" <?php if (!$cfg[$component['link']]['published']) { ?>style="display:none;"<?php } ?>>
                            <td colspan="2"><?php echo $formGen->getHTML(); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <?php } ?>
    </table>
    <p>
        <input name="opt" type="hidden" value="saveconfig" />
        <input name="save" type="submit" id="save" value="Сохранить" />
        <input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
    </p>
</form>
<?php
}
?>