{if $is_allow}

    {if $myprofile || $is_admin}
        <div class="float_bar">
            <a class="btn btn-default" href="/users/{$usr.id}/editphoto{$photo.id}.html">{$LANG.EDIT}</a>
            <a class="btn btn-default"  href="/users/{$usr.id}/delphoto{$photo.id}.html">{$LANG.DELETE}</a>
        </div>
    {/if}

    <h1 class="con_heading">{$photo.title}</h1>
    {if $photo.description}
        <div class="item-description">{$photo.description}</div>
    {/if}

	<div class="row margin-bottom-row">
		<div class="col-md-9 col-sm-7">
    <figure class="usr_photo_view1">
        <img border="0" src="/images/users/photos/medium/{$photo.imageurl}" alt="{$photo.title|escape:'html'}" />
			    {if $previd}
                    <a class="u-prev" href="/users/{$usr.id}/photo{$previd.id}.html" title="{$previd.title|escape:'html'}"><span class="glyphicon glyphicon-chevron-left"></span></a>
                {/if}
                {if $nextid}
                    <a class="u-next" href="/users/{$usr.id}/photo{$nextid.id}.html" title="{$nextid.title|escape:'html'}"><span class="glyphicon glyphicon-chevron-right"></span></a>
                {/if}
    </figure>
		</div>
		<div class="col-md-3 col-sm-5">
    <div class="well">
        <div><span class="glyphicon glyphicon-user"></span> {$photo.genderlink}</div> <div><span class="glyphicon glyphicon-time"></span> {$photo.pubdate}</div> <div><span class="glyphicon glyphicon-eye-open"></span> {$LANG.HITS}: {$photo.hits}</div>
    </div>	
		</div>
	</div>
{else}
    <h1 class="con_heading">{$photo.title}</h1>
    {if $photo.description}
        <div class="item-description">{$photo.description}</div>
    {/if}

	<div class="row margin-bottom-row">
		<div class="col-md-9 col-sm-7">
    <figure class="usr_photo_view1">
         <img border="0" src="/templates/_default_b_/img/fotoblock.png" alt="{$LANG.PHOTO_NOT_FOUND_TEXT}" />
				{if $previd}
                    <a class="u-prev" href="/users/{$usr.id}/photo{$previd.id}.html" title="{$previd.title|escape:'html'}"><span class="glyphicon glyphicon-chevron-left"></span></a>
                {/if}
                {if $nextid}
                    <a class="u-next" href="/users/{$usr.id}/photo{$nextid.id}.html" title="{$nextid.title|escape:'html'}"><span class="glyphicon glyphicon-chevron-right"></span></a>
                {/if}
    </figure>
		</div>
		<div class="col-md-3 col-sm-5">
    <div class="well">
        <div><span class="glyphicon glyphicon-user"></span> {$photo.genderlink}</div> <div><span class="glyphicon glyphicon-time"></span> {$photo.pubdate}</div> <div><span class="glyphicon glyphicon-eye-open"></span> {$LANG.HITS}: {$photo.hits}</div>
    </div>	
		</div>
	</div>
{/if}