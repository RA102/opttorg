<h1 class="con_heading">{$LANG.KARMA_HISTORY} - {$usr.nickname}</h1>
{if $karma}
<div class="list-group">
		{foreach key=id item=karm from=$karma}
			<a class="list-group-item" href="{profile_url login=$karm.login}" title="{$karm.nickname}">
				{$karm.fsenddate}&nbsp;&nbsp;<span class="text-info"><span class="glyphicon glyphicon-user"></span> {$karm.nickname}</span>
				{if $karm.kpoints>0}
                	<span class="badge pull-right karma-badge-good">+{$karm.kpoints}</span>
                {else}
                    <span style="badge pull-right karma-badge-bad">{$karm.kpoints}</span>
                {/if}
			</a>
		{/foreach}
</div>
{else}
<p>{$LANG.KARMA_NOT_MODIFY}</p>
<p>{$LANG.KARMA_NOT_MODIFY_TEXT}</p>
<p>{$LANG.KARMA_DESCRIPTION}</p>
{/if}