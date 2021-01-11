<div class="panel panel-{if $mod.css_prefix}{$mod.css_prefix}{else}default{/if}">
    {if $mod.showtitle neq 0}
        <div class="panel-heading"><h4 class="panel-title">{$mod.title}{if $cfglink} <a href="javascript:moduleConfig({$mod.id})" title="{$LANG.CONFIG_MODULE}"><span style="font-size:.8em;color:silver;" class="glyphicon glyphicon-cog"></span></a>{/if}</h4>
        </div>
    {/if}
    {$mod.body}
</div>