function checkImport(){

    var defined_cat     = $('select[name=cat_id]').val();
    var data_struct     = $('#data_struct').val();
    var struct_has_cat  = (data_struct.indexOf('category_id')>=0 || data_struct.indexOf('category')>=0);

    //alert(struct_has_cat+' '+defined_cat);

    if (defined_cat==0 && struct_has_cat==false){
        alert('Вы указали что категория для импорта будет определена в файле, но не включили поле "Категория" в шаблон структуры данных.');
        return;
    }

    $('form#import').submit();

}

function addToCSVTemplate(select_id){

    var param   = $('#'+select_id).val();
    var struct  = $('#data_struct').val();

    if (struct.length > 0){
        $('#data_struct').val(struct + ', ' + param);
    } else {
        $('#data_struct').val(param);
    }

    if (param == 'category' || param == 'category_id'){
        $('select#cat_id').val(0);
    }

}

function sendShopForm(component_id, opt, object_id, subject_id){

    var link = 'index.php?view=components&do=config&id='+component_id+'&opt='+opt;

    if (object_id && object_id.length > 0) {
        link = link + '&obj_id=' + object_id;
    }

    if (subject_id > 0) {
        link = link + '&subj_id=' + subject_id;
    }

    var sel  = checked();

    if (sel){
        if (opt!='delete_item' || confirm('Удалить отмеченные товары ('+sel+' шт.)?')){

            document.selform.action = link;
            document.selform.submit();

        }
    } else {
        alert('Нет отмеченных товаров');
    }
    
}

function sendShopFormShow(component_id, cat_id){

    var link = 'index.php?view=components&do=config&id='+component_id+'&opt=show_item';

    var sel  = checked();

    if (sel){
        document.selform.action = link;
        document.selform.submit();
    } else {
        if (cat_id > 0){
            if (confirm('Нет отмеченных товаров.\nОпубликовать все товары в этой категории?')){
                document.selform.action = link + '&cat_id='+cat_id;
                document.selform.submit();
            }
        } else {
            alert('Нет отмеченных товаров');
        }
    }

}


function sendShopFormHide(component_id, cat_id){

    var link = 'index.php?view=components&do=config&id='+component_id+'&opt=hide_item';

    var sel  = checked();

    if (sel){
        document.selform.action = link;
        document.selform.submit();
    } else {
        if (cat_id > 0){
            if (confirm('Нет отмеченных товаров.\nСкрыть все товары в этой категории?')){
                document.selform.action = link + '&cat_id='+cat_id;
                document.selform.submit();
            }
        } else {
            alert('Нет отмеченных товаров');
        }
    }

}

function varPriceChange(input, item_id, var_id){

    var price       = $('input.price'+item_id).val();
    var var_price   = $(input).val();

    if (var_price.length>0 && var_price != price){
        $(input).css('color', '#000');
        $('input.var_is_price'+var_id).val('1');
    } else {
        $(input).css('color', 'silver');
        $(input).val(price);
        $('input.var_is_price'+var_id).val('0');
    }

}

function varPriceClick(input,  var_id){

    var is_price = $('input.var_is_price'+var_id).val();

    if (is_price == 0){
        $(input).val('');
    }

}

function renameCharGroup(current_name){

    var new_name = prompt('Укажите название группы:', current_name);

    if (new_name){
        $('#rename_form input[name=new_name]').val(new_name);
        $('#rename_form').submit();
    }

}

function deleteCharGroup(current_name){

    if (confirm('Удалить группу "'+current_name+'"?')){        
        $('#delete_form').submit();
    }
    
}

function loadItemChars(component_id, cat_id, item_id){
    $('#item_chars').html('<p style="font-style:italic;color:#666;">Загрузка характеристик...</p>');
    $.ajax({
      type: "GET",
      url: "/admin/index.php",
      data: "view=components&do=config&id="+component_id+"&opt=load_chars&item_id="+item_id+"&cat_id="+cat_id,
      success: function(msg){
        $('#item_chars').html(msg);
      }
    });
}

