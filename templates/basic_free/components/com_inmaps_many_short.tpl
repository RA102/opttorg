<div class="maps_many_short">

    <div class="address">
        <span>{$items[0].address}</span>
    </div>

    <div class="list-group">
        {foreach key=i item=item from=$items}
            <a href="/maps/{$item.seolink}.html" class="list-group-item">{$item.title}</a>
        {/foreach}
    </div>

</div>
