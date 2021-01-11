<div class="btn-group">
        {if !$thread.closed}
    <a class="btn btn-primary" href="/forum/reply{$thread.id}.html">{$LANG.NEW_MESSAGE}</a>
        {if !$is_subscribed}
    <a class="btn btn-default" href="/forum/subscribe{$thread.id}.html">{$LANG.SUBSCRIBE_THEME}</a>
        {else}
    <a class="btn btn-default" href="/forum/unsubscribe{$thread.id}.html">{$LANG.UNSUBSCRIBE}</a>
        {/if}
        {else}
    <a class="btn btn-default">{$LANG.THREAD_CLOSE}</a>
        {/if}
	<a class="btn btn-default" href="/forum/{$forum.id}"><span title="{$LANG.BACKB}" class="glyphicon glyphicon-arrow-left"></span></a>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Открыть</span>
  </button>
  <ul class="dropdown-menu pull-right">
        {if $is_admin || $is_moder}
            <li {if $thread.closed}style="display: none"{/if}><a href="javascript:" onclick="forum.ocThread({$thread.id}, 1);">{$LANG.CLOSE}</a></li>
            <li {if !$thread.closed}style="display: none"{/if}><a href="javascript:" onclick="forum.ocThread({$thread.id}, 0);">{$LANG.OPEN}</a></li>

            <li {if $thread.pinned}style="display: none"{/if}><a href="javascript:" onclick="forum.pinThread({$thread.id}, 1);">{$LANG.PIN}</a></li>

            <li {if !$thread.pinned}style="display: none"{/if}><a href="javascript:" onclick="forum.pinThread({$thread.id}, 0);">{$LANG.UNPIN}</a></li>

            <li><a href="javascript:" onclick="forum.moveThread({$thread.id});">{$LANG.MOVE}</a></li>
        {/if}
        {if $is_admin || $is_moder || $thread.is_mythread}
            <li><a href="javascript:" onclick="forum.renameThread({$thread.id});">{$LANG.RENAME}</a></li>
        {/if}
        {if $is_admin || $is_moder}
            <li><a href="javascript:" onclick="forum.deleteThread({$thread.id}, '{csrf_token}');">{$LANG.DELETE}</a></li>
        {/if}  
  </ul>
</div>