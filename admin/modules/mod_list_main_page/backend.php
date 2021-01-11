<?php

	cpAddPathway('RA: Категории на главную', '?view=modules&do=edit&id='.$_REQUEST['id']);
	cpAddPathway('Настройки', '?view=modules&do=config&id='.$_REQUEST['id']);
	if (isset($_REQUEST['opt'])) { $opt = $_REQUEST['opt']; } else { $opt = 'config'; }
	echo '<h3>RA: Категории на главную</h3>';
 		$toolmenu = array();
		$toolmenu[0]['icon'] = 'save.gif';
		$toolmenu[0]['title'] = 'Сохранить';
		$toolmenu[0]['link'] = 'javascript:document.optform.submit();';

		$toolmenu[1]['icon'] = 'edit.gif';
		$toolmenu[1]['title'] = 'Редактировать отображение модуля';
		$toolmenu[1]['link'] = '?view=modules&do=edit&id='.$_REQUEST['id'];				

		$toolmenu[2]['icon'] = 'cancel.gif';
		$toolmenu[2]['title'] = 'Отмена';
		$toolmenu[2]['link'] = '?view=modules';
		
		cpToolMenu($toolmenu);

    //LOAD CURRENT CONFIG
    $cfg = $inCore->loadModuleConfig($_REQUEST['id']);

	if($opt=='save'){
	
		$cfg = array();
		$cfg['parent_id'] = $inCore->request('parent_id', 'int', 0);

        $inCore->saveModuleConfig((int)$_REQUEST['id'], $cfg);
		$msg = 'Настройки сохранены.';

	}
	
	if (@$msg) { echo '<p class="success">'.$msg.'</p>'; }

?>
<form action="index.php?view=modules&do=config&id=<?php echo $_REQUEST['id'];?>" method="post" name="optform" target="_self" id="form1">
    <table border="0" cellpadding="10" cellspacing="0" class="proptable">
        <tr>
            <tr>
                <td width="200">
                    <strong>Родительская категория:</strong>
                </td>
                <td>
                    <select  name="parent_id[]" id="parent_id" style="width:290px">
                        <option value="0" <?php if (!$cfg['parent_id']) { echo 'selected="selected"'; } ?>>-- Корневая категория --</option>
                        <?php
                            if (isset($cfg['parent_id'])) {
                                echo $inCore->getListItemsNS('cms_shop_cats', $cfg['parent_id']);
                            } else {
                                echo $inCore->getListItemsNS('cms_shop_cats');
                            }
                        ?>
                    </select>
                </td>
            </tr>
    </table>
    <p>
        <input name="opt" type="hidden" id="do" value="save" />
        <input name="save" type="submit" id="save" value="Сохранить" />
        <input name="back" type="button" id="back" value="Назад" onclick="window.location.href='index.php?view=modules';"/>
    </p>
</form>