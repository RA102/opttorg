<form action="/forum/movepost.html" method="POST" id="movethread_form">
    <input type="hidden" name="gomove" value="1" />
    <input type="hidden" name="id" value="{$thread.id}" />
    <input type="hidden" name="post_id" value="{$post_id}" />
	<div>
{$LANG.MOVE_POST}:<br />
<select name="new_thread_id">
    {$threads}
 </select>
</div>
</form>