function movePaySys(item_id, dir){

    var component_id = $('#selform input[name=id]').val();

	$.ajax({
		  type: "POST",
		  url: "/admin/index.php",
		  data: "view=components&do=config&id="+component_id+"&opt=move_psys&item_id="+item_id+"&dir="+dir,
		  success: function(msg){
            var trh = $('#listTable tr#'+item_id).html();
            if (dir == -1){
                $('#listTable tr#'+item_id).prev('tr').before('<tr id="'+item_id+'">'+trh+'</tr>').next('tr').remove();
            }
            if (dir == 1){
                $('#listTable tr#'+item_id).next('tr').after('<tr id="'+item_id+'">'+trh+'</tr>').prev('tr').remove();
            }
            $('#listTable tr').find('.move_item_up').show();
            $('#listTable tr').find('.move_item_down').show();
            $('#listTable tr').eq(1).find('.move_item_up').hide();
            $('#listTable tr').eq($('#listTable tr').length-1).find('.move_item_down').hide();
            $('#listTable tr#'+item_id).animate( {opacity:0.01}, 200 ).animate( {opacity:1}, 200 );
		  }
	});
    
}

function moveItem(item_id, dir){

    var component_id    = $('#filter_form input[name=id]').val();
    var cat_id          = $('#filter_form input[name=cat_id]').val();

	$.ajax({
		  type: "POST",
		  url: "/admin/index.php",
		  data: "view=components&do=config&id="+component_id+"&opt=move_item&item_id="+item_id+"&cat_id="+cat_id+"&dir="+dir,
		  success: function(msg){
            var trh = $('#listTable tr#'+item_id).html();
            if (dir == -1){
                $('#listTable tr#'+item_id).prev('tr').before('<tr id="'+item_id+'">'+trh+'</tr>').next('tr').remove();
            }
            if (dir == 1){
                $('#listTable tr#'+item_id).next('tr').after('<tr id="'+item_id+'">'+trh+'</tr>').prev('tr').remove();
            }
            $('#listTable tr').find('.move_item_up').show();
            $('#listTable tr').find('.move_item_down').show();
            $('#listTable tr').eq(1).find('.move_item_up').hide();
            $('#listTable tr').eq($('#listTable tr').length-1).find('.move_item_down').hide();
            $('#listTable tr#'+item_id).animate( {opacity:0.01}, 200 ).animate( {opacity:1}, 200 );
		  }
	});
}

function moveChar(item_id, dir){

    var component_id    = $('#bind_form input[name=id]').val();
    var cat_id          = $('#bind_form input[name=cat_id]').val();

	$.ajax({
		  type: "POST",
		  url: "/admin/index.php",
		  data: "view=components&do=config&id="+component_id+"&opt=move_char&item_id="+item_id+"&cat_id="+cat_id+"&dir="+dir,
		  success: function(msg){
            var trh = $('#listTable tr#'+item_id).html();
            if (dir == -1){
                $('#listTable tr#'+item_id).prev('tr').before('<tr id="'+item_id+'">'+trh+'</tr>').next('tr').remove();
            }
            if (dir == 1){
                $('#listTable tr#'+item_id).next('tr').after('<tr id="'+item_id+'">'+trh+'</tr>').prev('tr').remove();
            }
            $('#listTable tr').find('.move_item_up').show();
            $('#listTable tr').find('.move_item_down').show();
            $('#listTable tr').eq(1).find('.move_item_up').hide();
            $('#listTable tr').eq($('#listTable tr').length-1).find('.move_item_down').hide();
            $('#listTable tr#'+item_id).animate( {opacity:0.01}, 200 ).animate( {opacity:1}, 200 );
		  }
	});
}

function compare(id, qs, qs2, action, action2){
	$('img#compare'+id).attr('src', 'images/actions/loader.gif');
    $('a#comparelink'+id).attr('href', '');
	$.ajax({
		  type: "GET",
		  url: "index.php",
		  data: qs,
		  success: function(msg){
			$('img#compare'+id).attr('src', 'components/shop/images/'+action+'.gif');
			$('a#comparelink'+id).attr('href', 'javascript:compare('+id+', "'+qs2+'", "'+qs+'", "'+action2+'", "'+action+'");');
		  }
	});
}

function filter(id, qs, qs2, action, action2){
	$('img#filter'+id).attr('src', 'images/actions/loader.gif');
    $('a#filterlink'+id).attr('href', '');
	$.ajax({
		  type: "GET",
		  url: "index.php",
		  data: qs,
		  success: function(msg){
			$('img#filter'+id).attr('src', 'components/shop/images/'+action+'.gif');
			$('a#filterlink'+id).attr('href', 'javascript:filter('+id+', "'+qs2+'", "'+qs+'", "'+action2+'", "'+action+'");');
		  }
	});
}

