<form action="/forum/renamethread{$thread.id}.html" method="POST" id="renamethread_form">
    <input type="hidden" name="gorename" value="1" />
	<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <td valign="top">{$LANG.THREAD_TITLE}:</td>
            <td valign="top">
                <input type="text" size="45" value="{$thread.title|escape:html}" name="title" id="title" class="text-input" />
            </td>
        </tr>
        <tr>
            <td valign="top">{$LANG.DESCRIPTION}:</td>
            <td valign="top">
                <input type="text" size="45" value="{$thread.description|escape:html}" name="description" class="text-input" />
            </td>
        </tr>
    </table>
	</div>
</form>
<script type="text/javascript" src="/includes/jquery/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#title').focus();
    });
</script>