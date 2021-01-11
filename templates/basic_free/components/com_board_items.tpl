{if $page_title}<h1 class="con_heading">{$page_title}</h1>{/if}
{if $order_form}{$order_form}{/if}
	{if $items}
			{$col="1"}
			{if $maxcols>=4}{$maxcols="4"}{$columns="3"}{else}{$columns=12/$maxcols}{/if}
            {$is_moder="0"}
			{foreach key=tid item=con from=$items name=counter1}
{if $col==1}<div class="row margin-bottom-row {cycle values="rowb2,rowb1"}">{/if}
				<div class="col-md-{$columns}">
<div class="media">
{if $cfg.photos}
  <a class="pull-left" href="/board/read{$con.id}.html" title="{$con.title|escape:'html'}"><img class="media-object" src="/images/board/small/{$con.file}" alt="{$con.title|escape:'html'}" /></a>
{/if}
  <div class="media-body">
    <h4 class="media-heading"><a href="/board/read{$con.id}.html" title="{$con.title|escape:'html'}">{if $con.is_vip}<span class="glyphicon glyphicon-bookmark text-danger"></span> {/if}{$con.title}</a></h4>
	<div class="media-description">{$con.content|strip_tags|truncate:250}</div>
	<div class="media-hinttext">
{if $con.cat_title}
<span class="monospc"><a href="/board/{$con.category_id}"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;   {$con.cat_title}</a></span>
{/if}
{if $cat.showdate && $con.published}
<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$con.fpubdate}</span>
{/if}
{if !$con.published && $con.is_overdue}
<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$LANG.ADV_EXTEND_INFO}</span>
{elseif !$con.published}
<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$LANG.WAIT_MODER}</span>
{/if}
<span class="monospc"><span class="glyphicon glyphicon-eye-open"></span>  {$con.hits}</span>
{if $con.city}
<span class="monospc"><a href="/board/city/{$con.enc_city|escape:'html'}"><span class="glyphicon glyphicon-globe"></span> {$con.city}</a></span>
{/if}
{if $con.nickname}
<a class="monospc" href="{profile_url login=$con.login}"><span class="glyphicon glyphicon-user"></span> {$con.nickname}</a>
{else}
<span class="monospc"><span class="glyphicon glyphicon-user"></span> {$LANG.BOARD_GUEST}</span>
{/if}	
	</div>
  </div>
</div>				
				</div>
{if $col==$maxcols || $smarty.foreach.counter1.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
			{/foreach}
		{$pagebar}
	{elseif $cat.id != $root_id}
		<p class="error-txt">{$LANG.ADVS_NOT_FOUND}</p>
	{/if}