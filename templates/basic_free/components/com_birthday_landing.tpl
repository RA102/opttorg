<article>
    <div class="">
        <div class="con_text">
            <div class="item-description" style="text-align: center;" style="overflow:hidden">
                {if $article.image}
                    <img src="/images/photos/medium/{$article.image}" alt="{$article.title|escape:html}" class="" />
                {/if}
                {$article.content}
            </div>
        </div>
    </div>
</article>
