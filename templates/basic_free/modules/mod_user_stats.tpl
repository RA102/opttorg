<div id="mod_user_stats" class="list-group">
    {if $cfg.show_total}
        <span class="list-group-item"><h4>{$LANG.HOW_MUCH_US}</h4></span>
            <span class="list-group-item">{$total_usr|spellcount:$LANG.USER:$LANG.USER2:$LANG.USER10}</span>
    {/if}

    {if $cfg.show_online}
    <span class="list-group-item"><h4>{$LANG.STATS_WHO_ONLINE}</h4></span>
            <span class="list-group-item">{$people.users|spellcount:$LANG.USER:$LANG.USER2:$LANG.USER10}</span>
            <span class="list-group-item">{$people.guests|spellcount:$LANG.GUEST:$LANG.GUEST2:$LANG.GUEST10}</span>
                {if $usr_online}
                	<a class="list-group-item" href="/users/all.html" rel="nofollow">{$LANG.SHOW_ALL}</a>
                {else}
                	<a class="list-group-item" href="/users/online.html" rel="nofollow">{$LANG.SHOW_ONLY_ONLINE}</a>
                {/if}
    {/if}

    {if $cfg.show_gender}
    <span class="list-group-item"><h4>{$LANG.STATS_WHO}</h4></span>
            <a class="list-group-item" href="javascript:void(0)" rel=”nofollow” onclick="searchGender('m')">{$gender_stats.male|spellcount:$LANG.MALE1:$LANG.MALE2:$LANG.MALE10}</a>
            <a class="list-group-item" href="javascript:void(0)" rel=”nofollow” onclick="searchGender('f')">{$gender_stats.female|spellcount:$LANG.FEMALE1:$LANG.FEMALE2:$LANG.FEMALE10}</a>
            <span class="list-group-item">{$LANG.UNKNOWN} &mdash; {$gender_stats.unknown}</span>
    {/if}

    {if $cfg.show_city}
    <span class="list-group-item"><h4>{$LANG.WHERE_WE_FROM}</h4></span>
                {foreach key=tid item=city from=$city_stats}
                    {if $city.href}
                       <a href="{$city.href}" class="list-group-item" rel=”nofollow”>{$city.city} <span class="badge">{$city.count}</span></a>
                    {else}
                       <span class="list-group-item">{$city.city} <span class="badge">{$city.count}</span></span>
                    {/if}
                {/foreach}
    {/if}

    {if $cfg.show_bday && $bday}
        <span class="list-group-item"><h4>{$LANG.TODAY_BIRTH}:</h4></span>
            <span class="list-group-item body">
                {$bday}
            </span>
    {/if}

</div>
<script type="text/javascript">
function searchGender(gender){
	$('body').append('<form id="sform" style="display:none" method="post" action="/users"><input type="hidden" name="gender" value="'+gender+'"/></form>');
	$('form#sform').submit();
}
</script>