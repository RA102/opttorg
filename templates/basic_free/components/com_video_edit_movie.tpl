<h1 class="con_heading">{$LANG.MOVIE_EDIT} {if $residue}({$LANG.TO_QUEUE} {$residue|spellcount:$LANG.MOVIE1:$LANG.MOVIE2:$LANG.MOVIE10}){/if}</h1>

<form id="upload_movie_form" action="/video/operations_movies" method="post" enctype="multipart/form-data" >
<input type="hidden" name="edit_movie" value="1" />
<input type="hidden" name="edit" value="1" />
<input type="hidden" name="csrf_token" value="{csrf_token}" />
<input type="hidden" name="movie_id" id="movie_id" value="{$movie.id}" />
{if $residue}<input type="hidden" name="edit_again" value="1" />{/if}
{if $movies_ids}
    {foreach item=movie_id from=$movies_ids}
        <input type="hidden" name="movies[]" value="{$movie_id}" />
    {/foreach}
{else}
    <input type="hidden" name="movies[]" value="{$movie.id}" />
{/if}

<div class="action-info row margin-bottom-row">

    <div class="col-sm-6">
	<div class="well">
        <h3 style="margin-top:0;padding-top:0;">{$LANG.VIDEO_INFO}</h3>
        <dl>
            <dt>{$LANG.MOVIES_DATE}:</dt><dd>{$movie.fpubdate}</dd>
            {if $movie.provider != 'localhost'}
                <dt>{$LANG.PROVIDER}:</dt><dd>{$movie.provider}</dd>
            {/if}
            <dt>{$LANG.HITS10|icms_ucfirst}:</dt><dd>{$movie.hits}</dd>
            <dt>{$LANG.SUMM_RATING}:</dt><dd>{$movie.rating}</dd>
            <dt>{$LANG.COMMENT10|icms_ucfirst}:</dt><dd>{$movie.comments_count}</dd>
        </dl>
        <h5 class="custom_img">{$LANG.IMG_FOR_MOVIE}</h5>
        <div class="right_input_val {if $movie.custom_img}custom_img{/if}">
            <div class="input_val_value">
                <input name="preview_file" type="file" tabindex="10" />{if $movie.custom_img} {$LANG.OR_CHAGE}{/if}
            </div>
            {if $movie.custom_img}
            <div class="clearFix prewiew_list_wrap">
                {foreach from=$movie.custom_img.images key=key item=image}
                    <div class="prewiew_list" data-id="{$key}"><div style="background-image: url({$movie.custom_img.path}{$image})"></div><span class="thumbnail-overlay">{$LANG.NO_CHANGE}</span></div>
                {/foreach}
                <input type="hidden" name="custom_img_index" id="custom_img_index" value="0" />
            </div>
            {/if}
        </div>
	</div>
    </div>
    <div class="col-sm-6" style="overflow:hidden;">
        {if $is_admin}
            <a class="edit_code" href="#" onclick="$('#player_code_edit').toggleClass('hid');return false;">{$LANG.EDIT_MOVIE_CODE}</a>
            <div id="player_code_edit" class="hid">
                <div>
                    <textarea style="height:50px !important;" name="movie_code" id="movie_code" wrap="soft" placeholder="{$LANG.CODE_FOR_MOVIE_HINT}" tabindex="1">{if $movie.provider=='code'}{$movie.orig_player_code|escape:'html'}{/if}</textarea>
                </div>
				<div class="code_notice">{if $movie.provider!='code'}{$LANG.EDIT_MOVIE_CODE_TEXT}.{/if}</div>
            </div>
        {/if}
        <div id="player_code">
            {$movie.player_code}
        </div>
    </div>	
</div>

<div id="watch-action-add">
    <div id="watch-secondary-actions">
        <span><button role="button" onclick="getInfo(this);return false;" class="action-panel-trigger" type="button"><span>{$LANG.ADD_BASE_INFO}</span></button></span>
        <span><button role="button" onclick="getOtherInfo(this);return false;" class="action-panel-trigger all" type="button"><span>{$LANG.ADD_CUSTOM_INFO}</span></button></span>
    </div>
</div>

<div id="action-info" class="action-info">
<div class="row margin-bottom-row">
    <div class="col-sm-6">
        <h5 class="movie_params">{$LANG.VISIBILITY_MOVIE}</h5>
		<select name="allow_who" id="allow_who" class="text-input" style="width:150px;">
        	{foreach from=$access_array key=key item=value}
            	<option value="{$key}" {if $movie.allow_who==$key} selected {/if}>{$value}</option>
            {/foreach}
        </select>
        <h5 class="movie_params">{$LANG.MOVIE_TITLE} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5>
        <div class="input_val movie_params">
            <div class="input_val_value">
                <input name="title" id="title" type="text" tabindex="2" placeholder="{$LANG.MOVIE_TITLE_DESCR}" value="{$movie.title|escape:'html'}"/>
            </div>
        </div>

        <h5 class="movie_params">{$LANG.MOVIE_DESCR}</h5>
        <div class="input_val movie_params">
         {if $cfg.process_bbcode}
            <div class="usr_msg_bbcodebox">{$bb_toolbar}</div>
         {/if}
            <div class="input_val_value">
                <textarea name="description" tabindex="3" id="description" wrap="soft" placeholder="{$LANG.MOVIE_DECSR_DESCR}">{$movie.description|escape:'html'}</textarea>
            </div>
        </div>

    </div>
    <div class="col-sm-6">

        <h5 id="title_cat_id">{$LANG.CAT_SITES} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5>
        <div class="right_input_val">
            <div class="input_val_value">
                <select name="cat_id" id="cat_id" tabindex="4" onchange="getCategory({$movie.rubric_id});" {if !$cfg.change_cat_for_edit && !$is_admin}disabled="disabled"{/if}>
                    <option value="">{$LANG.SELECT_CAT}</option>
                    {foreach key=p item=pubcat from=$opt_cats}
                        <option value="{$pubcat.id}" {$pubcat.s}>
                            {'--'|str_repeat:$pubcat.NSLevel} {$pubcat.title|escape:'html'}&nbsp;
                            {if $is_billing && $pubcat.cost && $dynamic_cost}
                                ({$LANG.BILLING_COST}: {$pubcat.cost|spellcount:$LANG.BILLING_POINT1:$LANG.BILLING_POINT2:$LANG.BILLING_POINT10})
                            {/if}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>

        <div id="rubric_list" class="hid">
            <h5>{$LANG.RUBRIC}</h5>
            <div class="right_input_val">
                <div class="input_val_value">
                    <select name="rubric_id" id="rubric_id" tabindex="5"></select>
                </div>
            </div>
        </div>

        <h5 class="movie_params">{$LANG.TAGS}</h5>
        <div class="right_input_val movie_params">
            <div class="input_val_value">
                <input name="tags" type="text" id="tags" tabindex="7" placeholder="{$LANG.KEYWORDS}" value="{$movie.tags|escape:'html'}"/>
                <script type="text/javascript">
                    {$autocomplete_js}
                </script>
            </div>
        </div>

    </div>
