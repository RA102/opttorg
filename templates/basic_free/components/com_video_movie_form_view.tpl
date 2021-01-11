{foreach key=tid item=form from=$formsdata}
    {if $form.field}
        <li class="list-group-item"><strong>{$form.title}:</strong> <span>{$form.field}</span></li> 
    {/if}
{/foreach}