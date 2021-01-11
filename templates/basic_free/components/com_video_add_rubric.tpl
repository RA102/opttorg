<h1 class="con_heading">{$page_title}</h1>
{literal}
<style>
label, label strong {font-weight:100 !important;}
</style>
{/literal}
<form action="" method="post" enctype="multipart/form-data" id="rubric_form" >
<input type="hidden" name="csrf_token" value="{csrf_token}" />
<div class="row margin-bottom-row add_rubric">
	<div class="col-md-8">
        <div class="rubric_opt"><strong>{$LANG.RUBRIC_TITLE}</strong></div>
		<input name="title" type="text" id="title" class="text-input" value="{$r.title|escape:'html'}" />
		<div class="rubric_opt"><strong>{$LANG.RUBRIC_TOGROUP}</strong></div>
		<div class="input-group" id="sel_group">
                  <select name="group" id="group" class="form-control">
                      <option value="">-- {$LANG.RUBRIC_NOGROUP} --</option>
                      {if $rubric_groups}
                        {foreach key=num item=group from=$rubric_groups}
                            <option value="{$group|escape:'html'}" {if $group == $r.r_group}selected="selected"{/if}>{$group}</option>
                        {/foreach}
                      {/if}
                  </select>
			<span class="input-group-btn">
				<a href="javascript:void(0)" class="btn btn-default" onclick="$('#sel_group').hide();$('#new_group').fadeIn();$('#new_group input').focus();">{$LANG.RUBRIC_GROUP_CREATE}</a>
			</span>
		</div>
		<div class="input-group" id="new_group" style="display:none;">
			<input name="new_group" type="text" value="" class="form-control" />
			<span class="input-group-btn">
				<a href="javascript:void(0)" onclick="$('#new_group').hide();$('#sel_group').fadeIn();" class="btn btn-default">{$LANG.CANCEL}</a>
			</span>
		</div>
        <div class="rubric_opt"><strong>{$LANG.RUBRIC_DESCRIPTION}</strong></div>
        <div>{wysiwyg name='description' value=$r.description height=450 width='99%'}</div>		
	</div>
	<div class="col-md-4">
		<div class="well">
        <div class="rubric_opt" style="padding-top:0;"><strong>{$LANG.RUBRIC_USE_INCAT}:</strong></div>
        <select name="cats[]" id="cats" style="width:100%" class="text-input" size="9" multiple="1" {if $r.bind_all}disabled="disabled"{/if}>
            {foreach key=id item=cat from=$cats}
                <option value="{$cat.id}" {if in_array($cat.id, $r.cats)}selected="selected"{/if}>{'--'|str_repeat:$cat.NSLevel}  {$cat.title}</option>
            {/foreach}
        </select>
        <div class="rubric_opt">
            <label>
                <input type="checkbox" name="bind_all" id="bind_all" value="1" onclick="toggleBindAll()" {if $r.bind_all}checked="checked"{/if} /> <strong>{$LANG.RUBRIC_USE_ALLCAT}</strong>
            </label>
            <label>
                <input type="checkbox" name="is_comments" id="is_comments" value="1" {if $r.is_comments}checked="checked"{/if} /> <strong>{$LANG.RUBRIC_COMMENTS}</strong>
            </label>
            <label>
                <input type="checkbox" name="is_rating" id="is_rating" value="1" {if $r.is_rating}checked="checked"{/if} /> <strong>{$LANG.RUBRIC_RATING}</strong>
            </label>
            <label>
                <input type="checkbox" name="is_playlist" value="1" {if $r.is_playlist}checked="checked"{/if} /> <strong>{$LANG.RUBRIC_IS_PLAYLIST}</strong>
            </label>
        </div>
        <div class="rubric_opt">
            <div>
                <input name="perpage" class="text-input" type="text" style="width:60px !important;display:inline !important;" value="{$r.perpage}" /> - {$LANG.RUBRIC_PERPAGE}
            </div>
        </div>
        <div class="rubric_opt">
            <div>
                {$LANG.RUBRIC_ONE_IMG} {if !$is_add && $r.image}<a class="lightbox-enabled ajax_link" rel="lightbox-galery" href="{$r.img_path}">{$LANG.SHOW}</a>{/if}
            </div>
            <input type="file" name="Filedata" style="width:100%" />
        </div>
        <div class="rubric_opt">
            <div>
                {$LANG.RUBRIC_OTHER_IMG}
            </div>
            <input type="file" name="upfile[]" id="upfile" style="width:100%" />
            {if !$is_add && $r.more_img_path}
                {foreach key=iid item=more_img_path from=$r.more_img_path}
                    <label>
                        <a class="lightbox-enabled ajax_link" rel="lightbox-galery" href="{$more_img_path}">{$LANG.SHOW}</a> <input type="checkbox" name="delete_img[{$iid}]" value="1" /> {$LANG.DELETE}
                    </label>
                {/foreach}
            {/if}
        </div>	
		</div>  
	</div>
</div>

	<div>
        <input type="hidden" name="do_operations" value="1" />
		<input type="submit" id="save_btn" value="{$LANG.SAVE}" onclick="saveRubric();return false;" />
        <input name="cancel" id="cancel_btn" type="button" onclick="window.history.go(-1)" value="{$LANG.CANCEL}" />
	</div>
</form>
{literal}
<script type="text/javascript">
    function toggleBindAll(){
        if($('#bind_all').prop('checked')){
            $('select#cats').prop('disabled', true);
        } else {
            $('select#cats').prop('disabled', false);
        }
    }
	  function saveRubric(){
        if($('#title').val().length < 3){
            {/literal}core.alert('{$LANG.RUBRIC_ERROR_TITLE}', '{$LANG.ERROR}');{literal}
            return false;
        }
        cat_id = $('#cats').val();
        if(cat_id != null || $('#bind_all').prop('checked')){
            $('#save_btn').prop('disabled', true);
            $('#save_btn').val('{/literal}{$LANG.LOADING}{literal} ...');
            $('#cancel_btn').hide();
            ajaxIndicatorStart('rubric_form');
            $('#rubric_form').submit();
        } else {
            {/literal}core.alert('{$LANG.RUBRIC_ERROR_CATS}', '{$LANG.ERROR}');{literal}
        }
	  }
    $(document).ready(function(){
        $('#title').focus();
        $('#upfile').MultiFile({ accept:'jpeg,gif,png,jpg', max:15, STRING: { remove:LANG_CANCEL, selected:LANG_FILE_SELECTED, denied:LANG_FILE_DENIED, duplicate:LANG_FILE_DUPLICATE } });
    });
</script>
{/literal}