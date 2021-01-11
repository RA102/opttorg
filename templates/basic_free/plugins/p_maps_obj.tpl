{* ================================================================================ *}
{* ================ Вкладка "Объекты" в профиле пользователя ====================== *}
{* ================================================================================ *}

{if $items}

    {if $my_profile}
    <div style="margin-bottom: 20px;background: url(/templates/_default_/images/icons/add.png) no-repeat left center; padding:1px; padding-left:20px">
        Вы можете <a href="/maps/add.html">добавить новый объект</a>
    </div>
    {/if}

    <div id="map_objects_list">
        {include file='p_maps_obj_items.tpl'}    

        {if $pagebar}
            <div>
                {$pagebar}
                <div class="loading" style="display:none;background: url(/images/ajax-loader.gif) no-repeat left center; padding-left:50px">Загрузка...</div>
            </div>
            <script type="text/javascript">
                {literal}
                function getObjects(page){
                    $('#map_objects_list').load('/plugins/p_maps_obj/load.php', {page: page, id:{/literal}{$user_id}{literal}}, function(html){});
                    $('.loading').show();
                }
                {/literal}
            </script>
        {/if}
    </div>

{else}
	<p class="text-danger">Пользователь не добавлял объекты на карте.</p>
{/if}
