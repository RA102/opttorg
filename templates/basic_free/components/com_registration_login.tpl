<h1 class="con_heading">Вход на сайт</h1>
<div class="body-page">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p id="error-auth" class="red-text" ></p>

            <div class="clearfix">
                {if $is_sess_back}
                    <p class="text-danger">{$LANG.PAGE_ACCESS_NOTICE}</p>
                {/if}
                <form id="login-form" method="post">
                    <input type="hidden" name="csrf_token" value="{csrf_token}"/>
                    <div class="input-group">
                        <span class="input-group-addon" title="{$LANG.LOGIN} {$LANG.OR} {$LANG.EMAIL}"><span
                                    class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="login" id="login_field" tabindex="1" class="form-control"
                               placeholder="{$LANG.LOGIN} {$LANG.OR} {$LANG.EMAIL}"/>
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon" title="{$LANG.PASS}">
                            <span class="glyphicon glyphicon-th"></span>
                        </span>
                        <input type="password" name="pass" id="pass_field" tabindex="2" class="form-control" placeholder="{$LANG.PASS}"/>
                    </div>
                    <div class="checkbox" style="margin-top:20px;">
{*                        <input type="submit" name="login_btn" class="btn btn-main btn-block" value="" tabindex="4"/>*}
                        <button id="submit-btn-login" class="btn btn-success">{$LANG.SITE_LOGIN_SUBMIT}</button>
                        <label for="remember" style="color: black;">
                            <input type="checkbox" name="remember" value="1" checked="checked" id="remember" tabindex="3"/> {$LANG.REMEMBER_ME}
                        </label>
                    </div>
                </form>
            </div>
            <div class="clearfix text-center small">
                <a href="/passremind.html" class="">{$LANG.FORGOT_PASS}</a>
            </div>
            <!--<div class="clearfix">{callEvent event='LOGINZA_BUTTON'}</div>-->
        </div>

    </div>
</div>

