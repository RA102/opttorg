<form name="templform" action="/modules/mod_template/set.php" method="post">
    <div class="input-group">
    <select name="template" id="template" class="form-control">
        <option value="0">{$LANG.TEMPLATE_DEFAULT}</option>
        {foreach key=id item=template from=$templates}
            <option value="{$template}" {if $template == $current_template}selected="selected"{/if}>{$template}</option>
        {/foreach}
    </select>
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">{$LANG.TEMPLATE_CHOOSE}</button>
      </span>	  
    </div>
</form>