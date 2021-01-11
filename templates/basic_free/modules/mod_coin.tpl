{if $coin > 0}
<a href="#" data-toggle="modal" data-target="#coin{$secretid}" class="coin" style="top:{$top}%;left:{$left}%;" title="Жми, чтобы получить скидку {$coin}%"><img src="/modules/mod_coin/coin{$coin}.svg" alt="Жми, чтобы получить скидку {$coin}%" /></a>
<div class="modal fade" id="coin{$secretid}" tabindex="-1" role="dialog" aria-labelledby="coinLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content text-center">
		{if $userid==0}<form action="/registration" method="POST">{else}<form action="" method="POST">{/if}
      <div class="modal-body">
        <img src="/modules/mod_coin/coin{$coin}.svg" alt="Вы поймали монетку {$coin}%" width="120" height="120" style="margin-top:15px;margin-bottom:15px;" />
		<p class="lead">{$cfg.info}</p>
		<div class="row no-gutters">
			<div class="col-xs-6">
				<button type="button" class="btn btn-block btn-danger" data-dismiss="modal">Нет, спасибо</button>
			</div>
			<div class="col-xs-6">
				{if $userid==0}
				<input type="hidden" name="secretid" value="{$secretid}" />
				<input type="hidden" name="coin" value="{$coin}" />
				<input type="hidden" name="userid" value="0" />					
				<button type="submit" class="btn btn-block btn-success">Я согласен!</button>				
				{else}
				<input type="hidden" name="secretid" value="{$secretid}" />
				<input type="hidden" name="coin" value="{$coin}" />
				<input type="hidden" name="userid" value="{$userid}" />				
				<button type="submit" class="btn btn-block btn-success">Я согласен!</button>
				{/if}
			</div>
		</div>		
      </div>
	  </form>
    </div>
  </div>
</div>
{/if}	