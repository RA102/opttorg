{if $target_id != 54}
    <h3 style="margin:0 0 20px 0;">Отзывы к товару</h3>
    {if $comments_count}

        {foreach key=cid item=comment from=$comments}
            {$next=$cid+1}
            <div class="cmm-tree">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="cmm-hd">{if $comment.is_profile}<img width="28" height="28"
                                                                         src="{$comment.user_image}" />{else}
                                <img width="28" height="28" src="/images/users/avatars/small/nopic.jpg"/>
                            {/if}  {if !$comment.is_profile}{$comment.author}{else}{$comment.author.nickname}{/if}
                            , {$comment.fpubdate}</div>
                        <div class="cmm-bd">{$comment.content}</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="cmm-rat">Товар:
                            <div class="pull-right">{section name=foo1 start=1 loop=6 step=1}<span
                                    class="glyphicon glyphicon-star"{if $comment.rating1 < $smarty.section.foo1.index} style="color:lightgray"{/if}></span>{/section}
                            </div>
                        </div>
                        <div class="cmm-rat">Обслуживание:
                            <div class="pull-right">{section name=foo2 start=1 loop=6 step=1}<span
                                    class="glyphicon glyphicon-star"{if $comment.rating2 < $smarty.section.foo2.index} style="color:lightgray"{/if}></span>{/section}
                            </div>
                        </div>
                        <div class="cmm-rat">Доставка:
                            <div class="pull-right">{section name=foo3 start=1 loop=6 step=1}<span
                                    class="glyphicon glyphicon-star"{if $comment.rating3 < $smarty.section.foo3.index} style="color:lightgray"{/if}></span>{/section}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}

    {else}
        <p>Нет отзывов. Ваш будет первым!</p>
    {/if}
{/if}