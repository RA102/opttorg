<ul class="list-group">
    {foreach key=id item=item from=$arhives}
        <li class="list-group-item">
            <a href="/arhive/{$item.year}/{$item.month}">{$item.fmonth}</a>{if $date.year == 'all'}, <a href="/arhive/{$item.year}">{$item.year}</a>{/if} <span>({$item.num|spellcount:$LANG.ARTICLE1:$LANG.ARTICLE2:$LANG.ARTICLE10})</span>
        </li>
    {/foreach}
</ul>