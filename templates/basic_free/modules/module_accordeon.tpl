  <div class="panel panel-{if $mod.css_prefix}{$mod.css_prefix}{else}default{/if}">
    <div class="panel-heading">
      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#id{$mod.id}">{$mod.title} <span class="pull-right"><span class="glyphicon glyphicon-chevron-down"></span></span></a></h4>
    </div>
    <div id="id{$mod.id}" class="panel-collapse collapse{if $mod.css_prefix} in{/if}">
      <div class="panel-body">
		{$mod.body}
      </div>
    </div>
  </div>