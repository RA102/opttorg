{add_js file='modules/mod_mrq/breakingNews.js'}{add_css file='modules/mod_mrq/breakingNews.css'}<div class="breakingNews {$mrqsize} {$mrqmargin}" id="bn{$mrqid}">    <div class="bn-title"><h2>{$mrqfeedlabels}</h2><span></span></div>    <ul></ul>    <div class="bn-navi">        <span></span>        <span></span>    </div></div>{literal}<script>	$(window).load(function(e) {        $("#bn{/literal}{$mrqid}{literal}").breakingNews({			width			:'{/literal}{$mrqwidth}{literal}',			color			:'{/literal}{$mrqcolor}{literal}',			border			:{/literal}{$mrqborder}{literal},			effect			:'{/literal}{$mrqeffect}{literal}',			fontstyle		:'{/literal}{$mrqfontstyle}{literal}',			autoplay		:{/literal}{$mrqautoplay}{literal},			timer			:{/literal}{$mrqtimer}{literal},			feed			:"{/literal}{$mrqfeed}{literal}",			feedlabels		:"{/literal}{$mrqfeedlabels}{literal}",			feedcount		:{/literal}{$mrqfeedcount}{literal}			});    });</script>{/literal}