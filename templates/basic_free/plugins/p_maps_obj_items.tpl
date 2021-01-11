		{foreach key=id item=item from=$items}
  <div class="media {cycle values="rowa1,rowa2"}" style="padding:10px;margin:0;">
    <a class="pull-left" href="/maps/{$item.seolink}.html" rel="nofollow">
      <img class="media-object map-latest" src="/components/maps/images/markers/{$item.marker}" />
    </a>
    <div class="media-body">
      <h5 class="media-heading"><a href="/maps/{$item.seolink}.html">{$item.title}</a></h5>
	  <div class="media-hinttext">
		<span class="monospc"><span class="glyphicon glyphicon-time"></span> {$item.pubdate}</span>
        {if $item.addr_city}<span><span class="glyphicon glyphicon-map-marker"></span> {$item.addr_city}, {$item.addr_prefix} {$item.addr_street}, {$item.addr_house}</span>{/if}
	  </div>		
    </div>
  </div>		
		{/foreach}