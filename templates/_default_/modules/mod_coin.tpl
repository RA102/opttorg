
{*===========Страница модуля mod_coin ==============*}
{*===========сгенерирована автоматически ==============*}
{*=========генератор написал stroller7@gmail.com=======*}
{$LANG.HI}<br><br>
$info = {$info}<br>
{if $cfg.show}
{foreach key=key item=property from=$cfg}
{$key}=>{$property}<br>
{/foreach}
{$LANG.units}: {$cfg.shownum} {$cfg.units}
{/if}
	