  <div class="float_bar">
    <a class="btn {if $link.selected=='latest'}btn-primary{else}btn-default{/if}" rel=”nofollow” href="{$link.latest}">{$LANG.LATEST}</a>
    <a class="btn {if $link.selected=='positive'}btn-primary{else}btn-default{/if}" rel=”nofollow” href="{$link.positive}">{$LANG.POSITIVE}</a>
    <a class="btn {if $link.selected=='rating'}btn-primary{else}btn-default{/if}" rel=”nofollow” href="{$link.rating}">{$LANG.RATING}</a>
    {if $link.selected=='group'}
    <a class="btn btn-primary" rel=”nofollow” href="{$link.group}">{$LANG.GROUP_SEARCH_NAME}</a>
    {/if}
	{if $cfg.sw_search}
	<a class="btn btn-default" title="{$LANG.USERS_SEARCH}" href="javascript:void(0)" onclick="$('#users_sbar').slideToggle('fast');"><span class="glyphicon glyphicon-search"></span></a>	
	{/if}
  </div>

<h1 class="con_heading">{$LANG.USERS}</h1>
{if $cfg.sw_search}
<div id="users_sbar" {if !$stext}style="display:none;"{/if}>
  <form name="usr_search_form" method="post" action="/users">
 <div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <td width="280" colspan="2"><select style="width:240px;color:#999;" name="gender" id="gender" class="field" style="width:150px">
            <option value="f" {if $gender == 'f'}selected="selected"{/if}>{$LANG.FIND} {$LANG.FIND_FEMALE}</option>
            <option value="m" {if $gender == 'm'}selected="selected"{/if}>{$LANG.FIND} {$LANG.FIND_MALE}</option>
            <option value="all" {if !$gender}selected="selected"{/if}>{$LANG.FIND} {$LANG.FIND_ALL}</option>
          </select></td>
	</tr>
	<tr>
        <td><input style="width:100px" name="agefrom" type="text" id="agefrom" placeholder="от, лет" value="{if $age_fr}{$age_fr}{/if}"/>
          - 
          <input style="width:100px" name="ageto" type="text" id="ageto" placeholder="{$LANG.TO}, лет" value="{if $age_to}{$age_to}{/if}"/></td>
      </tr>
      <tr>
        <td colspan="2"><input style="width:240px;" placeholder="{$LANG.NAME}" id="name" name="name" class="longfield" type="text" value="{$name|escape:'html'}"/></td>
      </tr>
      <tr>
        <td colspan="2">{city_input value=$city name="city" width="280px"}</td>
      </tr>
      <tr>
        <td colspan="2"><input style="width:240px;" placeholder="{$LANG.HOBBY}" id="hobby" class="longfield" name="hobby" type="text" value="{$hobby|escape:'html'}"/></td>
      </tr>
    </table>
</div>
<div style="padding:0 8px 8px 8px;">
	<div class="checkbox"><label for="online"><input id="online" name="online" type="checkbox" value="1" {if $only_online} checked="checked"{/if}> {$LANG.SHOW_ONLY_ONLINE}</label></div>
    <div>
      <input name="gosearch" type="submit" id="gosearch" value="{if $stext}{$LANG.SEARCH_IN_RESULTS}{else}{$LANG.SEARCH}{/if}" />
      {if $stext}
      	<a class="btn btn-default" href="/users/all.html">{$LANG.CANCEL_SEARCH_SHOWALL}</a>
      {/if}
      <input name="hide" type="button" id="hide" value="{$LANG.HIDE}" onclick="$('#users_sbar').slideToggle();"/>
    </div>
</div>
  </form>
</div>
{/if}

	{if $total}
      {foreach key=tid item=usr from=$users}
<div class="media {cycle values="rowa2,rowa1"}">
  <a class="pull-left"  href="{profile_url login=$usr.login}"><img class="media-object" alt="{$usr.nickname|escape:'html'}" src="{$usr.avatar}" /></a>
  <div class="media-body">
            {if $usr.is_online}
            	<span class="pull-right online">{$LANG.ONLINE}</span>
            {else}
            	<span class="pull-right offline">{$usr.flogdate}</span>
            {/if}
		<h4 class="media-heading">
		{$usr.user_link} 
		{if $link.selected=='rating'}
        <span title="{$LANG.RATING}">{$usr.rating|rating}</span>
          	{/if}
          	{if $link.selected=='positive'}
        <span title="{$LANG.KARMA}" class="media-hinttext" style="{if $usr.karma > 0}color:green;{/if}{if $usr.karma < 0}color:red;{/if}">{if $usr.karma > 0}+{/if}{$usr.karma}</span>
          	{/if} 
		</h4>
		{if $usr.microstatus}
		<div class="media-hinttext"><span class="glyphicon glyphicon-volume-up"></span> {$usr.microstatus}</div>
		{/if} 	
  </div>
</div>	  
      {/foreach}
    {else}
      <p class="text-danger">{$LANG.USERS_NOT_FOUND}.</p>
    {/if}
  {$pagebar}