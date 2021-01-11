<h6>{$LANG.MOVE_TO_ALBUM}</h6>
<div class="video_action_block">
    <ul id="playlists_list">
        <li class="favorites {if $is_fav}selected_list{/if}">
            <span class="hid in_playlist">✔ </span>{$LANG.FAVORITES_MOVIE}
        </li>
        {if $playlists}
            {foreach key=sid item=pl from=$playlists}
            <li class="{if $pl.is_selected}selected_list{/if}" data-id="{$pl.id}">
                <span class="hid in_playlist">✔ </span>{$pl.title}
            </li>
            {/foreach}
        {/if}
    </ul>
</div>
<div class="input_val" id="upload_movie_form">
    <div class="input-group">
      <input name="title" class="form-control" id="pl_title" type="text" placeholder="{$LANG.ALBUM_TITLE}" value=""/>
      <span class="input-group-btn">
        <input type="button" class="save_btn btn btn-default" id="submit_pl" disabled="true" value="{$LANG.ALBUM_CREATE}" />
      </span>
    </div>
</div>
<script type="text/javascript">
    var add_movie_id = '{$movie_id}';
{literal}
    $(function(){
        $('#playlists_list li').not('.favorites').off('click').on('click', function (){
            if($(this).hasClass('selected_list')){
                link = '/video/delete_from_playlist';
                $(this).removeClass('selected_list');
            } else {
                link = '/video/add_to_playlist';
                $(this).addClass('selected_list');
            }
            $.post(link, {movies: [add_movie_id], move_album_id: $(this).data('id')}, function(data){ }, 'json');
        });
        $('.favorites').off('click').on('click', function (){
            favorites(add_movie_id, 'add');
        });
        var pl_title  = $('#pl_title');
        var submit_pl = $('#submit_pl');
        pl_title.off('keyup').on('keyup', function(e) {
            if($(this).val().length > 1){
                submit_pl.prop('disabled', false);
                if(e.keyCode==13){
                    submit_pl.trigger('click');
                }
            } else {
                submit_pl.prop('disabled', true);
            }
        });
        submit_pl.off('click').on('click', function (){
            title = pl_title.val();
            submit_pl.prop('disabled', true);
            $.post('/video/operations_album.html', {
                    csrf_token: {/literal}'{csrf_token}'{literal},
                    add_album: 1,
                    title: pl_title.val()},
                function(data){
                    if(data == 1){
                        $.post('/video/get_playlists', {movie_id: add_movie_id}, function(data){
                            $('#action-panel-addto').html(data);
                        });
                    }
            });
        });
    });
</script>
{/literal}