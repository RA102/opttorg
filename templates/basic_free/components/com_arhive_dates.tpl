<h1 class="con_heading">{$pagetitle}</h1>
{if $items}
    <div class="list-group">
        {foreach key=id item=item from=$items}
          <span class="list-group-item"><a href="/arhive/{$item.year}/{$item.month}">{$item.fmonth}</a>{if $do == 'view'}, <a href="/arhive/{$item.year}">{$item.year}</a>{/if} <span class="badge">{$item.num}</span></span>
        {/foreach}
    </div>
{else}
    <p class="error-txt">{$LANG.ARHIVE_NO_MATERIALS}</p>
{/if}