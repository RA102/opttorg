{if $count_types > 1}
    <ul class="add_form">
    {if $is_admin || $cfg.allow_file}
      <li class="{if !$from}select {/if}file" onclick="return selectForm('', '{$cat_id}', '{$rubric_id}');">
          {$LANG.UPLOAD_VIDEOFILE}
      </li>
    {/if}
    {if $is_admin || $cfg.allow_link}
      <li class="{if $from=='link'}select {/if}link" onclick="return selectForm('link', '{$cat_id}', '{$rubric_id}');">
          {$LANG.ADD_FROM_LINK}
      </li>
    {/if}
    {if $is_admin || $cfg.allow_code}
      <li class="{if $from=='code'}select {/if}code" onclick="return selectForm('code', '{$cat_id}', '{$rubric_id}');">
          {$LANG.ADD_FROM_CODE}
      </li>
    {/if}
    </ul>
{else}
    <h1 class="con_heading">{$LANG.MOVIE_ADD}</h1>
{/if}
{literal}
<style>
.swfupload {position:absolute;top:10px;right:0;z-index:11;}
</style>
{/literal}
<form id="upload_movie_form" action="/video/add.html" method="post" enctype="multipart/form-data" >
<input type="hidden" name="csrf_token" value="{csrf_token}" />
<input type="hidden" name="add_movie" value="1" />
<input type="hidden" id="movie_id" value="0" />
<input type="hidden" name="from_type" value="{$from}" />

<div id="watch-action-add">
    <div id="watch-secondary-actions">
        <span><button role="button" onclick="getInfo(this);return false;" class="action-panel-trigger" type="button"><span>{$LANG.ADD_BASE_INFO}</span></button></span>
        <span><button role="button" onclick="getOtherInfo(this);return false;" class="action-panel-trigger all" type="button"><span>{$LANG.ADD_CUSTOM_INFO}</span></button></span>
    </div>
</div>

<div id="action-info" class="action-info">
<div class="row margin-bottom-row">
    <div class="left_add col-sm-6">
    {if !$from}
        <h5>{$LANG.SELECT_MOVIE} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5>
        <div class="input_val">
            <div class="flash" id="fsUploadProgress"></div>
            <div class="input_val_value" id="input_file" style="position:relative;">
                <span id="select_flash">
                    <input type="text" id="txtFileName" disabled="disabled" tabindex="1" placeholder="{$LANG.MAX_FILE_SIZE} {$fupload_max_filesize}" /> <span id="spanButtonPlaceholder"></span>
                </span>
                <span id="select_file_no_flash" class="hid">
                    <input name="Filedata" type="file" tabindex="1" />
                </span>
                <input type="hidden" name="movie_id" id="hidFileID" value="" />
            </div>
        </div>
    {elseif $from=='link'}
        <h5>{$LANG.LINK_ON_MOVIE} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5>
        <div class="input_val">
            <div class="input_val_value">
                <input name="link" id="link" type="text" placeholder="{$LANG.LINK_ON_MOVIE_DESCR}" value="" tabindex="1"/> <a class="ajaxlink get_data hid" href="javascript:getMoviesParams()">{$LANG.GET_MOVIE_INFORMATION}</a>
            </div>
        </div>
    {else}
        <h5>{$LANG.CODE_FOR_MOVIE} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5>
        <div class="input_val">
            <div class="input_val_value">
                <textarea name="movie_code" id="movie_code" wrap="soft" placeholder="{$LANG.CODE_FOR_MOVIE_HINT}" tabindex="1"></textarea>
            </div>
        </div>
    {/if}

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
                <textarea name="description" tabindex="3" id="description" wrap="soft" placeholder="{$LANG.MOVIE_DECSR_DESCR}">{$movie.description}</textarea>
            </div>
        </div>

    </div>
    <div class="left_add col-sm-6">
		<h5>{$LANG.VISIBILITY_MOVIE}: </h5>
        <select name="allow_who" id="allow_who" class="text-input">
        	{foreach from=$access_array key=key item=value}
            	<option value="{$key}" {if $movie.allow_who==$key} selected {/if}>{$value}</option>
            {/foreach}
        </select>
        <h5 id="title_cat_id">{$LANG.CAT_SITES} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span></h5> 
        <div class="right_input_val">
            <div class="input_val_value">
                <select name="cat_id" id="cat_id" tabindex="4" onchange="getCategory({$rubric_id});">
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

    {if $opt_albums}
        <h5>{$LANG.PLAYLIST}</h5>
        <div class="right_input_val">
            <div class="input_val_value">
                <select name="pl_id" tabindex="6">
                    <option value="">{$LANG.SELECT_ALBUM}</option>
                    {$opt_albums}
                </select>
            </div>
        </div>
    {/if}

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
<div class="row">
    <div class="left_add col-sm-6" id="left_add">

        <h5>{$LANG.CITY}</h5>
        <div class="input_val">
            <div class="input_val_value">
                {city_input value=$movie.city city_id=$movie.city_id region_id=$movie.region_id country_id=$movie.country_id name="city" width="100%"}
            </div>
        </div>
    {if $from == 'code'}
        <h5 class="movie_params">{$LANG.DURATION}</h5>
        <div class="input_val">
            <div class="input_val_value">
                <input name="duration" type="text" placeholder="{$LANG.DURATION_HINT}" />
            </div>
        </div>
    {/if}
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
    {/if}

    </div>

    <div class="left_add col-sm-6">

        <h5 class="custom_im">{$LANG.IMG_FOR_MOVIE}</h5>
        <div class="right_input_val custom_im">
            <div class="input_val_value">
                <input name="preview_file" type="file" tabindex="10" />
            </div>
        </div>

        <h5>{$LANG.RECORDDATE}</h5>
        <div class="right_input_val">
            <div class="input_val_value">
                <input name="recorddate" id="recorddate" tabindex="11" placeholder="{$LANG.RECORDDATE_HINT}" type="text" value="" />
            </div>
        </div>

        <h5><label><input type="checkbox" name="comments" tabindex="12" value="1" {if $movie.comments}checked="checked"{/if} /> {$LANG.ENABLE_COMMENTS}</label></h5>
        <h5><label><input type="checkbox" name="is_adult" tabindex="13" value="1" {if $movie.is_adult}checked="checked"{/if} /> {$LANG.IS_ADULT}</label></h5>
        <h5><label><input type="checkbox" name="is_embed" tabindex="14" value="1" {if $movie.is_embed}checked="checked"{/if} /> {$LANG.IS_EMBED}</label></h5>

    </div>
