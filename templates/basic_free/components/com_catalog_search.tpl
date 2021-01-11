<h1 class="con_heading">{$LANG.SEARCH_IN_CAT} <a href="/catalog/{$cat.id}">&mdash; {$cat.title}</a></h1>
<p><strong>{$LANG.FILL_FIELDS}:</strong></p><br />

<form action="/catalog/{$id}/search.html" name="searchform" method="post" >
<div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <td width="20%" valign="top">{$LANG.TITLE}: </td>
                <td valign="top"><input style="position:relative;width:100%;" name="title" type="text" id="title" size="35" value="" /></td>
            </tr>
        {foreach key=tid item=value from=$fstruct}
                <tr>
                    <td width="20%" valign="top">{$value}: </td>
                    <td valign="top"><input name="fdata[{$tid}]" style="position:relative;width:100%;" type="text" id="fdata[]" size="35" value="" /> </td>
                </tr>
        {/foreach}
            <tr>
                <td width="20%" valign="top">{$LANG.TAGS}: </td>
                <td valign="top"><input name="tags" type="text" style="position:relative;width:100%;" id="tags" size="35" value="" /><br/><?php echo tagsList($id);?></td>
            </tr>
        </table>
</div>
		<input type="submit" name="gosearch" value="{$LANG.SEARCH_IN_CAT}" />
		<input type="button" onclick="window.history.go(-1);" name="cancel" value="{$LANG.CANCEL}" />
</form>