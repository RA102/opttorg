{literal}
    <style type="text/css">
        .birthdate select {
            position: relative;
            width: 32% !important;
            display: inline;
        }

        .regstar {
            color: red;
            margin-left: 5px;
        }

        .captho input {
            width: 100px !important;
        }

        .captcha {
            margin-right: 10px;
        }
        .body-page {
            color: #000000;
        }
    </style>
{/literal}
<div class="body-page">
    <div class="row">
        <div class="col-md-12">

            <h3>Новый пользователь</h3>
            {if $cfg.is_on}

                {if $cfg.reg_type == 'invite' && !$correct_invite}

                    <p style="margin-bottom:15px; font-size: 14px">{$LANG.INVITES_ONLY}</p>

                    <form id="regform" name="regform" method="post" action="/registration">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <strong>{$LANG.INVITE_CODE}:</strong>
                                    </td>
                                    <td style="padding-left:15px">
                                        <input type="text" name="invite_code" class="form-control" value="" style=""/>
                                    </td>
                                    <td style="padding-left:5px">
                                        <input type="submit" name="show_invite" value="{$LANG.SHOW_INVITE}"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>

                {else}

{*                    {add_js file='components/registration/js/check.js'}*}
    {literal}
        <script>
            function checkLogin() {
                userlogin = $("#logininput").val();
                $("#logincheck").load("/core/ajax/registration.php", {opt: "checklogin", data: userlogin});
            }

            function checkPasswords() {
                var pass1 = $("#pass1input").val();
                var pass2 = $("#pass2input").val();
                if (pass1 != pass2) {
                    $('#passcheck').html('<span style="color:red">' + 'Пароли не совпадают' + '</span>');
                }
            }
        </script>
    {/literal}

                    <form id="regform" name="regform" method="post" action="/registration/add">
                        <input type="hidden" name="csrf_token" value="{csrf_token}"/>
                        {if $coin > 0}
                            <input type="hidden" name="coin" value="{$coin}"/>
                            <input type="hidden" name="secretid" value="{$secretid}"/>
                        {/if}
                        <div>
                            <strong>{$LANG.LOGIN}:</strong><span class="regstar">*</span>
                        </div>
                        <div>
                            <small>{$LANG.USED_FOR_AUTH} ({$LANG.ONLY_LAT_SYMBOLS})</small>
                        </div>
                        <input name="login" id="logininput" class="form-control" type="text" style=""
                               value="{$item.login|escape:'html'}" onchange="checkLogin()" autocomplete="off"
                               placeholder="{$LANG.ONLY_LAT_SYMBOLS}"/>
                        <div id="logincheck"></div>
                        <br/>
                        {if $cfg.name_mode == 'nickname'}
                            <div><strong>{$LANG.NICKNAME}:</strong><span class="regstar">*</span></div>
                            <small>{$LANG.NICKNAME_TEXT}</small>
                            <input name="nickname" id="nickinput" class="form-control" type="text" style=""
                                   value="{$item.nickname|escape:'html'}"/>
                        {else}
                            <div>
                                <strong>{$LANG.NAME}:</strong><span class="regstar">*</span>
                            </div>
                            <input name="realname1" id="realname1" class="form-control" type="text" style="" value="{$item.realname1|escape:'html'}"/>
                            <div>
                                <strong>{$LANG.SURNAME}:</strong><span class="regstar">*</span>
                            </div>
                            <input name="realname2" id="realname2" class="form-control" type="text" style="" value="{$item.realname2|escape:'html'}"/>
                        {/if}
                        <br/>
                        <strong>{$LANG.PASS}:</strong><span class="regstar">*</span>
                        <input name="pass" id="pass1input" class="form-control" type="password" style="" onchange="$('#passcheck').html('');"/>
                        <strong>{$LANG.REPEAT_PASS}: </strong><span class="regstar">*</span>
                        <input name="pass2" id="pass2input" class="form-control" type="password" style="" onchange="checkPasswords()"/>
                        <div id="passcheck"></div>
                        <br/>
                        <div>
                            <strong>{$LANG.EMAIL}:</strong><span class="regstar">*</span>
                        </div>
                        <div>
                            <small>{$LANG.NOPUBLISH_TEXT}</small>
                        </div>

                        <input name="email" type="text" class="form-control" style="" value="{$item.email}" placeholder="{$LANG.NOPUBLISH_TEXT}"/>
                        <tr>
                            {if $private_forms}
                                {foreach key=tid item=field from=$private_forms}

                                        <td valign="top">
                                            <div><strong>{$field.title}:</strong><span class="regstar">*</span></div>
                                            {if $field.description}
                                                <div><small>{$field.description}</small></div>
                                            {/if}
                                        </td>
                                        <td valign="top">
                                            {$field.field}
                                        </td>

                                {/foreach}
                            {/if}
                        </tr>
                        {if $cfg.ask_city}
                            <tr>
                                <td valign="top" class=""><strong>{$LANG.CITY}:</strong></td>
                                <td valign="top" class="">
{*                                    {city_input value=$item.city name="city" width="300px"}*}
                                    <input name="city" type="text" class="form-control" />
                                </td>
                            </tr>
                        {/if}
                        {if $cfg.ask_icq}
                            <tr>
                                <td valign="top" class=""><strong>ICQ:</strong></td>
                                <td valign="top" class="">
                                    <input name="icq" type="text" class="form-control" id="icq"
                                           value="{$item.icq|escape:'html'}" style=""/>
                                </td>
                            </tr>
                        {/if}
                        {if $cfg.ask_birthdate}
                            <tr>
                                <td valign="top" class="">
                                    <div><strong>{$LANG.BIRTH}:</strong></div>
                                    <div><small>{$LANG.NOPUBLISH_TEXT}</small></div>
                                </td>
                                <td valign="top" class="birthdate">{dateform seldate=$item.birthdate}</td>
                            </tr>
                        {/if}

                        <br/>
                        <div class="clearfix" style="margin-top:30px;">
                            <input name="do" type="hidden" value="register"/>
                            <input name="save" type="submit" class="btn-main btn" id="save" value="Зарегистрироваться"/>
                        </div>
                    </form>

                {/if}

            {else}

                <div class="text-danger">{$cfg.offmsg}</div>

            {/if}
        </div>
    </div>
</div>

{literal}
    <script>
    $('#regform').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: '/registration/add',
            type: 'POST',
            data: $('#regform').serialize(),
            success: function(data) {
                console.log(data);
                $('#modalAuth').modal('hide');
                window.location.href = data.data;
            }
        })

    })
    </script>
{/literal}