</div>
</div>

<div class="submit_video">
    {if !$from}
        <input type="submit" id="btnSubmit" tabindex="15" class="save_btn" value="{$LANG.START_UPLOAD}" />
        <input type="submit" id="uploadNoFlash" class="save_btn hid" value="{$LANG.START_UPLOAD}" onclick="return uploadNative(this);" />
    {elseif $from=='link'}
        <input type="submit" id="btnImport" tabindex="15" value="{$LANG.START_IMPORT}" class="save_btn" onclick="startImport();return false;" />
    {else}
        <input type="submit" id="btnImport" tabindex="15" value="{$LANG.SAVE}" class="save_btn" onclick="saveCode();return false;" />
    {/if}
    <input name="cancel" type="button" tabindex="16" class="cancel_btn" onclick="window.history.go(-1)" value="{$LANG.CANCEL}" />
</div>

</form>
<!-- Общие скрипты -->
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
function movieParamsEnable(){
    $('#title').prop('disabled', false);
    $('#description').prop('disabled', false);
    $('#tags').prop('disabled', false);
}
function movieParamsDisable(){
    $('#title').prop('disabled', true);
    $('#description').prop('disabled', true);
    $('#tags').prop('disabled', true);
}
$(document).ready(function(){
    $( "#recorddate" ).datepicker({ showButtonPanel: true, dateFormat: 'yy-mm-dd', maxDate: 0});
    getCategory({/literal}{$rubric_id}{literal});
    if(typeof int_link != 'undefined'){
        clearInterval(int_link);
    }
    movieParamsEnable();
});
</script>
{/literal}

