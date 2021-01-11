<?php if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); } ?>

<h3 style="float: left">Платежные системы</h3>

<div style="float:right;font-size:14px;padding-top:24px">
    <a href="http://instantcms.ru/wiki/doku.php/instantshop:платежные_системы" target="_blank" style="background:url(/images/icons/help.gif) no-repeat;padding-left: 20px;">Как подключить Webmoney и РобоКассу?</a>
</div>

<div style="clear:both"></div>

<form name="selform" id="selform" action="index.php?view=components" method="post">
    <input type="hidden" name="id" value="<?php echo $component_id; ?>" />
    <table id="listTable" class="tablesorter" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:0px">
        <thead>
            <tr>
                <th class="lt_header" width="25">id</th>
                <th class="lt_header" width="100">&nbsp;</th>
                <th class="lt_header" width="">Название</th>
                <th class="lt_header" width="65">Показ</th>
                <?php if (sizeof($items)>1){ ?>
                    <th class="lt_header" width="24">&darr;&uarr;</th>
                <?php } ?>
                <th class="lt_header" align="center" width="65">Действия</th>
            </tr>
        </thead>
        <?php if ($items){ $n=0; ?>
            <tbody>
                <?php foreach($items as $num=>$item){ ?>
                    <tr id="<?php echo $item['id']; ?>">
                        <td><?php echo $item['id']; ?></td>
                        <td>
                            <a href="index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=config_psys&item_id=<?php echo $item['id']; ?>">
                                <img src="/components/shop/payments/<?php echo $item['link']; ?>/<?php echo $item['logo']; ?>" border="0"/>
                            </a>
                        </td>
                        <td>
                            <a href="index.php?view=components&do=config&id=<?php echo $component_id; ?>&opt=config_psys&item_id=<?php echo $item['id']; ?>"><?php echo $item['title']; ?></a>
                            <?php if ($item['link'] == 'balance' && !$is_billing) { ?>
                                <span style="color:red;font-size:11px;">
                                    &mdash; Требуется компонент <a href="http://www.instantcms.ru/billing/about.html">Биллинг пользователей</a>
                                </span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($item['published']) { ?>
                                <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=hide_psys&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=show_psys&item_id=<?php echo $item['id']; ?>', 'off', 'on');" title="Скрыть">
                                    <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/on.gif"/>
                                </a>
                            <?php } else { ?>
                                <a id="publink<?php echo $item['id']; ?>" href="javascript:pub(<?php echo $item['id']; ?>, 'view=components&do=config&id=<?php echo $component_id; ?>&opt=show_psys&item_id=<?php echo $item['id']; ?>', 'view=components&do=config&id=35&opt=hide_psys&item_id=<?php echo $item['id']; ?>', 'on', 'off');" title="Показать">
                                    <img id="pub<?php echo $item['id']; ?>" border="0" src="images/actions/off.gif"/>
                                </a>
                            <?php } ?>
                        </td>
                        <?php if (sizeof($items)>1){ ?>
                            <td>
                                <?php
                                    $display_move_down  = ($n<sizeof($items)-1) ? 'inline' : 'none';
                                    $display_move_up    = ($n>0) ? 'inline' : 'none';
                                ?>
                                <a class="move_item_down" href="javascript:void(0)" onclick="movePaySys(<?php echo $item['id']; ?>, 1)" title="Подвинуть ниже" style="float:left;display:<?php echo $display_move_down; ?>"><img src="images/actions/down.gif" border="0"/></a>
                                <a class="move_item_up" href="javascript:void(0)" onclick="movePaySys(<?php echo $item['id']; ?>, -1)" title="Подвинуть выше" style="float:right;display:<?php echo $display_move_up; ?>"><img src="images/actions/top.gif" border="0"/></a>
                            </td>
                        <?php } ?>
                        <td align="right">
                            <div style="padding-right: 8px;">
                                <a title="Настройки" href="?view=components&do=config&id=<?php echo $component_id; ?>&opt=config_psys&item_id=<?php echo $item['id']; ?>">
                                    <img border="0" hspace="2" alt="Редактировать" src="images/actions/edit.gif"/>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php $n++; } ?>
            </tbody>
        <?php } else { ?>
            <tbody>
                <td colspan="6" style="padding-left:5px"><div style="padding:15px;padding-left:0px">Модули платежных систем не установлены</div></td>
            </tbody>
        <?php } ?>
    </table>

    <script type="text/javascript">highlightTableRows("listTable","hoverRow","clickedRow");</script>
    <script type="text/javascript">
        $('a.itemlink').hover(
            function() {
                $(this).parent('td').find('div.imghint').fadeIn("fast");
            },
            function() {
                $(this).parent('td').find('div.imghint').fadeOut("fast");
            }
        );
    </script>
</form>