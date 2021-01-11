<h1 class="con_heading" id="nickname"><span>Личный кабинет: {$usr.nickname}</span></h1>
<div class="body-page">				
<div class="row">
	<div class="col-md-3 col-sm-4">
        <div class="text-center">
			<img alt="{$usr.nickname|escape:'html'}" src="{$usr.avatar}" style="position:relative;width:100%;height:auto;max-width:300px;margin:0 auto !important;" />
						<div class="btn-groupp">
							{if $is_auth}	


                         	{if $myprofile}
                            <a class="btn btn-user btn-block" href="/users/{$usr.id}/avatar.html" title="{$LANG.SET_AVATAR}"><span class="glyphicon glyphicon-picture"></span> {$LANG.SET_AVATAR}</a>
                            <a class="btn btn-user btn-block" href="/users/{$usr.id}/editprofile.html" title="{$LANG.CONFIG_PROFILE}"><span class="glyphicon glyphicon-cog"></span> {$LANG.MY_CONFIG}</a>
                            {/if}
                            {if $is_admin && !$myprofile}
                            <a class="btn btn-user btn-block" href="/users/{$usr.id}/editprofile.html" title="{$LANG.CONFIG_PROFILE}"><span class="glyphicon glyphicon-cog"></span> {$LANG.CONFIG_PROFILE}</a>
                            {/if}
							{if !$myprofile}
                            	{if $is_admin}
                                	{if !$usr.banned}
                            <a class="btn btn-user btn-block" href="/users/{$usr.id}/giveaward.html" title="{$LANG.TO_AWARD}"><span class="glyphicon glyphicon-gift"></span> {$LANG.TO_AWARD}</a>
                                    {if $usr.id != 1}
                            <a class="btn btn-user btn-block" href="/admin/index.php?view=userbanlist&do=add&to={$usr.id}" title="{$LANG.TO_BANN}"><span class="glyphicon glyphicon-ban-circle"></span> {$LANG.TO_BANN}</a>
                                    {/if}
                                    {/if}
                                {if $usr.id != 1}
                            <a class="btn btn-user btn-block" href="/users/{$usr.id}/delprofile.html" title="{$LANG.DEL_PROFILE}"><span class="glyphicon glyphicon-remove-circle"></span> {$LANG.DEL_PROFILE}</a>
                                {/if}
                                {/if}
                         	{/if}
							{/if}
                        </div>
		</div>		
	</div>
	<div class="col-md-9 col-sm-8">
		<div id="profiletabs" class="uitabs">
				<div id="upr_profile">
					<div class="item-description">
					<ul class="list-unstyled list-profile">
					
						<li><strong>Статус:</strong> {$usr.grp}</li>
					
						<li>
							<strong>{$LANG.LAST_VISIT}:</strong>
							{$usr.flogdate}
						</li>
						<li>
							<strong>{$LANG.DATE_REGISTRATION}:</strong>
							
                                {$usr.fregdate}
                            
						</li>
                        {if $usr.inv_login}
                            <li>
                                <strong>{$LANG.INVITED_BY}:</strong>
                                
                                    <a href="{profile_url login=$usr.inv_login}">{$usr.inv_nickname}</a>
                                
                            </li>
                        {/if}
                        {if $usr.city}
						<li>
							<strong>{$LANG.CITY}:</strong>
                            <a href="/users/city/{$usr.cityurl|escape:'html'}">{$usr.city}</a>{if $usr.country}, {$usr.country}{/if}
						</li>
                        {/if}



						{if $usr.icq}
						<li>
							<strong>Адрес:</strong>
							{$usr.icq}
						</li>
						{/if}

						{if $usr.phone}
						<li>
							<strong>{$LANG.PHONE}:</strong>
							+{$usr.phone}
						</li>
						{/if}

						
							{add_js file='includes/jquery/jquery.nospam.js'}
							<li>
								<strong>E-mail:</strong>
								<a href="#" rel="{$usr.email|NoSpam}" class="email">{$usr.email}</a>
							</li>
                            <script>
                                    $('.email').nospam({ replaceText: true });
                            </script>
						
						<li><strong>Организация:</strong> {$usr.org_name}</li>
						
						<li><strong>Юр. адрес:</strong> {$usr.org_adr}</li>
						
						<li><strong>БИН / ИИН:</strong> {$usr.bin_iin}</li>

					</ul>
					</div>
				</div>
                {foreach key=id item=plugin from=$plugins}
                <div id="upr_{$plugin.name}">{$plugin.html}</div>
                {/foreach}
		</div>
	</div>
</div>
</div>