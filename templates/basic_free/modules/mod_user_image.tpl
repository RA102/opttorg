{foreach key=tid item=usr from=$users}
    <div class="media-gird" align="center">
    <a href="/users/{$usr.uid}/photo{$usr.id}.html"><img class="media-object" src="/images/users/photos/medium/{$usr.imageurl}" border="0"/></a>
    {if $cfg.showtitle}
        <h4 class="media-heading"><a href="/users/{$usr.uid}/photo{$usr.id}.html">{$usr.title}</a></h4>
        <div class="media-hinttext">{$usr.genderlink}</div>
    {/if}
    </div>
{/foreach}