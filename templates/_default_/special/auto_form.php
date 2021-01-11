<?php

    global $tpl_data;
    extract($tpl_data);

?>

<div class="params-form">
    <table cellpadding="3" cellspacing="0" border="0">
        <?php foreach($fields as $fid=>$field){ ?>
        <tr id="f<?php echo $fid; ?>">
            <td class="param-name">
                <div class="label"><strong><?php echo $field['title']; ?></strong></div>
                <?php if ($field['hint']) { ?>
                    <div class="hinttext"><?php echo $field['hint']; ?></div>
                <?php } ?>
                    
                <?php if ($field['type']=='list_db' && $field['multiple']) { ?>
                    <div class="param-links">
                        <a href="javascript:" onclick="$('tr#f<?php echo $fid; ?> td input[type=checkbox]').attr('checked', 'checked')">Выделить все</a> |
                        <a href="javascript:" onclick="$('tr#f<?php echo $fid; ?> td input[type=checkbox]').attr('checked', '')">Снять все</a>
                    </div>
                <?php } ?>
            </td>
            <td class="param-value">
                <?php echo $field['html']; ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

