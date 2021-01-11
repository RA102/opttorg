<form id="mod_usr_search_form" method="post" action="/users">
<div class="table-responsive">
    <table class="table">
        <tr>
            <td valign="middle">
                <select name="gender" id="gender" style="width:100%" class="text-input">
                    <option value="f">{$LANG.FIND} {$LANG.FIND_FEMALE}</option>
                    <option value="m">{$LANG.FIND} {$LANG.FIND_MALE}</option>
                    <option value="0" selected>{$LANG.FIND} {$LANG.FIND_ALL}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input style="width:45% !important;float:left;" name="agefrom" type="text" id="agefrom" value="" placeholder="{$LANG.AGE_FROM}" class="text-input" />
                <input style="width:45% !important;float:right;" name="ageto" type="text" id="ageto" value="" placeholder="{$LANG.TO}" class="text-input" />
            </td>
        </tr>
        <tr>
            <td>
                <input style="width:100%" id="name" name="name" type="text" value="" placeholder="{$LANG.NAME}" class="text-input" />
            </td>
        </tr>
        <tr>
            <td>
                {city_input name="city" width="100%" input_width="120px" placeholder=$LANG.CITY}
            </td>
        </tr>
        <tr>
            <td>
                <input style="width:100%" id="hobby" name="hobby" type="text" value="" placeholder="{$LANG.HOBBY}" class="text-input" />
            </td>
        </tr>
        <tr>
            <td align="center">
                <input name="gosearch" type="submit" id="gosearch" class="kopa-button navy-button small-button" value="{$LANG.SEARCH}" />
            </td>
        </tr>
    </table>
</div>
</form>