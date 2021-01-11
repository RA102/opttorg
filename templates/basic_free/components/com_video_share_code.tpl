{if $cfg.embed_type}
<div class="share_code">
    {if $cfg.embed_type == 'mixed'}
        <div id="mixed_type_links"><a href="javascript:;" onclick="$('.share_code textarea').html(i_template);$('#mixed_type_links a').removeClass('selected');$(this).addClass('selected');" class="selected">iframe</a> | <a href="javascript:;" onclick="$('.share_code textarea').html(n_template);$('#mixed_type_links a').removeClass('selected');$(this).addClass('selected');">native</a></div>
        <textarea id="i_template" readonly="readonly" class="hid">{$movie.movie_code|escape:'html'}</textarea>
        <textarea id="n_template" readonly="readonly" class="hid">{$movie.movie_code_native|escape:'html'}</textarea>
    {/if}
    <p><strong>{$LANG.MOVIE_CODE}:</strong></p>
    <textarea readonly="readonly" id="view_embed_code" onclick="$(this).select();">{$movie.movie_code|escape:'html'}</textarea>
    <div class="share-size-options">
        <label for="embed-layout-options">{$LANG.VIDEO_SIZE}:</label>
        <select id="embed-layout-options">
          <option value="default" data-width="420" data-height="315">420 × 315</option>
          <option value="medium" data-width="480" data-height="360">480 × 360</option>
          <option value="large" data-width="640" data-height="480">640 × 480</option>
          <option value="hd720" data-width="960" data-height="720">960 × 720</option>
          <option value="custom">{$LANG.OTHER_VIDEO_SIZE}</option>
        </select>
        <span id="share-embed-customize" class="hid">
            <input type="text" maxlength="4" id="embed_w" value="420" style="width:80px !important;display:inline !important;"> × <input type="text" maxlength="4" id="embed_h" value="315" style="width:80px !important;display:inline !important;"> <a class="ajax_link" href="javascript:void(0);" onclick="$('#share-embed-customize').hide();$('#embed-layout-options').fadeIn();">{$LANG.CANCEL}</a>
        </span>
        <label class="{if !$movie.is_playlist}hid{/if}"> <input type="checkbox" id="enable_playlist" value="{$movie.is_playlist}" /> {$LANG.ENABLE_EMBED_PLAYLIST}</label>
        <label class="hid from_first"> <input type="checkbox" id="from_first" value="{$movie.id}" /> {$LANG.ENABLE_EMBED_PLAYLIST_CURRENT}</label>

        {if !$movie.is_embed}
            <span class="text-danger"> {$LANG.USER_IS_DISABLE_EMBED}</span>
        {/if}
    </div>
</div>
<script type="text/javascript">
{if $cfg.embed_type == 'mixed'}
    var i_template = $('#i_template').html();
    var n_template = $('#n_template').html()
{/if}
{literal}
    $(function(){
        embed_code = $($('#view_embed_code').text());
        embed_link = embed_code.attr('src');
        {/literal}{if !$movie.is_embed}
            $('#embed-layout-options, #share-embed-customize, #view_embed_code').prop('disabled', true);
        {/if}{literal}
        var start_movie_append = '';
        $('#enable_playlist').on('click', function(){
            current_code = embed_code;
            if($(this).prop('checked')){
                link = embed_link+'?playlist='+$(this).val()+start_movie_append;
                $('.from_first').show();
            } else {
                link = embed_link;
                $('.from_first').hide();
            }
            current_code.attr('src', link);
            $('#view_embed_code').html($('<div>').append(current_code.clone()).remove().html());
        });
        $('#from_first').on('click', function(){
            if($(this).prop('checked')){
                start_movie_append = '&mid='+$(this).val();
            } else {
                start_movie_append = '';
            }
            $('#enable_playlist').triggerHandler('click');
        });
        $('#embed-layout-options').on('change', function(){
            width  = $('option:selected', this).data('width');
            height = $('option:selected', this).data('height');
            if(!width || !height){
                $(this).hide();
                $("#share-embed-customize").fadeIn();
                $("#embed_w").focus();
                return;
            }
            embed_code.attr('width', width);
            embed_code.attr('height', height);
            $('#enable_playlist').triggerHandler('click');
        }).trigger('change');
        $('#embed_w').on('keyup', function (){
            embed_code.attr('width', $(this).val());
            $('#enable_playlist').triggerHandler('click');
        });
        $('#embed_h').on('keyup', function (){
            embed_code.attr('height', $(this).val());
            $('#enable_playlist').triggerHandler('click');
        });
    });
</script>
{/literal}
{else}
    <span class="text-danger"> {$LANG.USER_IS_DISABLE_EMBED}</span>
{/if}