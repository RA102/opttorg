<div class="panel panel-default">
<div class="panel-heading"><span class="badge pull-right">{$total}</span><h3 class="panel-title">{$LANG.SEARCH_BY_TAG}: <strong>{$query}</strong>, {$LANG.SEARCH_FOR} <a href="javascript:" onclick="searchOtherTag()" style="border-bottom:#000 1px dashed;">{$LANG.ANOTHER_TAG}</a></h3></div>
<div class="panel-body">
<div id="other_tag" style="display:none">
    <form id="sform"action="/search" method="post" enctype="multipart/form-data">
        <div class="row margin-bottom-row">
            <div class="col-sm-8">
            <input type="hidden" name="do" value="tag" />
            <input type="text" name="query" id="query" size="40" value="" placeholder="{$LANG.SEARCH_BY_TAG}" class="text-input" />
            <script type="text/javascript">
                {$autocomplete_js}
            </script>
            </div>
            <div class="col-sm-2">
            <input type="submit" class="btn btn-block" value="{$LANG.FIND}"/>
            </div>
            <div class="col-sm-2">
            <input type="button" class="btn btn-block" value="{$LANG.CANCEL}" onclick="$('#other_tag').hide();$('#found_search').fadeIn('slow');"/>
            </div>
        </div>
    </form>
</div>

{if $results}
	{foreach key=tid item=item from=$results}
<div class="media {cycle values="rowa1,rowa2"}">
  <div class="pull-left">
    <img class="media-object" src="/components/search/tagicons/{$item.target}.gif">
  </div>
  <div class="media-body">
    <h4 class="media-heading">{$item.itemlink}</h4>
    <div class="tagsearch_bar"><small><em>{$item.tag_bar}</em></small></div>
  </div>
</div>
	{/foreach}
	{$pagebar}
{else}
<span class="text-danger">{$LANG.BY_TAG} <strong>"{$query}"</strong> {$LANG.NOTHING_FOUND}. <a href="{$external_link}" target="_blank">{$LANG.CONTINUE_TO_SEARCH}?</a></span>
{/if}
</div>
</div>
<script type="text/javascript">
function searchOtherTag(){
    $('#found_search').hide();$('#other_tag').fadeIn('slow');
    $('.text-input').focus();
}
</script>