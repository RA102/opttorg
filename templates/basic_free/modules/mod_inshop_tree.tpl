<div class="module-heading"><h4><span>Категории</span></div>
<nav class="side-nav">
<ul class="list-unstyled">
{foreach key=key item=item from=$items name=topacide}
{if $item.parent_id == 1}
<li><a href="/shop/{$item.seolink}">{$item.title}</a></li>
{/if}
{/foreach}
</ul>
</nav>