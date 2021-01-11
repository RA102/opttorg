<?php
    if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
    global $_LANG;

    if(in_array($ad['position'], array(0,2))){
?>
    <script type="text/javascript">
    function timer(){
        cur_time = cur_time-1;
        $('#ad_num_text').html(spellCount(cur_time, '<?php echo $_LANG['AD_SEC1']; ?>', '<?php echo $_LANG['AD_SEC2']; ?>', '<?php echo $_LANG['AD_SEC10']; ?>'));
        <?php if($ad['skip_time']) { ?>
            if(cur_time == (full_time - <?php echo $ad['skip_time']; ?>)){
                $('#ads_skip').fadeIn();
            }
        <?php } ?>
        if(cur_time == 0){
            playSkipAds();
        } else {
            timeout_id = setTimeout(timer,1000);
        }
    }
    function videotimer(){
        cur_time = cur_time-1;
        <?php if($ad['skip_time']) { ?>
            if(cur_time == (full_time - <?php echo $ad['skip_time']; ?>)){
                $('#ads_skip').fadeIn();
            }
        <?php } ?>
        if(cur_time > 0){
            timeout_id = setTimeout(videotimer,1000);
        }
    }
    function playSkipAds(){
        if(typeof(play_headers) == 'undefined'){
            play_headers = {};
        }
        clearTimeout(timeout_id);
        playMovie(<?php echo $movie['id']; ?>, play_headers, 1);
    }

    var full_time = <?php echo $ad['duration_show']; ?>;
    var cur_time  = full_time;

    $('.player_play_loading').remove();

    <?php if($ad['type'] == 3){ ?>

        $(document).one('advideoend', function (){
            playSkipAds();
        });

        var timeout_id = setTimeout(videotimer, 1000);

    <?php } else { ?>

        var timeout_id = setTimeout(timer, 1000);
        $('#ad_num_text').html(spellCount(full_time, '<?php echo $_LANG['AD_SEC1']; ?>', '<?php echo $_LANG['AD_SEC2']; ?>', '<?php echo $_LANG['AD_SEC10']; ?>'));

    <?php } ?>

    </script>

    <div id="ads_top"><?php echo ($ad['type'] == 3 ? $_LANG['ADTEXT'] : $_LANG['AD_IS_END']); ?> <span id="ad_num_text"></span></div>
    <div id="ads_skip"><img src="/upload/video/thumbs/small/<?php echo $movie['img']; ?>" /><a href="#" onclick="playSkipAds();return false;"><?php echo $_LANG['SKIP_AD']; ?></a></div>
<?php } ?>
    <?php if($ad['video_link']){ ?>
        <a target="_blank" class="ad_title" href="<?php echo htmlspecialchars($ad['video_link']); ?>"><?php echo $ad['title']; ?></a>
    <?php } ?>
    <div class="ads_body<?php if($ad['position']==1){ ?>_page<?php } ?>" id="ads_<?php echo $ad['id']; ?>" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>;">
        <?php echo $ad['data']; ?>
    </div>