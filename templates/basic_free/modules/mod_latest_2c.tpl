{if $cfg.is_pag}
	<script type="text/javascript">
		function conPage(page, module_id){
            $('div#module_ajax_'+module_id).css({ opacity:0.4, filter:'alpha(opacity=40)' });
			$.post('/modules/mod_latest/ajax/latest.php', { 'module_id': module_id, 'page':page }, function(data){
				$('div#module_ajax_'+module_id).html(data);
                $('div#module_ajax_'+module_id).css({ opacity:1.0, filter:'alpha(opacity=100)' });
			});
		}
    </script>
{/if}
{if !$is_ajax}<div id="module_ajax_{$module_id}">{/if}
{$col="1"}
{foreach key=aid item=article from=$articles name=art2c}
{if $col==1}<div class="row margin-bottom-row">{/if} 
    <article class="col-md-6 media-gird">
		{if $article.image}
        <div>
            <a href="{$article.url}" title="{$article.title|escape:'html'}"><img src="/images/photos/medium/{$article.image}" alt="{$article.title|escape:'html'}" class="media-object" /></a>
        </div>
		{/if}
		<h4 class="media-heading"><a href="{$article.url}" title="{$article.title|escape:'html'}">{$article.title}</a></h4>
        {if $cfg.showdesc}
            <div class="media-description">{$article.description|strip_tags|truncate:200}</div>
        {/if} 
		{if $cfg.showdate}
            <div class="media-hinttext">
                <span class="monospc"><span class="glyphicon glyphicon-time"></span> {$article.fpubdate}</span> <a class="monospc" href="{profile_url login=$article.user_login}"><span class="glyphicon glyphicon-user"></span> {$article.author}</a> {if $cfg.showcom} <a class="monospc" href="{$article.url}" title="{$article.comments|spellcount:$LANG.COMMENT1:$LANG.COMMENT2:$LANG.COMMENT10}"><span class="glyphicon glyphicon-share-alt"></span> {$article.comments}</a> <span class="monospc"><span class="glyphicon glyphicon-eye-open"></span> {$article.hits}</span>{/if}
            </div>
        {/if}		
    </article>
{if $col==2 || $smarty.foreach.art2c.last}</div>{$col="1"}{else}{$col=$col+1}{/if}
{/foreach}
{if $cfg.showrss}
	<a style="margin-top:15px;" class="btn btn-default" href="/rss/content/{if $cfg.cat_id}{$cfg.cat_id}{else}all{/if}/feed.rss">{$LANG.LATEST_RSS}</a>
{/if}
{if $cfg.is_pag && $pagebar_module}
    {$pagebar_module}
{/if}
{if !$is_ajax}</div>{/if}