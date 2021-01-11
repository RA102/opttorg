<table class="table table-hover">
    <thead>
    <tr>
        <th>№ п/п</th>
        <th>Обновлено записей</th>
        <th>Добавлено новых записей</th>
        <th>Не загружено</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td>{$update}</td>
        <td>{$insert}</td>
        {foreach from=$unloaded  item=item}
        <td>{$item}</td>
        {/foreach}
    </tr>

    </tbody>
</table>