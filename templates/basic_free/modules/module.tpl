<div class="module {if $mod.css_prefix}{$mod.css_prefix}{else}def-mod{/if}" style="overflow-x: auto;">
    {if $mod.showtitle neq 0}
        <div class="module-heading"><h4><span>{$mod.title}</span></div>
    {/if}
    <div class="module-body">{$mod.body}</div>
</div>
