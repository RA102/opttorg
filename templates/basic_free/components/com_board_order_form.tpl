<div class="well no-padding-bottom">
<form action="{$action_url}" method="POST" id="obform">
	<div class="row margin-bottom-row">
		<div class="col-sm-6">
					<select name="obtype" id="obtype" onchange="$('form#obform').submit();" style="width:100%;">
						<option value="all" {if (empty($btype))} selected {/if}>{$LANG.ALL_TYPE}</option>
						{$btypes}
					</select>		
		</div>
		<div class="col-sm-6">
			{$bcities}
		</div>
		<div class="col-sm-4">
					<select name="orderby" id="orderby" style="width:100%;">
						<option value="title" {if $orderby=='title'} selected {/if}>{$LANG.ORDERBY_TITLE}</option>
						<option value="pubdate" {if $orderby=='pubdate'} selected {/if}>{$LANG.ORDERBY_DATE}</option>
						<option value="hits" {if $orderby=='hits'} selected {/if}>{$LANG.ORDERBY_HITS}</option>
						<option value="obtype" {if $orderby=='obtype'} selected {/if}>{$LANG.ORDERBY_TYPE}</option>
						<option value="user_id" {if $orderby=='user_id'} selected {/if}>{$LANG.ORDERBY_AVTOR}</option>
					</select>		
		</div>
		<div class="col-sm-4">
					<select name="orderto" id="orderto" style="width:100%;">
						<option value="desc" {if $orderto=='desc'} selected {/if}>{$LANG.ORDERBY_DESC}</option>
						<option value="asc" {if $orderto=='asc'} selected {/if}>{$LANG.ORDERBY_ASC}</option>
					</select>		
		</div>
		<div class="col-sm-4">
			<input type="submit" value="{$LANG.FILTER}" style="width:100%;" />
		</div>		
	</div>
</form>
</div>