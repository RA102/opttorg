<div class="city_short" style="display:block">
    <div class="city_short_tip">
        <h4 class="city_short_name">{$city.name}</h4>
        <div class="city_short_count">{$city.items_count|spellcount:$LANG.MAPS_OBJECT:$LANG.MAPS_OBJECT2:$LANG.MAPS_OBJECT10}</div>
    </div>

    <div class="city_short_link" style="clear:both;_margin-bottom:20px;">
        <a href="javascript:zoomToCity('{$city.name}')">{$LANG.MAPS_ZOOM_CITY}</a>
    </div>
    <br/>
</div>