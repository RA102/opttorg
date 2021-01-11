{if $target_id != 54}
    <div class="panel panel-default" id="cmms">
        <div class="panel-body">
            <div class="cm_ajax_list">
                {if !$cfg.cmm_ajax}
                    {$html}
                {/if}
            </div>
        </div>
        <div class="panel-footer">
            <a name="c"></a>
            <span class="cmm_links">
				<span id="cm_add_link0" class="cm_add_link add_comment">
					<a href="javascript:void(0);" onclick="{$add_comment_js}" class="btn btn-main">Добавить отзыв</a>
				</span>
			</span>
            <div id="cm_addentry0"></div>
            <script type="text/javascript">
                var target_author_can_delete = {$target_author_can_delete};
                {if $cfg.cmm_ajax}
                var anc = '';
                if (window.location.hash) {
                    anc = window.location.hash;
                }
                $(function () {
                    loadComments('{$target}', {$target_id}, anc);
                });
                {/if}
            </script>
        </div>
    </div>

{/if}

