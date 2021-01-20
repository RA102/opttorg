<?php
if(!defined('VALID_CMS_ADMIN')) {
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_LANG['AD_ADMIN_PANEL']; ?></title>
    <script type="text/javascript" src="/includes/jquery/jquery.js"></script>
</head>
<style>
html, body{
    margin:0; padding:0;
    font-family: 'Trebuchet MS', sans-serif;
    font-size: 100%;
    height:100%;
    background: #F5F5F5;
}
#body {
    background: #385C89;
    bottom: 0;
    height: 270px;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 300px;
    padding:0 25px
}
h2 {
    font-size: 24px;
    color: #FFF;
    font-weight: normal;
    margin: 20px 0;
}
form {
    overflow: hidden;
}
input {
    line-height: normal;
    font-family: inherit;
    font-size: 100%;
    margin: 0;
    text-align: left;
    border: 0;
    outline: none;
    display: block;
    width: 100%;
    padding: 8px 0 8px 30px;
    margin-bottom: 15px;
}
input[type="submit"] {
    background: #4A79A9;
    color: #FFF;
    cursor: pointer;
    float: right;
    text-align: left;
    width: 110px;
}
input[type="submit"]:hover{
    background: #1F3147;
}
#login {
    background: url("images/auth/login.png") no-repeat scroll -6px -2px #FFF;
}
#pass {
    background: url("images/auth/pass.png") no-repeat scroll -6px -2px #FFF;
}
#copy, #copy a {
    color: #CCC;
    text-decoration: none;
}
#copy a:hover {
    text-decoration: underline;
}
</style>
<body>
    <div id="body">
        <form id="admLgnForm" method="post" >
            <input type="hidden" name="csrf_token" value="<?php echo cmsUser::getCsrfToken(); ?>" />
            <input type="hidden" name="is_admin" value="1" />
            <h2><?php echo $_LANG['AD_AUTH']; ?></h2>
            <input required="true" autofocus="true" tabindex="1" name="login" type="text" id="login" placeholder="<?php echo $_LANG['AD_AUTH_LOGIN']; ?>" />
            <input required="true" tabindex="2" name="pass" type="password" id="pass" placeholder="<?php echo $_LANG['AD_AUTH_PASS']; ?>" />
            <button id="admin-login"><?php echo $_LANG['AD_DO_AUTH']; ?></button>
        </form>
        <p id="error-auth" class="red-text"></p>
        <div id="copy">&copy; <a href="http://www.instantcms.ru/">InstantCMS</a>, 2007—<?php echo date('Y'); ?></div>
    </div>
</body>

<script>
    $('#admLgnForm').submit( function(event) {
        event.preventDefault();
        $.ajax({
            url: '/login',
            type: 'POST',
            data: $('#admLgnForm').serialize(),
            success: function(data) {
                if (data.error != '') {
                    $('#error-auth').text(data.error);
                } else {
                    console.log(data);
                    window.location.href = data.data;
                }
            }
        })
    })
</script>