<ul class="nav navbar-nav d-flex ">
<li{if $menuid==1} class="active"{/if}><a href="/">Главная</a></li>
{foreach key=key item=item from=$items}
<li class="{if ($menuid==$item.id || $current_uri == $item.link) || ($currentmenu.NSLeft > $item.NSLeft && $currentmenu.NSRight < $item.NSRight)}active {/if}{$item.css_class}"><a href="{$item.link}" target="{$item.target}" title="{$item.title|escape:'html'}">{$item.title}</a></li>
{/foreach}
</ul>

<div class="position-relative">
    <div class="hidden-lg mobile-menu">
        <div class="item-menu">
            <a href="/shop">
                <img src="/templates/basic_free/images/menu-mobile/catalog_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="/">
                <img src="/templates/basic_free/images/menu-mobile/stoсk_button.png" alt="" width="80">
            </a>
        </div>
        1
        <div class="item-menu">
            <a href="/shop/smesiteli">
                <img src="/templates/basic_free/images/menu-mobile/fauсent_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="/shop/vanny" >
                <img src="/templates/basic_free/images/menu-mobile/bath_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/toulet_bowl_button.png" alt="" width="80">
            </a>
        </div>

        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/catalog_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/stoсk_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/fauсent_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/bath_button.png" alt="" width="80">
            </a>
        </div>
        <div class="item-menu">
            <a href="">
                <img src="/templates/basic_free/images/menu-mobile/toulet_bowl_button.png" alt="" width="80">
            </a>
        </div>

    </div>
</div>