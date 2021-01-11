    <div class="search_video_top">
        <form class="search_form_module" name="search_form_module" method="get" action="/video/search" autocomplete="off">
            {if $cfg.auto_cat && !$cfg.is_custom_search}
                <input type="hidden" name="cat_id" value="{$params.cat_id}" />
                <input type="hidden" name="cat_link" value="{$current_seolink}" />
            {/if}
    <div class="input-group">
	{if $cfg.is_custom_search && !$cfg.is_show_custom_search}	
		<span class="input-group-btn">
	<a class="btn btn-default" href="#" onclick="$('.custom_search').toggleClass('hid');$(this).toggleClass('ajaxlink');$('.go_search').toggleClass('go_search_replace');return false;" title="{$LANG.CUSTOM_SEARCH}"><span class="glyphicon glyphicon-chevron-down"></span></a>
		</span>
    {/if}		
      <input type="text" id="vautocomplete" name="title" value="{$params.title|escape:html}" placeholder="{$LANG.SEARCH_BY_CAT_TEXT}..." class="form-control" />
      <span class="input-group-btn">
        <input type="submit" class="btn btn-default" value="{$LANG.FIND}" />
      </span>
    </div>
	
    <div id="sel-ajax"></div>
            {if $cfg.is_custom_search}
			
            <div class="custom_search{if !$cfg.is_show_custom_search} hid{/if}">
			<div class="breaker"></div>
				<div class="row margin-bottom-row">
					<div class="col-xs-6">
                        <select name="cat_id" id="scat_id" tabindex="4" onchange="getRubric();">
                            <option value="">{$LANG.SELECT_CAT}</option>
                            {html_options options=$opt_cats selected=$params.cat_id}
                        </select>					
					</div>
					<div class="col-xs-6">
                        <select name="rubric_id" id="srubric_id" tabindex="5" disabled="disabled">
                            <option value="">{$LANG.SELECT_RUBRIC}</option>
                        </select>					
					</div>					
				</div>
				<div class="row margin-bottom-row">
					<div class="col-sm-4">
					{html_options name=countries options=$countries selected=$params.countries onchange="changeParent(this, 'regions')"}
					</div>
					<div class="col-sm-4">
						<select name="regions" onchange="changeParent(this, 'cities')" {if !$regions}disabled="disabled"{/if}>
                            {if !$regions}
                                <option value="0">{$LANG.GEO_SELECT_REGION}</option>
                            {else}
                                {html_options options=$regions selected=$params.regions}
                            {/if}
                        </select>
					</div>
					<div class="col-sm-4">
						<select name="cities" {if !$cities}disabled="disabled"{/if}>
                            {if !$cities}
                                <option value="0">{$LANG.GEO_SELECT_CITY}</option>
                            {else}
                                {html_options options=$cities selected=$params.cities}
                            {/if}
                        </select>
					</div>					
				</div>
				<div class="row margin-bottom-row">
					<div class="col-sm-3">
					<input name="start_date" class="date-pick" id="start-date" tabindex="11" type="text" value="{$params.start_date}" placeholder="дата, {$LANG.FROM}" />
					</div>
					<div class="col-sm-3">
					<input name="end_date" class="date-pick" id="end-date" tabindex="12" placeholder="дата, {$LANG.UNTIL}" type="text" value="{$params.end_date}" />
					</div>
					<div class="col-sm-3">
					<label><input name="is_vib_red" type="checkbox" value="1" {if $params.is_vib_red}checked="checked"{/if}> {$LANG.EDITORS_CHOICE}</label>
					</div>
					<div class="col-sm-3">
					<label><input name="safesearch" type="checkbox" value="1" {if $params.safesearch}checked="checked"{/if}> {$LANG.SAFESEARCH}</label>
					</div>					
				</div>
				<div class="row margin-bottom-row">
					<div class="col-sm-4">
					{html_options name=orderby options=$orderby selected=$params.orderby tabindex="4"}
					</div>
					<div class="col-sm-4">
					{html_options name=orderto options=$orderto selected=$params.orderto tabindex="5"}
					</div>				
					<div class="col-sm-4">
					{html_options name=period options=$period selected=$params.period tabindex="6"}
					</div>				
				</div>
            </div>
            {/if}
        </form>
    </div>
    {if $cfg.alfabeta_ru || $cfg.alfabeta_en}
    <div class="well abc-video no-margin-bottom">
        {if $cfg.alfabeta_ru}{foreach key=key item=ru from=$ru_alfabet}<a href="/video/first_letter-{$ru|urlencode}" class="uc_alpha_link{if $params.first_letter == $ru} lsel{/if}">{$ru}</a>{/foreach}{/if}{if $cfg.alfabeta_en}{foreach key=key item=en from=$en_alfabet}<a href="/video/first_letter-{$en|urlencode}" class="uc_alpha_link{if $params.first_letter == $en} lsel{/if}">{$en}</a>{/foreach}{/if}
    </div>
    {/if}