</div>
</div>
<div class="action-info hid" id="action-other">
<div class="row margin-bottom-row">
    <div class="col-sm-6" id="left_add">

        <h5>{$LANG.CITY}</h5>
        <div class="input_val">
            <div class="input_val_value">
                {city_input value=$movie.city city_id=$movie.city_id region_id=$movie.region_id country_id=$movie.country_id name="city" width="100%"}
            </div>
        </div>
    {if $is_admin}
        <h5>{$LANG.MOVIE_AUTHOR}</h5>
        <div class="input_val">
            <div class="input_val_value">
                <select name="user_id" tabindex="9">
                    <option value="">{$LANG.NO_CHANGE}</option>
                    {foreach key=p item=user from=$all_users}
                        <option value="{$user.id}">
                            {$user.nickname|escape:'html'}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>
        <h5><label><input type="checkbox" id="enable_geotargetting" name="enable_geotargetting" tabindex="10" value="1" {if $movie.available_countries}checked="checked"{/if} /> {$LANG.ENABLE_GEOTARGETTING}</label></h5>
        <h5 class="geotargetting">{$LANG.GEOTARGETTING_COUNTRYES}</h5>
        <div class="input_val geotargetting">
            <div class="input_val_value">
                {html_options id='geotargetting' name='countries[]' options=$countries selected=$movie.countries multiple=multiple}
            </div>
        </div>
    {/if}

    </div>

    <div class="col-sm-6">

        <h5>{$LANG.RECORDDATE}</h5>
        <div class="right_input_val">
            <div class="input_val_value">
                <input name="recorddate" id="recorddate" tabindex="11" placeholder="{$LANG.RECORDDATE_HINT}" type="text" value="{if $movie.frecorddate}{$movie.recorddate}{/if}" />
            </div>
        </div>

        <h5><label><input type="checkbox" name="comments" tabindex="12" value="1" {if $movie.comments}checked="checked"{/if} /> {$LANG.ENABLE_COMMENTS}</label></h5>
        <h5><label><input type="checkbox" name="is_adult" tabindex="13" value="1" {if $movie.is_adult}checked="checked"{/if} /> {$LANG.IS_ADULT}</label></h5>
        <h5><label><input type="checkbox" name="is_embed" tabindex="14" value="1" {if $movie.is_embed}checked="checked"{/if} /> {$LANG.IS_EMBED}</label></h5>

    </div>
</div>
</div>

<div>
    <input type="submit" class="btn btn-default" value="{if $residue}{$LANG.SAVE_AND_GO_NEXT}{else}{$LANG.SAVE}{/if}" tabindex="15" />
    <input name="cancel" type="button" tabindex="16" class="btn btn-default" onclick="window.history.go(-1)" value="{$LANG.CANCEL}" />
</div>

</form>

{literal}
<script type="text/javascript">
function getInfo(obj){
    toggleButton(obj);
    $('#action-other').hide();
    $('#action-info').css({'opacity': '', 'position': '', 'height': '', 'z-index': ''}); // для swfupload
}
function getOtherInfo(obj){
    toggleButton(obj);
	$('#action-info').css({'opacity': '0', 'position': 'absolute', 'height': '0', 'z-index': '-1'}); // для swfupload
    $('#action-other').show();
}
function toggleButton(obj){
    $('.action-panel-trigger').addClass('all');
    $(obj).removeClass('all');
}
$(function(){
    $( "#recorddate" ).datepicker({ showButtonPanel: true, dateFormat: 'yy-mm-dd', maxDate: 0 });
    getCategory({/literal}{$movie.rubric_id}{literal});
    if(!$('#enable_geotargetting').prop('checked')){
        $('.geotargetting').hide();
    } else {
        $('.geotargetting').show();
    }
    $('#enable_geotargetting').on('click', function (){
        if(!$(this).prop('checked')){
            $('.geotargetting').hide();
            $('#geotargetting').val({});
        } else {
            $('.geotargetting').show();
        }
    });
    $('.prewiew_list').on('click', function (){
        new_id     = $(this).data('id');
        current_id = $('#custom_img_index').val();
        if(new_id == current_id){
            $('#custom_img_index').val('0');
        } else {
            $('#custom_img_index').val(new_id);
        }
        $(this).parent().find('.prewiew_list').not(this).removeClass('selec');
        $(this).toggleClass('selec');
    });
});
</script>
{/literal}