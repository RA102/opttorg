<?php
    if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
    global $_LANG;
?>
<div id="player_code">
    <div id="player_container" style="width: <?php echo $sizes['width']; ?>px; height: <?php echo $sizes['height']; ?>px;">
        <div class="movie_access_denied">
            <h3><?php echo $_LANG['ACCESS_DENIED']; ?></h3>
            <p><?php echo $_LANG['YOU_HAVENT_ACCESS_MOVIE']; ?>.</p>
            <?php if ($error) { ?>
                <p><?php echo $error;?></p>
            <?php } ?>
        </div>
    </div>
</div>