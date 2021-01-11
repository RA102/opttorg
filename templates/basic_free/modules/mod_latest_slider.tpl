<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
{$col="0"}
  <ol class="carousel-indicators">
{foreach key=aid item=article from=$articles name=artslide1}   
    <li data-target="#carousel-example-generic" data-slide-to="{$col}"{if $smarty.foreach.artslide1.first}class="active"{/if}></li>
{$col=$col+1}	
{/foreach} 	
  </ol>
  <div class="carousel-inner">
{foreach key=aid item=article from=$articles name=artslide2}  
    <a href="{$article.url}" title="{$article.title|escape:'html'}" class="item{if $smarty.foreach.artslide2.first} active{/if}">
	{if $article.image}
      <img src="/images/photos/medium/{$article.image}" alt="{$article.title|escape:'html'}" />
	 {/if}
      <div class="carousel-caption">
        <h3>{$article.title}</h3>
		<p>{$article.description|strip_tags|truncate:100}</p>
      </div>
    </a>
{/foreach}
  </div>
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>