function front(id, qs, qs2, action, action2){
	$('img#front'+id).attr('src', 'images/actions/loader.gif');
    $('a#frontlink'+id).attr('href', '');
	$.ajax({
		  type: "GET",
		  url: "index.php",
		  data: qs,
		  success: function(msg){
			$('img#front'+id).attr('src', 'components/shop/images/'+action+'.gif');
			$('a#frontlink'+id).attr('href', 'javascript:front('+id+', "'+qs2+'", "'+qs+'", "'+action2+'", "'+action+'");');
		  }
	});
}

function hit(id, qs, qs2, action, action2){
	$('img#hit'+id).attr('src', 'images/actions/loader.gif');
    $('a#hitlink'+id).attr('href', '');
	$.ajax({
		  type: "GET",
		  url: "index.php",
		  data: qs,
		  success: function(msg){
			$('img#hit'+id).attr('src', 'components/shop/images/'+action+'.gif');
			$('a#hitlink'+id).attr('href', 'javascript:hit('+id+', "'+qs2+'", "'+qs+'", "'+action2+'", "'+action+'");');
		  }
	});
}

function spec(id, qs, qs2, action, action2){
	$('img#spec'+id).attr('src', 'images/actions/loader.gif');
    $('a#speclink'+id).attr('href', '');
	$.ajax({
		  type: "GET",
		  url: "index.php",
		  data: qs,
		  success: function(msg){
			$('img#spec'+id).attr('src', 'components/shop/images/'+action+'.gif');
			$('a#speclink'+id).attr('href', 'javascript:spec('+id+', "'+qs2+'", "'+qs+'", "'+action2+'", "'+action+'");');
		  }
	});
}

function updateVariants(){
    if ($('table#variants tr.var').length <= 1){
        $('table#variants td.char_del').hide();
    }
}
function addVariant(){
    $('table#variants tr').eq(1).clone().appendTo('table#variants').find('input').val('');
    if ($('table#variants tr.var').length > 1){
        $('table#variants td.char_del').show();
    }
}

function deleteVariant(link){
    $(link).parent('td').parent('tr').remove();
    if ($('table#variants tr.var').length == 1){
        $('table#variants td.char_del').hide();
    }
}

function toggleBindAll(){
    if(document.addform.bind_all.checked){
		$('select#cats').attr('disabled', 'disabled');
	} else {
		$('select#cats').attr('disabled', '');
	}
}


function copyItem(com_id, item_id){
	var copies = prompt('Количество копий:', 1);
	if (copies>0){
		window.location.href='/admin/index.php?view=components&do=config&id='+com_id+'&opt=copy_item&item_id='+item_id+'&copies='+copies;	
	}
}

function copyCat(com_id, item_id){
	var copies = prompt('Количество копий:', 1);
	if (copies>0){
		window.location.href='/admin/index.php?view=components&do=config&id='+com_id+'&opt=copy_cat&item_id='+item_id+'&copies='+copies;	
	}
}

function xlsEditRow(){
    var r = $('input#title_row').val();
    $('input.row').val(r);
}

function xlsEditCol(){
    var c = Number($('input#title_col').val());

    $("input.col").each(function (i) {
        $(this).val(i+c+1);
    });
}

function ignoreRow(row){
    var r_id = 'row_'+row;
    var c_id = 'ignore_'+row;
    var checked = Number($('input:checkbox[@id='+c_id+']').attr('checked'));
    if(checked){
        $('tr#'+r_id+' input:text[@class!=other]').attr('disabled', 'disabled');
        $('tr#'+r_id+' input:text[@class=other]').attr('disabled', '');
    } else {
        $('tr#'+r_id+' input:text[@class!=other]').attr('disabled', '');
        $('tr#'+r_id+' input:text[@class=other]').attr('disabled', 'disabled');
    }
}

function toggleDiscountLimit(){
    var sign = Number($('select#sign').val());

    if (sign==3){$('tr.if_limit').show();}
    else {$('tr.if_limit').hide();}
}

function checkGroupList(){

	if(document.addform.is_public.checked){
		$('select#showin').attr('disabled', '');
	} else {
		$('select#showin').attr('disabled', 'disabled');
	}

}

function updateDiscounts(){

    if ($('table#discounts tr.var').length <= 1){
        $('table#discounts td.char_del').hide();
    }

}

function addDiscount(){
    $('table#discounts tr').eq(1).clone().appendTo('table#discounts').find('input').val('');
    if ($('table#discounts tr.var').length > 1){
        $('table#discounts td.char_del').show();
    }
}

function deleteDiscount(link){
    $(link).parent('td').parent('tr').remove();
    if ($('table#discounts tr.var').length == 1){
        $('table#discounts td.char_del').hide();
    }
}



