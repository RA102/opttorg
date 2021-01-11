{if $cfg.type == 'hor'}
{$col="1"}
        {foreach key=tid item=cat from=$cats_mod name=vcatmod} 
{if $col==1}<div class="row margin-bottom-row cats-list">{/if}
				<div class="col-md-4">	
<div class="media">
	<a class="pull-left" href="{$cat.cat_link}"><img src="/images/photos/small/{$cat.icon}" class="media-object" /></a>
  <div class="media-body">
    <h4 class="media-heading">{if $cfg.show_cat_count} <span class="badge pull-right">{$cat.movie_count}</span>{/if}<a href="{$cat.cat_link}">{$cat.title}</a></h4>
                {if $cfg.show_subcats && $cat.subcats}
    <div class="media-hinttext">
                        {foreach key=num item=subcat from=$cat.subcats}
        <a href="{$subcat.cat_link}">{$subcat.title}</a>{if $num<sizeof($cat.subcats)-1}, {/if}
                        {/foreach}
    </div>
                {/if}
  </div>
</div>  				
				</div>
{if $col==3 || $smarty.foreach.vcatmod.last}</div>{$col="1"}{else}{$col=$col+1}{/if}		

        {/foreach}
{else}
 <ul class="nav nav-tree" id="myTree" data-toggle="nav-tree"> 
    {assign var="last_level" value=1}
    {foreach key=tid item=cat from=$cats_mod}

        {if $cat.NSLevel == $last_level}</li>{/if}
        {math equation="x - y" x=$last_level y=$cat.NSLevel assign="tail"}
        {section name=foo start=0 loop=$tail step=1}
            </li></ul>
        {/section}

        {if $cat.NSLevel <= 1}
            <li>
        {/if}
        {if $cat.NSLevel <= 1}
            <a href="{$cat.cat_link}"{if $cat.id == $current_id || $cat.seolink == $current_seolink} class="active"{/if}>{$cat.title}{if $cfg.show_cat_count} ({$cat.movie_count}){/if}</a>
        {else}
            {if $cat.NSLevel > $last_level}
            	<ul class="nav nav-tree">
            {/if}
                <li>
					<a href="{$cat.cat_link}"{if $cat.id == $current_id || $cat.seolink == $current_seolink} class="active"{/if}>{$cat.title}{if $cfg.show_cat_count} ({$cat.movie_count}){/if}</a>
        {/if}
        {assign var="last_level" value=$cat.NSLevel}

    {/foreach}
    {section name=foo start=0 loop=$last_level step=1}
        </li></ul>
    {/section}

</ul>
<script type="text/javascript">    if (!jQuery) { throw new Error("Bootstrap Tree Nav requires jQuery"); }+function ($) {  'use strict';  $.fn.navTree = function(options) {    var defaults = {      navTreeExpanded: 'glyphicon glyphicon-collapse-up',      navTreeCollapsed: 'glyphicon glyphicon-collapse-down'    };    options = $.extend(defaults, options);    if ($(this).prop('tagName') === 'LI') {      collapsible(this, options);    } else if ($(this).prop('tagName') === 'UL') {      collapsible(this, options);    }  };  var collapsible = function(element, options) {    var $childrenLi = $(element).find('li');    $childrenLi.each(function(index, li) {      collapsibleAll($(li), options);      if ($(li).hasClass('{if !$cfg.expand_all}active{/if}')) {        $(li).parents('ul').each(function(i, ul) {          $(ul).show();          $(ul).siblings('span.opener')               .removeClass('closed')               .addClass('opened');          if ($(ul).siblings('a').attr('href') !== '#' && $(ul).siblings('a').attr('href') !== '') {            $(ul).siblings('a').off('click.bs.tree');          }        });      }    });  };  var collapsibleAll = function(element, options) {    var $childUl = $(element).children('ul');    if ( $childUl.length > 0 ) {      $childUl.hide();      $(element).prepend('<span class="opener closed"><span class="tree-icon-closed"><span class="' + options.navTreeCollapsed + '"></span></span><span class="tree-icon-opened"><span class="' + options.navTreeExpanded + '"></span></span></span>');      $(element).children('a').first().on('click.bs.tree', function(e) {        e.preventDefault();        var $opener = $(this).siblings('span.opener');        if ($opener.hasClass('closed')) {          expand(element);          if (($(this).attr('href') !== '#') && ($(this).attr('href') !== '')) {            $(this).off('click.bs.tree');          }        } else {          collapse(element);        }      });      $(element).children('span.opener').first().on('click.bs.tree', function(e){        var $opener = $(this);        if ($opener.hasClass('closed')) {          expand(element);        } else {          collapse(element);        }      });    }  };  var expand = function(element) {    var $opener = $(element).children('span.opener');    $opener.removeClass('closed').addClass('opened');    $(element).children('ul').first().slideDown('fast');  };  var collapse = function(element) {    var $opener = $(element).children('span.opener');    $opener.removeClass('opened').addClass('closed');    $(element).children('ul').first().slideUp('fast');  };  $('ul[data-toggle=nav-tree]').each(function(){    var $tree;    $tree = $(this);    $tree.navTree($tree.data());  });}(window.jQuery);</script>
{/if}