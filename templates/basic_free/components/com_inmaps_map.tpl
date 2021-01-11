<!-- MAP -->

<div id="map_wrapper">


    <div id="citypanel">

        {if $cfg.mode != 'city'}
            {if $cfg.city_sel != 'none'}
                <div id="location"><a href="javascript:selectCity('{$cfg.city_sel}')" title="{$LANG.MAPS_SELECT_CITY_LINK}">{if $location.city}{$location.city}{else}Все города{/if}</a></div>
            {/if}
        {/if}

        <div id="marker_pages_link">
            Страницы: <span id="marker_pages"></span>
        </div>

        <div class="marker_loading">{$LANG.MAPS_MARKERS_LOADING} <span id="mprc"></span></div>

        <div id="fullscreen_link">
            <a href="#" class="btn btn-default" onclick="toggleMapSize()" title="На весь экран"><span class="glyphicon glyphicon-fullscreen"></span></a>
        </div>

        <div id="map_rss_link">
            <a class="btn btn-default" href="/rss/maps/all/feed.rss" title="RSS-feed"><span class="glyphicon glyphicon-signal"></span></a>
        </div>

        <div id="map_find_addr">
            <form action="" onsubmit="return findAddress()">
                <input type="text" id="map_addr" placeholder="Найти адрес" />
            </form>
            <script type="text/javascript">
                {literal}
                function findAddress(){
                    var addr = user_city+' '+$('#map_addr').val();
                    centerAddress(addr, 18);
                    return false;
                }
                {/literal}
            </script>
        </div>

    </div>

    <div id="citymap"></div>

    <div id="inmaps_map_filter" {if !$cfg.map_filter || $root_cat.id!=1}style="display:none"{/if} class="hidden-sm hidden-xs">
        <form id="filter_form" action="/maps/ajax/get-markers" method="POST">

        <input type="hidden" name="user_city" value="{if $location.city}{$location.city}{else}{$cfg.city}{/if}" />
        <input type="hidden" name="from" value="0" />

        <div class="title">{$LANG.MAPS_MAP_FILTER}</div>

        <div class="sel_all">
            <a href="javascript:" onclick="$('#filter_form input[type=checkbox]').prop('checked', true);getMarkers()">{$LANG.MAPS_SELECT_ALL}</a> | <a href="javascript:" onclick="$('#filter_form li ul').show()">{$LANG.MAPS_EXPAND}</a>
        </div>

        <ul id="inmaps_map_tree">

        {foreach key=key item=item from=$cats_tree}

            {if $item.NSLevel < $last_level}
                {math equation="x - y" x=$last_level y=$item.NSLevel assign="tail"}
                {section name=foo start=0 loop=$tail step=1}
                    </ul></li>
                {/section}
            {/if}
            {if $item.NSRight - $item.NSLeft == 1}
                <li>
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="20">
                                <input type="checkbox" id="cat{$item.id}" name="tree_cat[]" value="{$item.id}" {if in_array($item.id, $checked_cats)}checked="checked"{/if} onclick="selectMapCat(this, {$item.id})" />
                            </td>
                            <td>
                                <a href="javascript:" onclick="submitMap({$item.id})" title="{$LANG.MAPS_SHOW_ONLY} {$item.title|lower}">
                                    {$item.title}
                                </a>
                            </td>
                        </tr>
                    </table>
                </li>
            {else}
                <li>
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="20"><input type="checkbox" id="cat{$item.id}" name="tree_cat[]" value="{$item.id}" {if in_array($item.id, $checked_cats)}checked="checked"{/if} onclick="selectMapCat(this, {$item.id})" /> </td>
                            <td>
                                <a href="javascript:" onclick="submitMap({$item.id})" title="{$LANG.MAPS_SHOW_ONLY} {$item.title|lower}">
                                    {$item.title}
                                </a>
                            </td>
                        </tr>
                    </table>
                    <ul style="display:none" rel="{$item.id}">
            {/if}
            {assign var="last_level" value=$item.NSLevel}

        {/foreach}
        </ul>

        <input type="button" name="refresh_map" id="refresh_btn" value="{$LANG.MAPS_RELOAD_MAP}" onclick="getMarkers()" />
        </form>
    </div>

</div>

{if $root_cat.id>1}<br/>{/if}

<script type="text/javascript">
    {literal}
        $(document).ready(function(){
    {/literal}

            initGeoSystem({literal}{{/literal}
                zoom_city: {$cfg.zoom_city},
                zoom_country: {$cfg.zoom_country},
                city_zoom_level: {$cfg.city_zoom_level},
                zoom_min: {$cfg.zoom_min},
                zoom_max: {$cfg.zoom_max},
                cl_grid: {$cfg.cl_grid},
                cl_zoom: {$cfg.cl_zoom},
                cl_size: {$cfg.cl_size},
                {if $cfg.center_lat && $cfg.center_lng}
                    center_lng: '{$cfg.center_lng}',
                    center_lat: '{$cfg.center_lat}',
                {else}
                    center_lng: '',
                    center_lat: '',
                {/if}
                map_type: '{$cfg.map_type}',
                mode: '{if $location.city}city{else}country{/if}'
            {literal}}{/literal});

    {literal}
        });
    {/literal}
</script>