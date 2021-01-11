<?php
    if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
    $inPage = cmsPage::getInstance();

    if(method_exists($inPage, 'prependHeadJS')){
        $inPage->prependHeadJS('core/js/common.js');
        $inPage->prependHeadJS('includes/jquery/jquery.js');
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $inPage->printHead(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="noindex, nofollow" />
<style type="text/css">
html {
    height: 100%;
}
body {
    background: #000;
    font-family: tahoma,arial,verdana,sans-serif,Lucida Sans;
    font-size: 11px;
    height: 100%;
    margin: 0;
    padding: 0;
}
a {
    color: #FFF;
}
a:hover {
    color: #CCC;
}
.scroll_fix_wrap, #playerWrap {
    height: 100%;
    text-align: left;
    word-wrap: break-word;
    width: 100%;
    overflow: hidden;
    position: relative;
}
object {
    display: block;
}
h3 {
    color: #FFF;
    font-weight: normal;
    font-size: 13px;
}
p{
    margin: 0;
}
.share_code textarea, .share_code input[type="text"] {
    font-size: inherit;
    font-family: sans-serif;
}
table {
    margin: 0 10px;
}
.embed_playlist-container {
    bottom: 50px;
    overflow: hidden;
    width: 100%;
}
.embed_playlist-container ol {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    clear: both;
    overflow: hidden;
    background: #1a1a1a;
    white-space: nowrap;
}
.embed_playlist-container ol li {
    height: 100%;
    position: relative;
    list-style: none;
    overflow: hidden;
    cursor: pointer;
    display: inline-block;
}
.embed_playlist-container ol li > a {
    box-sizing: border-box;
    display: block;
    height: 100%;
    overflow: hidden;
    padding: 7px;
    width: 100%;
    transition: background 0.2s ease 0s;
}
.embed_playlist-container ol li:hover a, .currently-playing a {
    background: #2980b9;
}
#playerWrap:hover .embed_playlist-container ol {
    overflow-x: auto;
}
.embed_playlist-container ol li:hover .playlist-video-description {
    opacity: 1.0;
}
.embed_playlist-container ol li a > div {
    box-sizing: border-box;
    height: 100%;
    background-position: center 20%;
    background-repeat: no-repeat;
    background-size: cover;
}
.embed_playlist-container .playlist-video-description {
    background: #333;
    box-sizing: border-box;
    color: #fff;
    font-size: 1.1em;
    height: 100%;
    opacity: 0.8;
    padding: 2px 5px;
    width: 100%;
    line-height: 200%;
    text-overflow: ellipsis;
}
.embed_playlist-container ol li > div {
    box-sizing: border-box;
    height: 50%;
    padding: 7px;
    position: absolute;
    top: 0;
    width: 100%;
}
</style>
</head>
<body>
    <div id="page_wrap" class="scroll_fix_wrap">
        <div id="playerWrap">
            <?php if($movie) { ?>
                <?php if(!$movie['is_embed'] || !$embed_enable || !$show_on_domain){ ?>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                        <tr>
                            <td align="center">
                                <table border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td width="80">
                                            <img src="/templates/<?php echo TEMPLATE; ?>/special/images/accessdenied.png" />
                                        </td>
                                        <td>
                                            <h3><?php echo $_LANG['USER_IS_DISABLE_EMBED']; ?></h3>
                                            <h3><u><a href="<?php echo $movie['movie_link']; ?>" target="_blank"><?php echo sprintf($_LANG['VIEW_EMBED_ON_SITE'], cmsConfig::getConfig('sitename')); ?></a></u></h3>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <?php echo $movie['player_code']; ?>
                <?php } ?>
                <?php if($playlist_movies) { ?>
                    <div class="embed_playlist-container">
                        <ol id="playlist-videos-list">
                            <?php foreach ($playlist_movies as $playlist_movie) { ?>
                            <li class="<?php echo ($playlist_movie['id'] == $movie['id'] ? 'currently-playing' : ''); ?>" data-id="<?php echo $playlist_movie['id'];?>" title="<?php echo htmlspecialchars($playlist_movie['title']);?>">
                                <a href="#">
                                    <div style="background-image: url(/upload/video/thumbs/small/<?php echo $playlist_movie['img'];?>)"></div>
                                </a>
                                <div><div class="playlist-video-description"><?php echo htmlspecialchars($playlist_movie['title']);?></div></div>
                            </li>
                            <?php } ?>
                        </ol>
                    </div>
                <script type="text/javascript">

                    function setSizes(){
                        doc_width = $(document).width();
                        $('.embed_playlist-container').width(doc_width);
                        if(doc_width < 420){
                            block_width = doc_width/3;
                        } else if(doc_width >= 420 && doc_width < 620){
                            block_width = doc_width/4;
                        } else if(doc_width >= 620 && doc_width < 960){
                            block_width = doc_width/6;
                        } else {
                            block_width = doc_width/8;
                        }
                        $('#playlist-videos-list li').width(block_width);
                        doc_height = $(document).height();
                        if(doc_height < 315){
                            pl_height = 35;
                        } else if(doc_height >= 315 && doc_height < 360){
                            pl_height = 30;
                        } else if(doc_height >= 360 && doc_height < 480){
                            pl_height = 25;
                        } else {
                            pl_height = 20;
                        }
                        $('#player_code').height(100-pl_height+'%');
                        $('.embed_playlist-container').height(pl_height+'%');
                    }
                    $(function() {
                        setSizes();
                        $(window).resize(function(){
                            setSizes();
                        });
                        ivPlayLists.after = function (){
                            movie_play_list = $('#playlist-videos-list');
                            movies  = $('li', movie_play_list);
                            current = $('li.currently-playing', movie_play_list);
                            next_id = $(movies).index(current)+1;
                            next    = $(movies).eq(next_id);
                            if(next.length){
                                current.removeClass('currently-playing');
                                next.addClass('currently-playing');
                                playMovie($(next).data('id'), play_headers);
                                $('#playlist-videos-list').animate({scrollLeft: next.offset().left}, 800);
                            }
                        };
                        $('#playlist-videos-list li').on('click', function (){
                            $('#playlist-videos-list li').removeClass('currently-playing');
                            $(this).addClass('currently-playing');
                            playMovie($(this).data('id'), play_headers);
                        });
                        $('#playlist-videos-list').animate({scrollLeft: $('li.currently-playing').offset().left}, 800);
                    });
                </script>
                <?php } ?>
            <?php } else { ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                    <tr>
                        <td align="center">
                            <table border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <td width="80">
                                        <img src="/templates/<?php echo TEMPLATE; ?>/special/images/accessdenied.png" />
                                    </td>
                                    <td>
                                        <h3><?php echo $_LANG['YOUTUBE_STATUS_DELETED']; ?></h3>
                                        <h3><u><a href="<?php echo HOST; ?>" target="_blank"><?php echo sprintf($_LANG['VIEW_OTHER_VIDEO_ON_SITE'], cmsConfig::getConfig('sitename')); ?></a></u></h3>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php } ?>

        </div>
    </div>
</body>
</html>