{if $cfg.is_autocomplete}

    {add_js file='includes/jquery/autocomplete/jquery.autocomplete.min.js'}

    <script type="text/javascript">
    var cat_link = '{$current_seolink}';
    var cat_id   = '{$params.cat_id}';
    {literal}
    $("#vautocomplete").autocomplete({
                    url: "/components/video/ajax/get_autocomplete.php",
                    remoteDataType: "json",
                    minChars: 2,
                    maxItemsToShow: 10,
                    selectFirst: false,
                    mustMatch: true,
                    filterResults: false,
                    delay: 800,
                    extraParams: {cat_link: cat_link, cat_id: cat_id},
                    showResult: function(value, data) {
                        return '<img src="'+data.img+'"/><h3>'+data.title+'</h3><p><span class="icn-views">'+data.hits+'</span><span class="icn-rating">'+data.rating+'</span><span class="icn-comments">'+data.comments_count+'</span><span class="icn-date">'+data.pubdate+'</span></p>';
                    },
                    onItemSelect: function(item) {
                        $( ".component" ).load(item.data.link);
                        window.history.pushState('', item.data.title, item.data.link);
                    }
                }
            );
    </script>{/literal}
{/if}

{if $cfg.is_custom_search}

<script type="text/javascript">
    var srubric_id = '{$params.rubric_id}';
{literal}
$(document).ready(function(){
    $( "#start-date" ).datepicker({
      defaultDate: "+1w",
      numberOfMonths: 2,
      dateFormat: 'yy-mm-dd',
      maxDate: 0,
      showButtonPanel: true,
      onClose: function( selectedDate ) {
        $( "#end-date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#end-date" ).datepicker({
      defaultDate: "+1w",
      numberOfMonths: 2,
      dateFormat: 'yy-mm-dd',
      maxDate: 0,
      showButtonPanel: true,
      onClose: function( selectedDate ) {
        $( "#start-date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    getRubric();
});
function getRubric(){

	var cat_id      = $('#scat_id').val();
    var rubric_list = $('#srubric_id');

	if(cat_id != 0){

		$.post("/components/video/ajax/get_form.php", {value: cat_id, rubric_id: srubric_id}, function(data) {

			if(data != 1){

                if(data.rubric){

                    rubric_list.html('<option value="">'+LANG_SELECT_RUBRIC+'</option>');

                    for(var item_id in data.rubric){

                        rubric_list.append( '<option value="'+ item_id +'" '+ data.rubric[item_id].selected +'>' + data.rubric[item_id].title +'</option>' );

                    }

                    rubric_list.prop('disabled', false);

                } else {

                    rubric_list.prop('disabled', true);
                }

			} else {

                rubric_list.prop('disabled', true);

			}

		}, 'json');

	} else {

        rubric_list.prop('disabled', true);

	}
}
function changeParent (list, child_list_id) {

    var id = $(list).val();

    var child_list = $('select[name='+child_list_id+']');

    if (id == 0) {
        child_list.prop('disabled', true);
        if (child_list_id=='regions'){
            $('select[name=cities]').prop('disabled', true);
        }
        return false;
    }

    $.post('/geo/get', {type: child_list_id, parent_id: id}, function(result){

        if (result.error) { return false; }

        child_list.html('');

        for(var item_id in result.items){

            var item_name = result.items[item_id];

            child_list.append( '<option value="'+ item_id +'">' + item_name +'</option>' );

        }

        child_list.prop('disabled', false);;

        if (child_list_id != 'cities'){
            changeParent(child_list, 'cities');
        }

    }, 'json');

}
</script>
{/literal}{/if}