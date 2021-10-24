<?php
if (!defined('VALID_CMS_ADMIN')) {
    die('ACCESS DENIED');
}

$opt = cmsCore::request('opt', 'str', 'config');

$toolmenu[] = array('icon' => 'save.gif', 'title' => $_LANG['SAVE'], 'link' => 'javascript:document.optform.submit();');
$toolmenu[] = array('icon' => 'cancel.gif', 'title' => $_LANG['CANCEL'], 'link' => '?view=components');

cpToolMenu($toolmenu);

$cfg = $inCore->loadComponentConfig('sphinx');

if ($opt == 'saveconfig') {

    if (!cmsCore::validateForm()) {
        cmsCore::error404();
    }

    $cfg = array();
    $cfg['host'] = cmsCore::request('addsite', 'int');
    $cfg['port'] = cmsCore::request('maxitems', 'int');
    $cfg['index'] = cmsCore::request('icon_on', 'int');
    $cfg['icon_url'] = cmsCore::request('icon_url', 'str', '');

    $inCore->saveComponentConfig('rssfeed', $cfg);

    cmsCore::addSessionMessage($_LANG['AD_CONFIG_SAVE_SUCCESS'], 'success');

    cmsCore::redirectBack();

}

?>
<form action="index.php?view=components&amp;do=config&amp;id=<?php echo $id; ?>" method="post" name="optform" target="_self" id="form1">
    <input type="hidden" name="csrf_token" value="<?php echo cmsUser::getCsrfToken(); ?>"/>
    <table width="650" border="0" cellpadding="10" cellspacing="0" class="proptable">
        <tr>
            <td colspan="2" bgcolor="#EBEBEB"><strong>Настройки SphinxSearch</strong></td>
        </tr>
        <tr>
            <td>Host:</td>
            <td width="300" valign="top">
                <input class="input" type="text" value="<?php echo $cfg['host'] ?>"/>
            </td>
        </tr>
        <tr>
            <td>Port:</td>
            <td valign="top">
                <input class="uispin" type="text" size="6" value="<?php echo $cfg['port']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>Index:</td>
            <td valign="top">
                <input class="input" type="text" value="<?php echo $cfg['index']; ?>"/>
            </td>
        </tr>
    </table>
    <p>
        <input name="opt" type="hidden" value="saveconfig"/>
        <input name="save" type="submit" id="save" value="<?php echo $_LANG['SAVE']; ?>"/>
        <input name="back" type="button" id="back" value="<?php echo $_LANG['CANCEL']; ?>" onclick="window.location.href='index.php?view=components';"/>
    </p>
</form>