<!-- Скрипты от типа добавления -->
{if !$from}
{literal}
<script type="text/javascript">
    function uploadNative(obj) {
        $(obj).prop('disabled', true);
        $(obj).val(LANG_MOVIE_UPLOAD_WAIT);
        $('.cancel_btn').hide();
        $('#upload_movie_form').submit();
    }
    var swfu;
    $(document).ready(function(){
        $('.custom_im').hide();
        swfu = new SWFUpload({
            upload_url: "/components/video/ajax/upload.php",
            post_params: {
                "sess_id" : "{/literal}{$sess_id}{literal}"
            },

            file_size_limit : "{/literal}{$upload_max_filesize}{literal} B",
            file_types : "{/literal}{$cfg.filestype_swf}{literal}",
            file_types_description : LANG_FILES_VIDEO,
            file_upload_limit : 0,
            file_queue_limit : 1,

            swfupload_loaded_handler : swfUploadLoaded,

            file_dialog_start_handler: fileDialogStart,
            file_queued_handler : fileQueued,
            file_queue_error_handler : fileQueueError,
            file_dialog_complete_handler : fileDialogComplete,

            swfupload_preload_handler : preLoad,
            swfupload_load_failed_handler : loadFailed,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,

            button_image_url : "/components/video/swfupload/button17x18.png",
            button_placeholder_id : "spanButtonPlaceholder",
            button_width: 57,
            button_height: 18,
            button_text : '<span class="button">'+LANG_BROWSE+'</span>',
            button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 13px; }',
            button_text_top_padding: 0,
            button_text_left_padding: 18,

            button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
            button_cursor: SWFUpload.CURSOR.HAND,

            flash_url : "/components/video/swfupload/swfupload.swf",
            flash9_url : "/components/video/swfupload/swfupload_fp9.swf",

            custom_settings : {
                progress_target : "fsUploadProgress",
                upload_successful : false
            },

            debug: false
        });
    });
</script>
{/literal}
{elseif $from=='link'}
<script type="text/javascript">
{literal}
    function getMoviesParams() {
        ajaxIndicatorStart('upload_movie_form');
        var file_link = $('#link').val();
        $('#link').val(LANG_HEADLINES_UPLOAD_WAIT);
        $.post('/components/video/ajax/get_json_data_from_link.php', {link: file_link}, function(data){
            if(data && !data.errors){
                clearInterval(int_link);
                movieParamsEnable();
                $('#title').val(data.title);
                $('#description').val(data.description);
                $('#tags').val(data.tags);
                $('#link').prop('readonly', true);
                $('.get_data').hide();
            } else {
                core.alert(data.msg, LANG_ERROR);
            }
            $('#link').val(file_link);
            ajaxIndicatorStop('upload_movie_form');
        }, 'json');
    }
    function checkLink() {
        file_link = $('#link').val();
        if(file_link.length < 12){
            hideAll(); return false;
        }
        var reg_ext = /.*\.(flv|mp4|webm)$/i;
        var reg_pr  = /^rtmp:\/\/.*$/i;
        if (reg_ext.test(file_link) || reg_pr.test(file_link)) {
            showFromFile();
        } else if (file_link) {
            showFromLink();
        } else { hideAll(); }
    }
    function showFromFile() {
        movieParamsEnable();
        $('.movie_params').show();
        $('.get_data').hide();
    }
    function showFromLink() {
        $('.get_data').show();
        movieParamsDisable();
    }
    function hideAll() {
        $('.get_data').hide();
        movieParamsDisable();
    }
    function startImport(){
        if($('#link').val().length < 12){
            core.alert(LANG_MOVIE_ERROR_LINK, LANG_ERROR);
            return false;
        }
        cat_id = $('#cat_id').val();
        if(cat_id > 0){
            $('#btnImport').prop('disabled', true);
            $('#btnImport').val(LANG_MOVIE_UPLOAD_WAIT);
            $('.cancel_btn').hide();
            ajaxIndicatorStart('upload_movie_form');
            $('#upload_movie_form').submit();
        } else {
            core.alert(LANG_CAT_ERROR, LANG_ERROR);
        }
    }
    $(document).ready(function(){
        int_link = setInterval('checkLink()', 300);
    });
{/literal}
</script>
{else}
<script type="text/javascript">
{literal}
    function saveCode(){
        if($('#movie_code').val().length < 15){
            core.alert(LANG_MOVIE_CODE_NOT_FOUND, LANG_ERROR);
            return false;
        }
        if($('#title').val().length < 3){
            core.alert(LANG_MOVIE_ERROR_TITLE, LANG_ERROR);
            return false;
        }
        cat_id = $('#cat_id').val();
        if(cat_id > 0){
            $('#btnImport').prop('disabled', true);
            $('#btnImport').val(LANG_MOVIE_UPLOAD_WAIT);
            $('.cancel_btn').hide();
            ajaxIndicatorStart('upload_movie_form');
            $('#upload_movie_form').submit();
        } else {
            core.alert(LANG_CAT_ERROR, LANG_ERROR);
        }
    }
{/literal}
</script>
{/if}