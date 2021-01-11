{add_js file='includes/jquery/tabs/jquery.ui.min.js'}
{add_css file='includes/jquery/tabs/tabs.css'}
{literal}
<style>
.birthdate select {position:relative;width:32% !important;display:inline;}
</style>
{/literal}
<script type="text/javascript">
    $(function(){ $(".uitabs").tabs(); });
</script>
<div class="body-page">
<h1 class="con_heading">{$LANG.CONFIG_PROFILE}</h1>

<div id="profiletabs" class="uitabs">
    <ul id="tabs">
        <li><a href="#about"><span>{$LANG.ABOUT_ME}</span></a></li>
        <li><a href="#contacts"><span>{$LANG.CONTACTS}</span></a></li>
        <li><a href="#notices"><span>Реквизиты</span></a></li>
        <li rel="hid"><a href="#change_password"><span>{$LANG.CHANGING_PASS}</span></a></li>
    </ul>

    <form id="editform" name="editform" enctype="multipart/form-data" method="post" action="">
        <input type="hidden" name="opt" value="save" />
        <input type="hidden" name="csrf_token" value="{csrf_token}" />
        <div id="about">
		<div class="table-responsive1">
            <table class="table table-striped">
                <tr>
                    <td width="100" valign="top">
                        <strong>{$LANG.YOUR_NAME}: </strong>
                    </td>
                    <td valign="top"><input name="nickname" type="text" class="form-control" id="nickname" value="{$usr.nickname|escape:'html'}"/></td>
                </tr>
                <tr style="display:none;">
                    <td valign="top"><strong>{$LANG.SEX}:</strong></td>
                    <td valign="top">
                        <select name="gender" id="gender">
                            <option value="0" {if $usr.gender==0} selected {/if}>{$LANG.NOT_SPECIFIED}</option>
                            <option value="m" {if $usr.gender=='m'} selected {/if}>{$LANG.MALES}</option>
                            <option value="f" {if $usr.gender=='f'} selected {/if}>{$LANG.FEMALES}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <strong>{$LANG.CITY}:</strong>
                    </td>
                    <td valign="top">
                        {city_input value=$usr.city name="city"}
                    </td>
                </tr>
                <tr style="display:none;">
                    <td valign="top"><strong>{$LANG.BIRTH}:</strong> </td>
                    <td valign="top" class="birthdate">
                        {dateform seldate=$usr.birthdate}
                    </td>
                </tr>
                <tr style="display:none;">
                    <td valign="top">
                        <strong>{$LANG.HOBBY} ({$LANG.TAGSS}): </strong>
                    </td>
                    <td valign="top">
                        <textarea name="description" class="form-control" rows="2" id="description">{$usr.description}</textarea>
                    </td>
                </tr>
                {if $cfg_forum.component_enabled}
                <tr style="display:none;">
                    <td valign="top">
                        <strong>{$LANG.SIGNED_FORUM}:</strong>
                    </td>
                    <td valign="top">
                        <textarea name="signature" class="form-control" rows="2" id="signature">{$usr.signature|escape:'html'}</textarea>
                    </td>
                </tr>
                {/if}
                {if $private_forms}
                    {foreach key=tid item=field from=$private_forms}
                    <tr style="display:none;">
                        <td valign="top">
                            <strong>{$field.title}:</strong>
                        </td>
                        <td valign="top">
                            {$field.field}
                        </td>
                    </tr>
                    {/foreach}
                {/if}
            </table>
		</div>
        </div>

        <div id="contacts">
		<div class="table-responsive1">
            <table class="table table-striped">
                <tr>
                    <td width="100" valign="top">
                        <strong>E-mail:</strong>
                    </td>
                    <td valign="top">
                        <input name="email" type="text" class="form-control" id="email" value="{$usr.email}"/>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Адрес доставки:</strong></td>
                    <td valign="top"><input name="icq" class="form-control" type="text" id="icq" value="{$usr.icq|escape:'html'}"/></td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.PHONE} :</strong><br /><span class="hint">{$LANG.PHONE_HINT}</span></td>
                    <td valign="top"><input name="phone" class="form-control" type="text" id="phone" value="{$usr.phone}"/></td>
                </tr>
            </table>
		</div>
        </div>

        <div id="notices">
		<div class="table-responsive1">
		
            <table class="table table-striped" style="display:none;">
                <tr>
                    <td width="100" valign="top">
                        <strong>
                            {$LANG.NOTIFY_NEW_MESS}:
                        </strong>
                    </td>
                    <td valign="top">
                        <label><input name="email_newmsg" type="radio" value="1" {if $usr.email_newmsg}checked{/if}/> {$LANG.YES} </label>
                        <label><input name="email_newmsg" type="radio" value="0" {if !$usr.email_newmsg}checked{/if}/> {$LANG.NO}</label>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <strong>{$LANG.HOW_NOTIFY_NEW_MESS} </strong>
                    </td>
                    <td valign="top">
                        <select name="cm_subscribe" id="cm_subscribe">
                            <option value="mail" {if $usr.cm_subscribe=='mail'}selected{/if}>{$LANG.TO_EMAIL}</option>
                            <option value="priv" {if $usr.cm_subscribe=='priv'}selected{/if}>{$LANG.TO_PRIVATE_MESS}</option>
                            <option value="both" {if $usr.cm_subscribe=='both'}selected{/if}>{$LANG.TO_EMAIL_PRIVATE_MESS}</option>
                            <option value="none" {if $usr.cm_subscribe=='none'}selected{/if}>{$LANG.NOT_SEND}</option>
                        </select>
                    </td>
                </tr>
            </table>
		
            <table class="table table-striped">
			
                <tr>
                    <td valign="top"><strong>Название организации:</strong></td>
                    <td valign="top"><input name="org_name" class="form-control" type="text" id="org_name" value="{$usr.org_name|escape:'html'}"/></td>
                </tr>			
                <tr>
                    <td width="100" valign="top">
                        <strong>БИН / ИИН:</strong>
                    </td>
                    <td valign="top">
                        <input name="bin_iin" type="text" class="form-control" id="bin_iin" value="{$usr.bin_iin|escape:'html'}"/>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Адрес организации:</strong></td>
                    <td valign="top"><input name="org_adr" class="form-control" type="text" id="org_adr" value="{$usr.org_adr|escape:'html'}"/></td>
                </tr>

            </table>		
		</div>
        </div>

        <div id="policy" style="display:none;">
		<div class="table-responsive1">
            <table class="table table-striped">
                <tr>
                    <td width="100" valign="top">
                        <strong>{$LANG.SHOW_EMAIL}:</strong>
                    </td>
                    <td valign="top">
                        <label><input name="showmail" type="radio" value="1" {if $usr.showmail}checked{/if}/> {$LANG.YES} </label>
                        <label><input name="showmail" type="radio" value="0" {if !$usr.showmail}checked{/if}/> {$LANG.NO} </label>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.SHOW_ICQ}:</strong></td>
                    <td valign="top">
                        <label><input name="showicq" type="radio" value="1" {if $usr.showicq}checked{/if}/> {$LANG.YES} </label>
                        <label><input name="showicq" type="radio" value="0" {if !$usr.showicq}checked{/if}/> {$LANG.NO} </label>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.SHOW_PHONE}:</strong></td>
                    <td valign="top">
                        <label><input name="showphone" type="radio" value="1" {if $usr.showphone}checked{/if}/> {$LANG.YES} </label>
                        <label><input name="showphone" type="radio" value="0" {if !$usr.showphone}checked{/if}/> {$LANG.NO} </label>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.SHOW_BIRTH}:</strong> </td>
                    <td valign="top">
                        <label><input name="showbirth" type="radio" value="1" {if $usr.showbirth}checked{/if}/> {$LANG.YES} </label>
                        <label><input name="showbirth" type="radio" value="0" {if !$usr.showbirth}checked{/if}/> {$LANG.NO} </label>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <strong>{$LANG.SHOW_PROFILE}:</strong>
                    </td>
                    <td valign="top">
                        <select name="allow_who" id="allow_who">
                            <option value="all" {if $usr.allow_who=='all'}selected{/if}>{$LANG.EVERYBODY}</option>
                            <option value="registered" {if $usr.allow_who=='registered'}selected{/if}>{$LANG.REGISTERED}</option>
                            <option value="friends" {if $usr.allow_who=='friends'}selected{/if}>{$LANG.MY_FRIENDS}</option>
                        </select>
                    </td>
                </tr>
            </table>
		</div>
        </div>
        <div style="margin-top: 12px;" id="submitform">
            <input name="save" type="submit" id="save" value="{$LANG.SAVE}" />
            <input name="delbtn2" type="button" id="delbtn2" value="{$LANG.DEL_PROFILE}" onclick="location.href='/users/{$usr.id}/delprofile.html';" />
        </div>
    </form>
    <div id="change_password">
        <form id="editform" name="editform" method="post" action="">
            <input type="hidden" name="opt" value="changepass" />
		<div class="table-responsive1">
            <table class="table table-striped">
                <tr>
                    <td width="100" valign="top">
                        <strong>{$LANG.OLD_PASS}</strong>
                    </td>
                    <td valign="top">
                        <input name="oldpass" type="password" id="oldpass" class="form-control" size="30" />
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.NEW_PASS}</strong></td>
                    <td valign="top"><input name="newpass" type="password" id="newpass" class="form-control" size="30" /></td>
                </tr>
                <tr>
                    <td valign="top"><strong>{$LANG.NEW_PASS_REPEAT}</strong></td>
                    <td valign="top"><input name="newpass2" type="password" class="form-control" id="newpass2" size="30" /></td>
                </tr>
            </table>
		</div>
            <div style="margin-top: 12px;">
                <input name="save2" type="submit" id="save2" value="{$LANG.CHANGE_PASSWORD}" />
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function(){
        $( '#tabs li' ).click( function(){
            rel = $( this ).attr( "rel" );
            if(!rel){
                $('#submitform').show();
            } else {
                $('#submitform').hide();
            }
        });
    });
</script>