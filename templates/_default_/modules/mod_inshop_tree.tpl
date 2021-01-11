<div>
    <ul id="inshop_tree">

        {foreach key=key item=item from=$items}

            {if $item.NSLevel < $last_level}
                {math equation="x - y" x=$last_level y=$item.NSLevel assign="tail"}
                {section name=foo start=0 loop=$tail step=1}
                    </ul></li>
                {/section}
            {/if}
            {if $item.NSRight - $item.NSLeft == 1}
                <li>
                    <a href="javascript:" class="cat_none"></a>
                    <span class="folder">
                        {if $item.id != $current_id}
                            <a href="/shop/{$item.seolink}">{$item.title}</a>
                        {else}
                            {$item.title}
                        {/if}
                    </span>
                </li>
            {else}
                <li class="cat">
                    <a href="javascript:" class="cat_plus" style="{if $cfg.expand_all}display:none{/if}" title="Развернуть"></a>
                    <a href="javascript:" class="cat_minus" style="{if !$cfg.expand_all}display:none{/if}" title="Свернуть"></a>
                    <span class="folder">
                        {if $item.id != $current_id}
                            <a href="/shop/{$item.seolink}">{$item.title}</a>
                        {else}
                            {$item.title}
                        {/if}
                    </span>
                    <ul>
            {/if}
            {assign var="last_level" value=$item.NSLevel}

        {/foreach}

    </ul>

</div>
<script type="text/javascript">    

        {if !$cfg.expand_all}
            {literal}
                $('#inshop_tree li > ul').hide();
            {/literal}
        {/if}

        {literal}

        $('.cat_plus').click(function(){
            $(this).hide();
            $(this).parent('li').find('.cat_minus').eq(0).show();
            $(this).parent('li').find('ul').eq(0).show();
        });

        $('.cat_minus').click(function(){
            $(this).hide();
            $(this).parent('li').find('.cat_plus').eq(0).show();
            $(this).parent('li').find('ul').hide();
            $(this).parent('li').find('ul').find('.cat_minus').hide();
            $(this).parent('li').find('ul').find('.cat_plus').show();
        });


//        $('#inshop_tree li').hover(
//            function() {
//                $(this).find('ul:first').slideDown();
//                $(this).find('a:first').addClass("hover");
//            },
//            function() {
//                $(this).find('ul:first').slideUp();
//                $(this).find('a:first').removeClass("hover");
//            }
//        );

    {/literal}
</script>
