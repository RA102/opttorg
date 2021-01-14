<article class="row">
    {if $article.showtitle}
        <h1 class="con_heading text-center">{$article.title}</h1>
    {/if}
    <div class="body-page">
    <div class="con_text">
    <div class="item-description" style="overflow:hidden">
        {if $article.image}

                <img src="/images/photos/medium/{$article.image}" alt="{$article.title|escape:html}" class="img-resp" />

        {/if}
        {$article.content}
    </div>
    <div class="media-hinttext">
    {if $article.showdate}
    <span class="monospc"><span class="glyphicon glyphicon-time"></span> {if !$article.published}{$LANG.NO_PUBLISHED}{else}<time datetime="{$article.pubdate}">{$article.pubdate}</time>{/if}</span>
    {/if}
    </div>
    </div>
    {$article.plugins_output_after}
    </div>
</article>