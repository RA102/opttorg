		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">{$LANG.SUBSCRIBERS} <span id="real_count_subscribe" class="badge pull-right">{$channel.count_subscribe}</span></h4>
			</div>
			<div class="panel-body">
{if $channel.subscribe}
    {foreach key=tid item=s_user from=$channel.subscribe}
<div class="media">
  <a class="pull-left" href="{profile_url login=$s_user.login}" title="{$s_user.nickname|escape:'html'}"><img class="media-object" src="{$s_user.avatar_url}" alt="{$s_user.nickname|escape:'html'}" /></a>
  <div class="media-body">
    <h4 class="media-heading"><a href="{profile_url login=$s_user.login}" title="{$s_user.nickname|escape:'html'}">{$s_user.nickname}</a></h4>
    <div class="media-hinttext">
	<a href="/video/channel/{$s_user.login}.html"><span class="glyphicon glyphicon-film"></span> {$LANG.VIEW_TO_CHANNEL}</a>
	</div>
  </div>
</div>
    {/foreach}
{else}
    <p class="text-danger">{$LANG.NOT_SUBSCRIBERS}...</p>
{/if}
			</div>
{if $channel.more_subscribe}
<div class="panel-footer">
<a href="javascript:;" onclick="getSubscribe({$channel.more_subscribe}, '{$usr.id}');" title="{$LANG.SEE_NEXT}">{$LANG.SEE_NEXT}"</a></div>{/if}			
		</div>	
<script type="text/javascript">
	{literal}
	$(document).ready(function(){
		$('.chan_subs_usr').hover(
			function() {
				$(this).find('.chan_subs_to_ch').fadeIn();
			},
			function() {
				$(this).find('.chan_subs_to_ch').fadeOut();
			}
		);
	});
{/literal}
</script>