{if $myprofile}
<div class="float_bar">
    <a href="/users/addfile.html" class="btn btn-primary">{$LANG.UPLOAD_FILE_IN_ARCHIVE}</a>
</div>
{/if}

<h1 class="con_heading"><a href="{profile_url login=$usr.login}">{$usr.nickname}</a> &rarr; {$LANG.FILES}</h1>
{if $files}
<div class="usr_files_orderbar" style="display:inline-block;width:100%;margin-bottom:10px !important;">
      {if $total_files > 1}
        <div class="pull-right">
            <form name="orderform" method="post" action="" style="margin:0px">
                <input type="button" class="usr_files_orderbtn" onclick="orderPage('pubdate')" name="order_date" value="{$LANG.ORDER_BY_DATE}" {if $orderby=='pubdate'} disabled {/if} />
                <input type="button" class="usr_files_orderbtn" onclick="orderPage('filename')" name="order_title" value="{$LANG.ORDER_BY_NAME}" {if $orderby=='filename'} disabled {/if} />
                <input type="button" class="usr_files_orderbtn" onclick="orderPage('filesize')" name="order_size" value="{$LANG.ORDER_BY_SIZE}" {if $orderby=='filesize'} disabled {/if} />
                <input type="button" class="usr_files_orderbtn" onclick="orderPage('hits')" name="order_hits" value="{$LANG.ORDER_BY_DOWNLOAD}" {if $orderby=='hits'} disabled {/if} />
                <input id="orderby" type="hidden" name="orderby" value="{$orderby}"/>
            </form>
        </div>
      {/if}
  <h6 class="pull-left"><strong>{$LANG.FILE_COUNT}: </strong>{$total_files}{if $myprofile}{if $cfg.filessize}, {$LANG.FREE}: {$free_mb} {$LANG.MBITE}{/if}{/if}</h6>
</div>
<form name="listform" id="listform" action="" method="post">
<div class="files-table">
  <table cellspacing="0" cellpadding="5">
    <tr style="background:#f5f5f5;">
      {if $myprofile}
        <td class="usr_files_head" width="30" align="center"><span title="{$LANG.VISIBILITY}" style="font-size:12px !important;" class="glyphicon glyphicon-eye-open"></div></td>
      {/if}	
      <td class="usr_files_head" width="20" align="center">#</td>
      <td class="usr_files_head" width="" colspan="2">{$LANG.FILE_NAME} {if $orderby=='filename'} &darr; {/if}</td>
      <td class="usr_files_head" width="">{$LANG.SIZE} {if $orderby=='filesize'}&darr;{/if}</td>
      <td class="usr_files_head" width="">{$LANG.CREATE_DATE} {if $orderby=='pubdate'}&darr;{/if}</td>
      <td class="usr_files_head" width="40" align="center"><span class="glyphicon glyphicon-download-alt" style="font-size:12px !important;" title="{$LANG.DOWNLOAD_HITS}"></span>{if $orderby=='hits'}&darr;{/if}</td>
      </tr>

    {foreach key=tid item=file from=$files}
        <tr style="border-bottom:solid 1px #dedede !important;">
          {if $myprofile}
          	{if $file.allow_who == 'all'}
          <td align="center" valign="top"><span class="glyphicon glyphicon-eye-open" style="color:green;" title="{$LANG.FILE_VIS_ALL}"></span></td>
          	{else}
          <td align="center" valign="top"><span class="glyphicon glyphicon-eye-close" style="color:red;" title="{$LANG.FILE_HIDEN}"></span></td>
            {/if}
          {/if}		
        {if $myprofile || $is_admin}
          <td align="center" valign="top"><input id="fileid{$file.rownum}" type="checkbox" name="files[]" value="{$file.id}"/></td>
        {else}
          <td align="center" valign="top">{$file.rownum}</td>
        {/if}
          <td width="16" valign="top">{$file.fileicon}</td>
          <td valign="top"><a href="{$file.filelink}">{$file.filename}</a>
            <div class="usr_files_link">{$file.filelink}</div></td>
          <td>{$file.mb} {$LANG.MBITE}</td>
          <td>{$file.pubdate|date_format:"%d/%m/%Y"}</td>
          <td align="center">{$file.hits}</td>
          </tr>
    {/foreach}
  </table>
</div>
  {if $myprofile || $is_admin}
    <div style="margin-top:6px; float:right;">
      <input type="button" class="usr_files_orderbtn" name="delete_btn" id="delete_btn" onclick="delFiles('{$LANG.YOU_REALLY_DEL_FILES}?')" value="{$LANG.DELETE}"/>
      <input type="button" class="usr_files_orderbtn" name="hide_btn" id="delete_btn" onclick="pubFiles(0)" value="{$LANG.HIDE}"/>
      <input type="button" class="usr_files_orderbtn" name="show_btn" id="delete_btn" onclick="pubFiles(1)" value="{$LANG.SHOW}"/>
    </div>
  {/if}
  {$pagination}
</form>
{else}
	<p>{$LANG.USER_NO_UPLOAD}</p>
{/if}