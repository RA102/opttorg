<h1 class="con_heading">{$LANG.MAPS_ITEM_EMBED}</h1>
<div class="row margin-bottom-row">
	<div class="col-md-6">
            <h3>{$item.title}</h3>
			<div class="well">
            <p>{$LANG.MAPS_ITEM_EMBED_HINT}</p>

            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td height="50" width="120">{$LANG.MAPS_ITEM_EMBED_W}:</td>
                    <td><input type="text" size="10" value="600" id="embed_w" onkeyup="makeCode()" /></td>
                </tr>
                <tr>
                    <td>{$LANG.MAPS_ITEM_EMBED_H}:</td>
                    <td><input type="text" size="10" value="400" id="embed_h" onkeyup="makeCode()" /></td>
                </tr>
            </table>

            <input type="hidden" id="embed_preset" value="{$code|escape:'html'}" />

            <h3>{$LANG.MAPS_ITEM_EMBED_COPY}:</h3>
            <textarea id="embed_code" style="width:90%; height:100px">{$code}</textarea>
			</div>
            <p><a href="/maps/{$item.seolink}.html" class="btn btn-default">{$LANG.CANCEL}</a></p>
	</div>
	<div class="col-md-6">
            <h3>{$LANG.MAPS_ITEM_EMBED_SAMPLE}</h3>
            <div id="placemap" style="width:100%;height:391px"></div>
	</div>
</div>

<script language="JavaScript" type="text/javascript">

    {literal}
    function makeCode(){
        var code = $('#embed_preset').val();
        var w = $('#embed_w').val();
        var h = $('#embed_h').val();
        var compiled = code.replace('W', w);
        compiled = compiled.replace('H', h);
        $('#embed_code').val(compiled);
    }
    {/literal}

    var options = {literal}{{/literal}
            zoom_min: {$cfg.zoom_min},
            zoom_max: {$cfg.zoom_max},
            map_type: '{$cfg.minimap_type}',
            zoom: '{$cfg.zoom_minimap}',
            is_embed: true,
            item_id: {$item.current_marker.id}
    {literal}}{/literal};

    {literal}
        $(document).ready(function(){
    {/literal}
            initPlaceMapXY('{$item.current_marker.lng}', '{$item.current_marker.lat}', "{$item.title|escape:'html'}", options);
            makeCode();
    {literal}
        });
    {/literal}

</script>
