{* ================================================================================ *}
{* ================== Вкладка "Места" в профиле пользователя ====================== *}
{* ================================================================================ *}

{if $items}

    {if !$is_ajax}
    <strong style="margin-bottom: 20px">
        {if $my_profile}Места, которые Вы посещали:{else}Места, которые посещал пользователь:{/if}
    </strong>
    {/if}
    
    <div id="map_places_list">
        {include file='p_maps_places_items.tpl'}

        {if $pagebar}
            <div>
                {$pagebar}
                <div class="loading" style="display:none;background: url(/images/ajax-loader.gif) no-repeat left center; padding-left:50px">Загрузка...</div>
            </div>
            <script type="text/javascript">
                {literal}
                function getPlaces(page){
                    $('#map_places_list').load('/plugins/p_maps_places/load.php', {page: page, id:{/literal}{$user_id}{literal}}, function(html){});
                    $('.loading').show();
                }
                {/literal}
            </script>
        {/if}
    </div>

{else}
	<p class="text-danger">Пользователь не отмечал посещенные места.</p>
{/if}
