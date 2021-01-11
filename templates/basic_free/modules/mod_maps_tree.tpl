<div class="list-group">
{foreach key=key item=item from=$items}
<a class="list-group-item{if $item.id == $current_id} active{/if}" href="/maps/{$item.seolink}">{if $item.NSRight - $item.NSLeft == 1}&nbsp;&nbsp;&nbsp;&nbsp;{/if}{$item.title}</a>  
{/foreach}
</div>