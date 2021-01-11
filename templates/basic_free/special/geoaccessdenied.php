<?php
    if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
    global $_LANG;
?>
<div id="player_code">
    <div id="player_container" style="width: <?php echo $sizes['width']; ?>px; height: <?php echo $sizes['height']; ?>px;">
        <div style="position: absolute; top: 10px; left: 20px; color: #FFF;">
            <h3><?php echo $_LANG['ACCESS_DENIED']; ?></h3>
            <p><?php echo sprintf($_LANG['YOU_HAVENT_GEOACCESS'], $country); ?></p>
        </div>
    </div>
</div>