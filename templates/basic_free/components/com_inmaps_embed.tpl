<!DOCTYPE HTML>
<html>
    <head>
        <link href="/templates/{$template}/css/styles.css" rel="stylesheet" type="text/css" />
        <link href="/templates/{$template}/css/inmaps.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/includes/jquery/jquery.js"></script>
        <script language="JavaScript" type="text/javascript" src="/components/maps/systems/{$cfg.maps_engine}/geo.js"></script>
        {$api_key}
    </head>

    <body style="margin:0;padding:0">

        <div id="placemap" style="width:100%;height:100%;margin:0;border:none"></div>

        <script language="JavaScript" type="text/javascript">

            var options = {literal}{{/literal}
                    zoom_min: {$cfg.zoom_min},
                    zoom_max: {$cfg.zoom_max},
                    map_type: '{$cfg.minimap_type}',
                    zoom: '{$cfg.zoom_minimap}',
                    is_embed: true,
                    item_id: {$item.current_marker.id}
            {literal}}{/literal};

            initPlaceMapXY('{$item.current_marker.lng}', '{$item.current_marker.lat}', "{$item.title|escape:'html'}", options);

        </script>
    </body>

</html>
