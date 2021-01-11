<?php
    if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
    global $_LANG;
?>
<table border="0" cellpadding="0" cellspacing="0" >
    <tr>
        <td width="75" valign="top">
            <img src="/templates/<?php echo cmsConfig::getConfig('template');?>/special/images/accessdenied.png" />
        </td>
        <td style="padding-top:10px">
            <h1 class="con_heading"><?php echo $_LANG['ACCESS_DENIED']; ?></h1>
            <p><?php echo $_LANG['YOU_HAVENT_ACCESS_MOVIE']; ?>.</p>
            <?php if ($error) { ?>
                <p><?php echo $error;?></p>
            <?php } ?>
        </td>
    </tr>
</table>