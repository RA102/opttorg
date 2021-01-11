<div id="add_album_form">
    <form action="/video/operations_album.html" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="csrf_token" value="{csrf_token}" />
        <label>{$LANG.ALBUM_TITLE}</label>
        <input name="title" id="title_album" type="text" class="text-input" value=""/>
        <label>{$LANG.ALBUM_DESCS}</label>
        <textarea name="description" cols="1" rows="7" wrap="on" class="text-input"></textarea>
        <div id="submit_album">
            <input type="hidden" name="add_album" value="1" />
            <input type="submit"  value="{$LANG.ALBUM_CREATE}" />
        </div>
    </form>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#title_album').focus();
    });
</script>
{/literal}