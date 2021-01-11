<div class="cat_form">
{foreach key=tid item=form from=$formsdata}
    <h5>{$form.title}:{if $form.mustbe} <span class="regstar" title="{$LANG.THIS_REQUIRED_FIELD}">*</span>{/if}</h5>
    <div class="input_val">
        <div class="input_val_value">
            {$form.field}
        </div>
    </div>
{/foreach}
</div>