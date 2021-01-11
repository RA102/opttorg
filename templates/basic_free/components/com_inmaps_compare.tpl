<h1 class="con_heading">{$LANG.MAPS_COMPARE}</h1>{if $items}<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">        <tr>            <td>&nbsp;</td>            {foreach key=num item=item from=$items}                <td>                    <a href="/maps/{$item.seolink}.html">{$item.title}</a>                </td>            {/foreach}        </tr>        <tr>            <td>&nbsp;</td>            {foreach key=num item=item from=$items}                <td>                    <a href="/maps/{$item.seolink}.html">                        <img src="/images/photos/small/{$item.filename}" class="media-object" />                    </a>                </td>            {/foreach}        </tr>        <tr>            <td>&nbsp;</td>            {foreach key=num item=item from=$items}                <td>                    <div>                        <a href="/maps/compare/remove/{$item.id}">{$LANG.MAPS_COMPARE_REMOVE}</a>                    </div>                </td>            {/foreach}        </tr>        {foreach key=char_title item=cmp from=$cmp_chars}            <tr>                <td>{$char_title}:</td>                {foreach key=item_id item=item from=$items}                    <td>{if $cmp[$item.id]}{$cmp[$item.id]}{else}&mdash;{/if}</td>                {/foreach}            </tr>        {/foreach}    </table>{else}    <p>{$LANG.MAPS_COMPARE_EMPTY}</p>{/if}<p>
    <input type="button" class="btn btn-default" value="{$LANG.BACK}" onclick="window.location.href='{$last_url}';" />
</p>